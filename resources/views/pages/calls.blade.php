<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a></li>
    <li class="breadcrumb-item active">コール一覧</li>
  </x-breadcrumb>
  <x-h2>{{ $survey->title }}: コール一覧</x-h2>
  <div class="card p-2 mb-4">
    <form method="post" id="csvForm">
      @csrf
    </form>
    <form id="params">
      <table class="table table-borderless mb-0">
        <tbody>
          <tr>
            <td>ステータス</td>
            <td class="d-flex gap-4">
              @foreach (config('app.CALL_STATUS') as $status)
                <div class="form-check">
                  <input
                    class="form-check-input"
                    type="checkbox"
                    value="{{ $status['id'] }}"
                    name="status[]"
                    id="callStatus{{ $status['id'] }}"
                    {{ in_array($status['id'], $status) ? "checked" : "" }}
                  >
                  <label class="form-check-label" for="callStatus{{ $status['id'] }}">
                    <span class="badge bg-{{ $status["bg"] }}">{{ $status["text"] }}</span>
                  </label>
                </div>
              @endforeach
            </td>
          </tr>
          <tr>
            <td>開始日 ~ 終了日</td>
            <td>
              <div class="input-group mb-0" style="max-width: 360px;">
                <input
                type="date" name="start" class="form-control form-control-sm"
                value="{{ request()->start ?? date('Y-m-d', strtotime('first day of this month')) }}">
                <span class="input-group-text">~</span>
                <input
                type="date" name="end" class="form-control form-control-sm"
                value="{{ request()->end ?? date('Y-m-d', strtotime('last day of this month')) }}">
              </div>
            </td>
          </tr>
          <tr>
            <td>電話番号（ハイフン必須）</td>
            <td>
              <input
                type="text"
                name="number"
                class="form-control form-control"
                value="{{ request()->number }}"
                style="max-width:180px;"
                list="stationsList"
              >
              <datalist id="stationsList">
                @foreach ($stations as $station)
                  <option value="{{ $station->prefix }}">{{ $station->area->title }}</option>
                @endforeach
              </datalist>
            </td>
          </tr>
          {{-- <tr>
            <td><label for="actionCountRange" class="form-label">アクション数</label></td>
            <td>
              <div class="d-flex justify-content-between">
                @for ($i = 0; $i <= count($survey->faqs); $i++)
                  <div>{{$i}}~</div>
                @endfor
              </div>
              <input
                type="range" name="action_count" class="form-range"
                min="0" max="{{ count($survey->faqs) }}" id="actionCountRange"
                value="{{ request()->action_count ?? 0 }}"
              >
            </td>
          </tr> --}}
        </tbody>
      </table>
      <div class="position-absolute top-0 end-0 p-2">  
        <button class="btn btn-outline-success" form="csvForm">CSV出力</button>
        <button class="btn btn-primary">確定</button>
      </div>
    </form>
  </div>
  @if ($calls)
    <p class="mb-1">{{ "{$pgnt["current"]} / {$pgnt["last_page"]}ページ目 - {$pgnt["current_start"]}~{$pgnt["current_end"]} / {$pgnt["sum"]}件表示中" }}</p>
    {{-- <div class="card bg-light mb-3">
      <div class="card-body">
        <table class="table table-light table-sm mb-0">
          <tr>
            <th>総コール数</th>
            <td>{{ number_format($stats["all_calls"]) }}件</td>
            <th>平均アクション数</th>
            <td>{{ round($stats["all_actions"] / $stats["responsed_calls"], 2) }}回</td>
            <th>応答率</th>
            <td>
              {{ round($stats["responsed_calls"] / $stats["all_calls"] * 100, 2) }}%<br>
              ({{ number_format($stats["responsed_calls"]) }} / {{ number_format($stats["all_calls"]) }})
            </td>
          </tr>
          <tr>
            <th>アクション率</th>
            <td>
              {{ round($stats["action_calls"] / $stats["responsed_calls"] * 100) }}%<br>
              ({{ number_format($stats["action_calls"]) }} / {{ number_format($stats["responsed_calls"]) }})
            </td>
            <th>成功率</th>
            <td>
              {{ round($stats["success_calls"] / $stats["responsed_calls"] * 100) }}%<br>
              ({{ number_format($stats["success_calls"]) }} / {{ number_format($stats["responsed_calls"]) }})
            </td>
          </tr>
        </table>
      </div>
    </div> --}}
    <div class="calls-table-container">
      <table class="table table-bordered table-hover calls-table">
        <thead class="sticky-top">
          <tr>
            <th>ID</th>
            <th>日付・時間</th>
            <th>電話番号</th>
            <th>ステータス</th>
            <th>通話成立時間</th>
            <th>アクション数</th>
            @foreach ($survey->faqs as $faq)
              <th><a href="/faqs/{{ $faq["id"] }}">{{ $faq["title"] }}</a></th>
            @endforeach
          </tr>
        </thead>
        <tbody>
          @foreach ($calls as $call)
            <tr onclick="window.location.assign('/calls/{{ $call['id'] }}')">
              <td>{{ $call->id }}</td>
              <td><a href="/reservations/{{ $call->reservation_id }}">{{ $call->reservation->date }}</a> |  {{ $call->time }}</td>
              <td>{{ $call->tel }}</td>
              <td>{{ $call->status()["text"] }}</td>
              <td>{{ $call->duration }}</td>
              <td>{{ $call->action_count }}</td>
              @foreach ($survey->faqs as $faq)
                @php
                  $answer = $call->answers()->where('faq_id', $faq->id)->first()
                @endphp
                <td>
                  @if ($answer)
                    {{ $answer->option->title }}
                  @else
                    -
                  @endif
                </td>
              @endforeach
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    <x-pagenation :pgnt="$pgnt" />
  @else
    <x-noContent>該当するデータがありません、検索条件を変更して再検索してください</x-noContent>
  @endif
  <x-watchOnAdmin />
</x-layout>
