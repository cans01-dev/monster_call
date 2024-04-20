<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a></li>
    @if (request()->session()->has("referer"))
      <li class="breadcrumb-item">
        <a href="{{ request()->session()->get("referer")["link"] }}">
          {{ request()->session()->get("referer")["text"] }}
        </a>
      </li>
    @endif
    <li class="breadcrumb-item active">予約パターン: {{ $favorite->title }}</li>
  </x-breadcrumb>
  <x-h2>予約パターン: {{ $favorite->title }}</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      {{-- 下こいつらコンポネントか --}}
      <section id="number_list">
        <x-h3>架電リスト選択</x-h3>
        <x-numberSetting
        :survey="$survey"
        :selected_areas="$favorite->areas"
        :areas="$areas"
        selected_tel_list_id="{{ $favorite->tel_list_id }}"
        form_id="updateReservationForm"
        attach_area_url="/favorites/{{ $favorite->id }}/attach_area" />
      </section>
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
                <select name="start_at" class="form-select" required>
                  <option value="">選択してください</option>
                  @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
                    <option value="{{ date("H:i", $ts) }}" {{ $favorite->start_at == date("H:i:s", $ts) ? "selected" : ""; }}>
                      {{ date("H:i", $ts) }}
                    </option>
                  @endforeach
                </select>
                <span class="input-group-text">~</span>
                <select name="end_at" class="form-select" required>
                  <option value="">選択してください</option>
                  @foreach (MyUtil::make_times(config('app.MIN_TIME'), config('app.MAX_TIME'), config('app.TIME_STEP')) as $ts)
                    <option value="{{ date("H:i", $ts) }}" {{ $favorite->end_at == date("H:i:s", $ts) ? "selected" : ""; }}>
                      {{ date("H:i", $ts) }}
                    </option>
                  @endforeach
                </select>
              </div>
            </div>
            <div class="mb-3">
              <label class="form-label">予約パターンのタイトル</label>
              <input type="text" name="title" class="form-control" value="{{ $favorite->title }}" required>
            </div>
            <div class="mb-3">
              <label class="form-label">ラベルカラー</label>
              <input type="color" name="color" class="form-control form-control-color" value="{{ $favorite->color }}" required>
            </div>
          </form>
          @if ($favorite->tel_list)
            <div class="mb-3">
              <label class="form-label">マイリスト</label>
              <div class="mb-2">
                <x-telList :tel_list="$favorite->tel_list" />
              </div>
            </div>
          @else
            <div class="mb-3">
              <label class="form-label">エリア</label>
              @if ($favorite->areas)
                <div>
                  @foreach ($favorite->areas as $area)
                    <span class="badge bg-secondary fs-6 mb-1">
                      <form action="/favorites/{{ $favorite->id }}/detach_area" method="post">
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
            <button type="submit" class="btn btn-dark" form="updateReservationForm">更新</button>
          </div>
          <form method="post" onsubmit="return window.confirm('本当に削除しますか？')">
            @csrf
            @method('DELETE')
            <input type="hidden" name="redirect" value="{{ request()->session()->get("referer")["link"] }}">
            <div class="text-end">
              <input
                type="submit" class="btn btn-link"
                value="この予約パターンを削除"
              >
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>

  <x-watchOnAdmin />
</x-layout>