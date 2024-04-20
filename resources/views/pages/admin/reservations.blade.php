<x-layout>
  <div class="pt-3">
    <x-h2>全ての予約</x-h2>
  </div>
  <div class="card p-2 mb-4">
    <form id="params">
      <table class="table table-borderless mb-0">
        <tbody>
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
        </tbody>
      </table>
      <div class="position-absolute top-0 end-0 p-2">  
        <button class="btn btn-primary">確定</button>
      </div>
    </form>
  </div>
  <p>{{ "{$pgnt["current"]} / {$pgnt["last_page"]}ページ目 - {$pgnt["current_start"]}~{$pgnt["current_end"]} / {$pgnt["sum"]}件表示中" }}</p>
  @if ($reservations)
    <table class="table">
      <thead>
        <tr>
          <th>ID</th>
          <th>アンケート</th>
          <th>ユーザー</th>
          <th>日付</th>
          <th>開始・終了時間</th>
          <th>マイリスト</th>
          <th>ステータス</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
        @foreach ($reservations as $reservation)
          <tr>
            <th>{{ $reservation->id }}</th>
            <td><a href="/surveys/{{ $reservation->survey_id }}">{{ $reservation->survey->title }}</a></td>
            <td><a href="/users/{{ $reservation->survey->user_id }}">{{ $reservation->survey->user->email }}</a></td>
            <td><a href="/reservations/{{ $reservation->id }}">{{ $reservation->date }}</a></td>
            <td>{{ substr($reservation->start_at, 0, -3) . " ~ " . substr($reservation->end_at, 0, -3) }}</td>
            <td>
              @if ($reservation->tel_list_id)
                <a href="/tel_lists/{{ $reservation->tel_list_id }}">
                  {{ $reservation->tel_list->title }}
                </a>
              @endif
            </td>
            <td>
              <span class="badge text-bg-{{ $reservation->status->bg }} bg-gradient fs-6 me-1">
                {{ $reservation->status->title }}
              </span>
            </td>
            <td>
              @if ($reservation->status_id === 1)
                <form action="/admin/reservations/{{ $reservation->id }}/forward_confirmed" method="post">
                  @csrf
                  <button class="btn btn-outline-primary">確定済にする</button>
                </form>
              @elseif ($reservation->status_id === 2)
                <form action="/admin/reservations/{{ $reservation->id }}/back_reservationd" method="post">
                  @csrf
                  <div class="btn-group">
                    <button class="btn btn-outline-primary">予約済に戻す</button>
                    <button
                      type="button"
                      class="btn btn-outline-primary"
                      data-bs-toggle="modal"
                      data-bs-target="#reservation{{ $reservation->id }}ForwardCollectedModal"
                    >集計済にする</button>
                  </div>
                </form>
              @elseif ($reservation->status_id === 3)
                <form action="/admin/reservations/{{ $reservation->id }}/back_confirmed" method="post">
                  @csrf
                  <button class="btn btn-outline-primary">確定済に戻す</button>
                </form>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <ul class="pagination mb-0 mt-4" style="justify-content: center;">
      @if ($pgnt["first"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["first"] }}" form="params" class="page-link" href="#">
            <i class="fa-solid fa-angles-left"></i>
          </button>
        </li>
      @endif
      @if ($pgnt["pprev"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["pprev"]  }}" form="params" class="page-link" href="#">
            {{ $pgnt["pprev"] }}
          </button>
        </li>
      @endif
      @if ($pgnt["prev"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["prev"]  }}" form="params" class="page-link" href="#">
            {{ $pgnt["prev"] }}
          </button>
        </li>
      @endif
      @if ($pgnt["current"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["current"] }}" form="params" class="page-link active" href="#">
            {{ $pgnt["current"] }}
          </button>
        </li>
      @endif
      @if ($pgnt["next"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["next"]  }}" form="params" class="page-link" href="#">
            {{ $pgnt["next"] }}
          </button>
        </li>
      @endif
      @if ($pgnt["nnext"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["nnext"]  }}" form="params" class="page-link" href="#">
            {{ $pgnt["nnext"] }}
          </button>
        </li>
      @endif
      @if ($pgnt["last"])
        <li class="page-item">
          <button name="page" value="{{ $pgnt["last"]  }}" form="params" class="page-link" href="#">
            <i class="fa-solid fa-angles-right"></i>
          </button>
        </li>
      @endif
    </ul>
  @else
    <x-noContent>該当するデータがありません、検索条件を変更して再検索してください</x-noContent>
  @endif

  @foreach ($reservations as $reservation)
    <x-modal id="reservation{{ $reservation->id }}ForwardCollectedModal" title="確定済にする" size="lg">
      <h6>対象の予約</h6>
      <table class="table">
        <thead>
          <tr>
            <th>ID</th>
            <th>アンケート</th>
            <th>ユーザー</th>
            <th>日付</th>
            <th>開始・終了時間</th>
          </tr>
        <tbody>
          <tr>
            <th>{{ $reservation->id }}</th>
            <td><a href="/surveys/{{ $reservation->survey_id }}">{{ $reservation->survey->title }}</a></td>
            <td><a href="/users/{{ $reservation->user_id }}">{{ $reservation->survey->user->email }}</a></td>
            <td><a href="/reservations/{{ $reservation->id }}">{{ $reservation->date }}</a></td>
            <td>{{ substr($reservation->start_at, 0, -3) . " ~ " . substr($reservation->end_at, 0, -3) }}</td>
          </tr>
        </tbody>
      </table>
      <hr class="my-3">
      <h6>結果ファイルをインポート</h6>
      <div class="row align-items-end">
        <div class="col">
          <div style="max-width: 320px;">
            <form action="/admin/reservations/{{ $reservation->id }}/forward_collected" method="post" enctype="multipart/form-data">
              @csrf
              <div class="mb-3">
                <label class="form-label">結果ファイル</label>
                <input type="file" name="file" class="form-control" required>
              </div>
              <div class="text-end">
                <button type="submit" class="btn btn-success">実行</button>
              </div>
            </form>
          </div>
        </div>
        <div class="col ">
          <form action="/admin/reservations/{{ $reservation->id }}/generate_sample_result" method="post">
            @csrf
            <button type="submit" class="btn btn-link" style="font-size: 14px;">【テスト用】予約ファイルからサンプル結果ファイルを生成</button>
          </form>
        </div>
      </div>
    </x-modal>
  @endforeach
</x-layout>