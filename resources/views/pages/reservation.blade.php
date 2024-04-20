<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $reservation->survey->id }}">{{ $reservation->survey->title }}</a></li>
    @if (request()->session()->has("referer"))
      <li class="breadcrumb-item">
        <a href="{{ request()->session()->get("referer")["link"] }}">
          {{ request()->session()->get("referer")["text"] }}
        </a>
      </li>
    @endif
    <li class="breadcrumb-item active">予約: {{ date("n月d日", strtotime($reservation->date)) }}</li>
  </x-breadcrumb>
  <x-h2>予約: {{ date("n月d日", strtotime($reservation->date)) }}</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      @if ($reservation->status_id === 1)
        <section id="tel_list">
          <x-h3>架電リスト選択</x-h3>
          <x-numberSetting
          :survey="$survey"
          :selected_areas="$reservation->areas"
          :areas="$areas"
          selected_tel_list_id="{{ $reservation->tel_list_id }}"
          form_id="updateReservationForm"
          attach_area_url="/reservations/{{ $reservation->id }}/attach_area" />
        </section>
        <hr class="my-4">
      @else
        <section id="file">
          <x-h3>ファイル</x-h3>
          <div class="row">
            <div class="col">
              <div class="mb-2">予約情報ファイル</div>
              @if ($reservation->reservation_file)
                <a class="btn btn-primary" href="{{ url("/storage/users/{$survey->user_id}/{$reservation->reservation_file}") }}" download>
                  <span class="me-1">
                    <i class="fa-solid fa-download fa-lg"></i>
                  </span>ダウンロード
                </a>
              @else
                <button class="btn btn-primary" disabled>
                  <span class="me-1">
                    <i class="fa-solid fa-download fa-lg"></i>
                  </span>ダウンロード
                </button>
              @endif
              <div class="form-text">確定済になるとダウンロードが可能になります</div>
            </div>
            <div class="col">
              <div class="mb-2">結果ファイル</div>
              @if ($reservation->result_file)
                <a class="btn btn-primary" href="{{ url("/storage/uploads/{$reservation->result_file}") }}" download>
                  <span class="me-1">
                    <i class="fa-solid fa-download fa-lg"></i>
                  </span>ダウンロード
                </a>
              @else
                <button class="btn btn-primary" disabled>
                  <span class="me-1">
                    <i class="fa-solid fa-download fa-lg"></i>
                  </span>ダウンロード
                </button>
              @endif
              <div class="form-text">集計済になるとダウンロードが可能になります</div>
            </div>
          </div>
        </section>
        @if (@$stats["all_calls"])
          <hr class="my-4">
          <section id="result">
            <x-h3>結果</x-h3>
            <div class="card bg-light mb-3">
              <div class="card-body">
                <table class="table table-light table-sm mb-0">
                  <tr>
                    <th>総コール数</th>
                    <td>{{ number_format($stats["all_calls"]) }}件</td>
                    <th>応答率</th>
                    <td>
                      {{ round($stats["responsed_calls"] / $stats["all_calls"] * 100) }}%<br>
                      ({{ number_format($stats["responsed_calls"]) }} / {{ number_format($stats["all_calls"]) }})
                    </td>
                  </tr>
                  <tr>
                    <th>成功率</th>
                    <td>
                      {{ round($stats["success_calls"] / $stats["responsed_calls"] * 100) }}%<br>
                      ({{ number_format($stats["success_calls"]) }} / {{ number_format($stats["responsed_calls"]) }})
                    </td>
                    <th>平均アクション数</th>
                    <td>{{ round($stats["all_actions"] / $stats["responsed_calls"], 2) }}回</td>
                  </tr>
                  <tr>
                    <th>アクション率</th>
                    <td>
                      {{ round($stats["action_calls"] / $stats["responsed_calls"] * 100) }}%<br>
                      ({{ number_format($stats["action_calls"]) }} / {{ number_format($stats["responsed_calls"]) }})
                    </td>
                    <th>料金</th>
                    <td>
                      ¥{{ number_format(round($stats["total_duration"] * config('app.PRICE_PER_SECOND'))) }}<br>
                      ({{ number_format($stats["total_duration"]) }}秒 x ¥{{ config('app.PRICE_PER_SECOND') }})
                    </td>
                  </tr>
                </table>
              </div>
            </div>
            <div class="mb-3">
              <a
                href="/surveys/{{ $survey->id }}/calls?start={{ $reservation->date }}&end={{ $reservation->date }}"
                class="btn btn-outline-primary"
              >
                <span class="me-1"><i class="fa-solid fa-table fa-lg"></i></span>コール一覧
              </a>
              <div class="form-text">CSVファイルのダウンロードはこちらからできます</div>
            </div>
            @foreach ($survey->faqs as $faq)
              <div class="card mb-2" id="faq{{ $faq->id }}">
                <div class="card-body">
                  <h5 class="card-title mb-3">
                    <span class="badge bg-primary-subtle text-black me-2">質問</span>{{ $faq->title }}
                  </h5>
                  <p class="card-text">{{ $faq->text }}</p>
                  @if ($faq->options)
                    <table class="table table-sm mb-0">
                      <thead>
                        <tr>
                          <th scope="col">ダイヤル番号</th>
                          <th scope="col">TITLE</th>
                          <th scope="col">NEXT</th>
                          <th class="table-primary" style="text-align: right; width: 90px;">count</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($faq->options as $option)
                        <tr>
                          <th scope="row"><span class="">{{ $option->dial }}</span></th>
                          <td>{{ $option->title }}</td>
                          <td>
                            @if ($option->next_faq)
                              @if ($option->next_faq->id !== $faq->id)
                                <a href="/faqs/{{ $option->next_faq->id }}" class="badge bg-primary-subtle text-black" style="text-decoration: none;">
                                  {{ $option->next_faq->title; }}
                                </a>
                              @else
                                <span class="badge bg-info-subtle text-black">聞き直し</span>
                              @endif
                              @elseif ($option->next_ending)
                                <span class="badge bg-dark-subtle text-black">{{ $option->next_ending->title }}</span>
                              @endif
                          </td>
                          <td class="table-primary" style="text-align: right;">
                            {{ number_format($reservation->answers()->where('option_id', $option->id)->count()) }}
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                    </table>
                  @endif
                </div>
              </div>
            @endforeach

          </section>
        @endif
      @endif
    </div>
    <div class="flex-shrink-0 sticky-aside" style="width: 300px;">
      <div class="sticky-top">
        <section id="summary">
          <x-h4>基本設定</x-h4>
          <form method="post" id="updateReservationForm">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">開始時間・終了時間</label>
              <div class="input-group">
                <select name="start_at" class="form-select" required {{ $reservation->status_id !== 1 ? "disabled" : "" }}>
                  <option value="">選択してください</option>
                  @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
                  <option value="{{ date("H:i", $ts) }}" {{ $reservation->start_at == date("H:i:s", $ts) ? "selected" : ""; }}>
                    {{ date("H:i", $ts) }}
                  </option>
                  @endforeach
                </select>
                <span class="input-group-text">~</span>
                <select name="end_at" class="form-select" required {{ $reservation->status_id !== 1 ? "disabled" : "" }}>
                  <option value="">選択してください</option>
                  @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
                  <option value="{{ date("H:i", $ts) }}" {{ $reservation->end_at == date("H:i:s", $ts) ? "selected" : ""; }}>
                    {{ date("H:i", $ts) }}
                  </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">ステータス</label>
              <div>
                <span class="badge text-bg-{{ $reservation->status->bg }} bg-gradient fs-6">
                  {{ $reservation->status->title }}
                </span>
              </div>
            </div>
          </form>
          @if ($reservation->tel_list)
            <div class="mb-3">
              <label class="form-label">マイリスト</label>
              <div class="mb-2">
                <x-telList :tel_list="$reservation->tel_list" />
              </div>
            </div>
          @else
            <div class="mb-3">
              <label class="form-label">エリア</label>
              @if ($reservation->areas)
                <div>
                  @foreach ($reservation->areas as $area)
                    <span class="badge bg-secondary fs-6 mb-1">
                      <form action="/reservations/{{ $reservation->id }}/detach_area" method="post">
                        @csrf
                        <input type="hidden" name="area_id" value="{{ $area->id }}">
                        {{ $area->title }}
                        @if (@$favorite || $reservation->status_id === 1)
                          <button type="submit" class="d-inline bg-transparent border-0">
                            <i class="fa-solid fa-xmark text-white"></i>
                          </button>
                        @endif
                      </form>
                    </span>
                  @endforeach
                </div>
              @else
                <x-noContent>局番が設定されていません</x-noContent>
              @endif
            </div>
          @endif
          <div class="text-end">
            <button
              type="submit" class="btn btn-dark" form="updateReservationForm"
              {{ @$favorite || $reservation->status_id === 1 ? "" : "disabled" }}
            >
              更新
            </button>
          </div>
          @if (@$favorite || $reservation->status_id === 1)
            <form method="post" onsubmit="return window.confirm('本当に削除しますか？')">
              @csrf
              @method('DELETE')
              <input type="hidden" name="redirect" value="{{ request()->session()->get("referer")["link"] }}">
              <div class="text-end">
                <input
                  type="submit" class="btn btn-link"
                  value="この予約を削除"
                >
              </div>
            </form>
          @else
            <div class="form-text">確定後の予約は削除できません</div>
          @endif
        </section>
      </div>
    </div>
  </div>

  <x-watchOnAdmin />
</x-layout>