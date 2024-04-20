<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a></li>
    <li class="breadcrumb-item active">アセット</li>
  </x-breadcrumb>
  <x-h2>{{ $survey->title }}: アセット</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      <section id="favorite">
        <x-h3>予約パターン</x-h3>
        <div class="form-text mb-2">
          <span>開始・終了時間やエリア設定のテンプレートを利用してスムーズに予約の指定ができます。</span>
          <span>予約パターンの適用後に各日付ごとに設定を変更することも可能です。</span>
          <span>最大5個まで登録できます。</span>
        </div>
        @if ($survey->favorites()->exists())
          <div class="row row-cols-2 g-2 mb-2">
            @foreach ($survey->favorites as $favorite)
              <div class="col">
                <x-favorite :favorite="$favorite" />
              </div>
            @endforeach
          </div>
        @else
          <x-noContent>予約パターンがありません</x-noContent>
        @endif
        <x-modalOpenButton target="favoritesCreateModal" :disabled="$favoriteCreateDisabled" />
      </section>
      <hr class="my-4 opacity-0">
      <section id="area">
        <x-h3>マイエリア（局番リスト）</x-h3>
        <div class="form-text mb-2">
          <span>局番を指定してオリジナルの地域を登録できます。</span>
          <span>何個でも登録ですます。</span>
        </div>
        @if ($survey->areas()->exists())
          <div class="row row-cols-2 g-2 mb-2">
            @foreach ($survey->areas as $area)
              <div class="col">
                <x-area :area="$area" />
              </div>
            @endforeach
          </div>
        @else
          <x-noContent>マイエリアが登録されていません</x-noContent>
        @endif
        <x-modalOpenButton target="areaCreateModal" />
      </section>
      <hr class="my-4 opacity-0">
      <section id="mylist">
        <x-h3>マイリスト（CSVインポート）</x-h3>
        <div class="form-text mb-2">
          <span>CSVファイルから架電リストを登録できます。</span>
          <span>最大10個まで登録できます。</span>
        </div>
        @if ($survey->tel_lists()->exists())
          <div class="row row-cols-2 g-2 mb-2">
            @foreach ($survey->tel_lists as $tel_list)
              <div class="col">
                <x-telList :tel_list="$tel_list" />
              </div>
            @endforeach
          </div>
        @else
          <x-noContent>マイリストが登録されていません</x-noContent>
        @endif
        <x-modalOpenButton target="numberListCreateModal" :disabled="$numberListCreateDisabled" />
      </section>
    </div>
    <div class="flex-shrink-0 sticky-aside" style="width: 300px;">
      <div class="sticky-top">
        <section id="setting">
          <x-h4>設定</x-h4>
          <x-surveySetting :survey="$survey" />
        </section>
      </div>
    </div>
  </div>

  <x-modal id="favoritesCreateModal" title="予約パターンを新規作成">
    <form action="/surveys/{{ $survey->id }}/favorites" method="post">
      @csrf
      <div class="mb-3">
        <label class="form-label">予約パターンのタイトル</label>
        <input type="text" name="title" class="form-control" placeholder="〇〇の予約パターン" required>
      </div>
      <div class="mb-3">
        <label class="form-label">ラベルカラーを選択</label>
        <div class="d-flex gap-4">
          @foreach (config('app.COLOR_PALLET') as $k => $color)
          <div class="form-check">
            <input
              class="form-check-input" type="radio" name="color" value="{{ $color }}" id="i{{ $color }}"
              {{ $k === 0 ? "checked" : "" }}
            >
            <label class="form-check-label" for="i{{ $color }}">
              <div class="badge border border-dark" style="background-color: {{ $color }};">　</div>
            </label>
          </div>
          @endforeach
        </div>
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
        <button type="submit" class="btn btn-primary">ページを移動してエリアを設定</button>
      </div>
    </form>
  </x-modal>

  <x-modal id="areaCreateModal" title="マイエリアを新規登録">
    <form action="/surveys/{{ $survey->id }}/areas" method="post" id="areaCreateForm">
      @csrf
      <input type="hidden" name="survey_id" value="{{ $survey->id }}">
      <div class="mb-3">
        <label class="form-label">マイエリアのタイトル</label>
        <input type="text" name="title" class="form-control" placeholder="〇〇のエリア" required>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">ページを移動して局番を設定</button>
      </div>
    </form>
  </x-modal>

  <x-modal id="numberListCreateModal" title="マイリストを新規登録">
    <form action="/surveys/{{ $survey->id }}/tel_lists" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label">マイリストのタイトル</label>
        <input type="text" name="title" class="form-control" placeholder="〇〇のリスト" required>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">登録</button>
      </div>
    </form>
  </x-modal>

  <x-modal id="forbiddenListCreateModal" title="禁止リストを新規登録">
    <form action="/surveys/{{ $survey->id }}/forbidden_lists" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label">禁止リストのタイトル</label>
        <input type="text" name="title" class="form-control" placeholder="〇〇のリスト" required>
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">登録</button>
      </div>
    </form>
  </x-modal>
</x-layout>