<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a></li>
    <li class="breadcrumb-item active">カレンダー {{ date("Y", $calendar->getCurrent()) }}年 {{ date("n", $calendar->getCurrent()) }}月</li>
  </x-breadcrumb>
  <x-h2>カレンダー</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      <section id="calendar">
        <div class="text-center mb-4">
          <div class="btn-group">
            <a href="/surveys/{{ $survey->id }}/reservations/{{ date('Y', $calendar->getPrev()) }}/{{ date('m', $calendar->getPrev()) }}/{{ $mode }}" class="btn btn-outline-dark px-3">
              <i class="fa-solid fa-angle-left fa-xl"></i>
            </a>
            <button class="btn btn-dark px-5">
              <span class="fw-bold">
                {{ date("Y", $calendar->getCurrent()) }}年 {{ date("n", $calendar->getCurrent()) }}月
              </span>
            </button>
            <a href="/surveys/{{ $survey->id }}/reservations/{{ date('Y', $calendar->getNext()) }}/{{ date('m', $calendar->getNext()) }}/{{ $mode }}" class="btn btn-outline-dark px-3">
              <i class="fa-solid fa-angle-right fa-xl"></i>
            </a>
          </div>
        </div>
        @if ($mode === "month")
          <table class="calendar-table table table-sm table-bordered">
            <thead class="text-center">
              <tr>
                @foreach (range(0, 6) as $w)
                  <th scope="col">{{ $calendar->jweek($w)  }}</th>
                @endforeach
              </tr>
            </thead>
            <tbody>
              @foreach ($calendar->getCalendar() as $week)
                <tr>
                  @foreach ($week as $day)
                    <td class="position-relative" style="height: 100px;">
                      @if ($day)
                        <div class="text-center mb-1">
                          <span class="{{ $day->today ? "text-bg-primary badge" : ""; }}">
                            {{ date("j", $day->timestamp); }}
                          </span>
                        </div>
                        @if ($reservation = $day->schedule)
                          <a
                          class="badge lh-sm text-bg-{{ $reservation->status->bg }} bg-gradient text-wrap w-100" style="text-decoration: none;"
                          href="/reservations/{{ $reservation->id }}"
                          >
                            {{ date("H:i", strtotime($reservation->start_at)) }} - {{ date("H:i", strtotime($reservation->end_at)) }}
                            @if ($reservation->tel_list)
                              マイリスト: {{ $reservation->tel_list->title }}
                            @elseif (count($reservation->areas) === 0)
                              <div class="text-danger py-2">
                                <span href="#" data-bs-toggle="tooltip" data-bs-title="エリアが指定されていません">
                                  <i class="fa-solid fa-circle-exclamation fa-2xl"></i>
                                </span>
                              </div>
                            @elseif (count($reservation->areas) < 4)
                              @foreach ($reservation->areas as $area)
                                {{ $area["title"] }}
                              @endforeach
                            @else
                              {{ count($reservation->areas) }}件のエリア
                            @endif
                          </a>
                        @else
                          @if (time() < $day->timestamp + config('app.RESERVATION_DEADLINE_HOUR') * 3600)
                            <button
                            type="button"
                            class="day-modal-button"
                            data-bs-toggle="modal"
                            data-bs-target="#dayModal"
                            data-bs-whatever="{{ $day->timestamp }}"
                            >
                              <i class="fa-solid fa-plus fa-2xl"></i>
                            </button>
                          @endif
                        @endif
                      @endif
                    </td>
                  @endforeach
                </tr>
              @endforeach
            </tbody>
          </table>
        @elseif ($mode === "schedule")
          <div class="mb-3">
            @if ($reservations)
              <div class="calls-table-container mb-4">
                <table class="table mb-0">
                  <thead>
                    <tr>
                      <th>ID</th>
                      <th>日付</th>
                      <th>開始・終了時間</th>
                      <th>マイリスト</th>
                      <th>ステータス</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($reservations as $reservation)
                      <tr>
                        <th>{{ $reservation->id }}</th>
                        <td><a href="/reservations/{{ $reservation['id'] }}">{{ $reservation->date }}</a></td>
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
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            @else
              <x-noContent>該当するデータがありません、検索条件を変更して再検索してください</x-noContent>
            @endif
            <x-modalOpenButton target="createReservationModal" />
          </div>
        @endif
        <div class="row justify-content-between">
          <div class="col-8 form-text">
            <div class="d-flex align-items-center gap-2">
              ステータスの凡例: 
              @foreach ($statuses as $status)
                <span class="badge text-bg-{{ $status["bg"] }} bg-gradient fw-normal" style="font-size: 14px;">
                  {{ $status["title"] }}
                </span>
              @endforeach
            </div>
          </div>
          <div class="col-4 btn-group" role="group" aria-label="Basic outlined example">
            <a href="/surveys/{{ $survey->id }}/reservations/{{ date('Y', $calendar->getCurrent()) }}/{{ date('m', $calendar->getCurrent()) }}/month"
            class="btn btn-outline-primary {{ $mode === "month" ? "active" : "" }}">
              <i class="fa-solid fa-calendar fa-lg" aria-hidden="true"></i>
            </a>
            <a href="/surveys/{{ $survey->id }}/reservations/{{ date('Y', $calendar->getCurrent()) }}/{{ date('m', $calendar->getCurrent()) }}/schedule"
            class="btn btn-outline-primary {{ $mode === "schedule" ? "active" : "" }}">
              <i class="fa-solid fa-table-list fa-lg" aria-hidden="true"></i>
            </a>
          </div>
        </div>
      </section>
    </div>
    <div class="flex-shrink-0 sticky-aside" style="width: 300px;">
      <div class="sticky-top">
        <section id="favorite">
          <x-h4>予約パターン</x-h4>
          <div class="form-text mb-2 vstack gap-1">
            <span>開始・終了時間やエリア設定のテンプレートを利用してスムーズに予約の指定ができます。</span>
            <span>予約パターンの適用後に各日付ごとに設定を変更することも可能です。</span>
          </div>
          @if ($survey->favorites()->exists())
            @foreach ($survey->favorites as $favorite)
              <div class="mb-2">
                <x-favorite :favorite="$favorite" />
              </div>
            @endforeach
          @else
            <x-noContent>予約パターンがありません</x-noContent>
          @endif
          <a href="/surveys/{{ $survey->id }}/asset#favorite" class="btn btn-link">予約パターンを編集</a>
        </section>
      </div>
    </div>
  </div>

  <x-modal id="dayModal" title="">
    <x-h4>予約パターンから予約</x-h4>
    @foreach ($survey->favorites as $favorite)
      <div class="card mb-2">
        <div class="card-body">
          <h5 class="card-title">
            <span class="badge me-2 p-2" style="background-color: {{ $favorite->color }};">　</span>  
            {{ $favorite->title }}
          </h5>
          <table class="table table-sm mb-0">
            <tbody>
              <tr>
                <th nowrap>時間</th>
                <td>{{ date("H:i", strtotime($favorite->start_at)) }} - {{ date("H:i", strtotime($favorite->end_at)) }}</td>
              </tr>
              <tr>
                @if ($favorite->tel_list_id)
                  <th nowrap>マイリスト</th>
                  <td>{{ $favorite->tel_list->title }}</td>
                @else
                  <th nowrap>エリア</th>
                  <td>
                    @if (count($favorite->areas) < 4)
                      @foreach ($favorite->areas as $area)
                        {{ $area["title"] }}
                      @endforeach
                    @else
                      {{ count($favorite->areas) }}件のエリア
                    @endif
                  </td>
                @endif
              </tr>
            </tbody>
          </table>
          <div class="position-absolute top-0 end-0 p-3">
            <form action="/surveys/{{ $survey->id }}/reservations" method="post">
              @csrf
              <input type="hidden" name="survey_id" value="{{ $survey->id }}">
              <input type="hidden" name="date" class="date-input">
              <input type="hidden" name="favorite_id" value="{{ $favorite->id }}">
              <button type="submit" class="btn btn-primary">このパターンで予約</button>
            </form>
          </div>
        </div>
      </div>
    @endforeach
    <hr class="my-4">
    <x-h4>手動で予約</x-h4>
    <form action="/surveys/{{ $survey->id }}/reservations" method="post">
      @csrf
      <div class="mb-3">
        <label class="form-label">開始時間・終了時間</label>
        <div class="input-group">
          <select name="start_at" class="form-select" required>
            <option value="">選択してください</option>
            @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
            <option value="{{ date("H:i", $ts) }}">
              {{ date("H:i", $ts) }}
            </option>
            @endforeach
          </select>
          <span class="input-group-text">~</span>
          <select name="end_at" class="form-select" required>
            <option value="">選択してください</option>
            @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
            <option value="{{ date("H:i", $ts) }}">
              {{ date("H:i", $ts) }}
            </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="text-end">
        <input type="hidden" name="survey_id" value="{{ $survey->id }}">
        <input type="hidden" name="date" class="date-input">
        <button type="submit" class="btn btn-secondary">ページを移動してエリアを設定</button>
      </div>
    </form>
  </x-modal>

  <x-modal id="createReservationModal" title="予約">
    <form action="/surveys/{{ $survey->id }}/reservations" method="post">
      @csrf
      <div class="mb-3">
        <label class="form-label">日付</label>
        <input type="date" name="date" class="form-control" min="{{ date("Y-m-d", strtotime("+1 day")) }}" required>
      </div>
      <div class="mb-3">
        <label class="form-label">開始時間・終了時間</label>
        <div class="input-group">
          <select name="start_at" class="form-select" required>
            <option value="">選択してください</option>
            @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
            <option value="{{ date("H:i", $ts) }}">
              {{ date("H:i", $ts) }}
            </option>
            @endforeach
          </select>
          <span class="input-group-text">~</span>
          <select name="end_at" class="form-select" required>
            <option value="">選択してください</option>
            @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
            <option value="{{ date("H:i", $ts) }}">
              {{ date("H:i", $ts) }}
            </option>
            @endforeach
          </select>
        </div>
      </div>
      <div class="text-end">
        <input type="hidden" name="survey_id" value="{{ $survey->id }}">
        <button type="submit" class="btn btn-secondary">ページを移動してエリアを設定</button>
      </div>
    </form>
  </x-modal>

  <x-watchOnAdmin />
</x-layout>