<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $survey["id"] }}/reservations">{{ $survey["title"] }}</a></li>
    @if ($referer = Session::get("referer"))
      <li class="breadcrumb-item"><a href="{{ $referer["link"] }}">{{ $referer["text"] }}</a></li>
    @endif
    @if ($referer2 = Session::get("referer2"))
      <li class="breadcrumb-item"><a href="{{ $referer2["link"] }}">{{ $referer2["text"] }}</a></li>
    @endif
    <li class="breadcrumb-item active">禁止リスト: {{ $forbidden_list->title }}</li>
  </x-breadcrumb>
  <x-h2>禁止リスト: {{ $forbidden_list->title }}</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      @if ($result = Session::get("storeTelCsvResult"))
        <div class="alert alert-info">
          <h4>CSVファイルインポート結果</h4>
          <div class="accordion" id="accordionExample">
            @foreach ($result as $idx => $r)
              <div class="accordion-item">
                <h2 class="accordion-header">
                  <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $idx }}" aria-controls="collapse{{ $idx }}">
                    {{ $idx === 0 ? "成功" : ($idx === 1 ? "エラー" : "重複"); }}
                    : {{ count($r) }}行
                  </button>
                </h2>
                <div id="collapse{{ $idx }}" class="accordion-collapse collapse" data-bs-parent="#accordionExample">
                  <div class="accordion-body">
                    {{ MyUtil::array_str($r->all(), ", ") }}
                  </div>
                </div>
              </div>
            @endforeach
          </div>
        </div>
        <hr class="my-4">
      @endif
      <section id="numbers">
        <x-h3>電話番号を追加</x-h3>
        <div class="card text-bg-light mb-3">
          <div class="card-header">
            電話番号を入力して追加
          </div>
          <div class="card-body">
            <form action="/forbidden_lists/{{ $forbidden_list->id }}/tels" method="post">
              @csrf
              <div class="input-group mb-2" style="max-width: 320px;">
                <input type="text" name="tel" class="form-control" placeholder="090-1234-5678" pattern="^0?[789]0-?[0-9]{4}-?[0-9]{4}$">
                <button class="btn btn-outline-secondary">追加</button>
              </div>
              <div class="form-text">※ハイフンの有無問わず、先頭のゼロ省略可能</div>
            </form>
          </div>
        </div>
        <div class="card text-bg-light">
          <div class="card-header">
            CSVファイルをアップロードして追加
          </div>
          <div class="card-body">
          <p class="mb-2">一列目が電話番号になっているCSVファイルを指定してください</p>
            <form action="/forbidden_lists/{{ $forbidden_list->id }}/import_csv" enctype="multipart/form-data" method="post">
              @csrf
              <div class="input-group" style="max-width: 440px;">
                <input type="file" name="file" class="form-control" accept="text/csv" required>
                <button type="submit" class="btn btn-outline-secondary">登録</button>
              </div>
              <div class="form-text">
                ※ハイフンの有無問わず、先頭のゼロ省略可能<br>
                この操作には時間がかかることがあります、登録を押した後ブラウザを閉じないでください。
              </div>
            </form>
          </div>
        </div>
      </section>
    </div>
    <div class="flex-shrink-0 sticky-aside" style="width: 300px;">
      <div class="sticky-top">
        <section id="summary">
          <x-h4>設定</x-h4>
          <form method="post">
            @csrf
            @method('PUT')
            <div class="mb-3">
              <label class="form-label">禁止リストのタイトル</label>
              <input type="text" name="title" class="form-control" value="{{ $forbidden_list->title }}">
            </div>
            <div class="form-check form-switch mb-3">
              <label class="form-label">無効 / 有効</label>
              <input class="form-check-input" type="checkbox" value="1" name="enabled"
              {{ $forbidden_list->enabled ? 'checked' : '' }} />
            </div>
            <div class="mb-3">
              <label class="form-label">禁止リストの電話番号数</label>
              <span class="badge bg-primary fs-6">{{ number_format($forbidden_list->tels()->count()) }}件</span>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-dark">更新</button>
            </div>
          </form>
          <form onsubmit="return window.confirm('本当に削除しますか？')" method="post">
            @csrf
            @method('DELETE')
            <input type="hidden" name="redirect" value="{{ Session::get("referer2")["link"] ?? Session::get("referer")["link"] }}">
            <div class="text-end">
              <button class="btn btn-link">禁止リストを削除</button>
            </div>
          </form>
        </section>
      </div>
    </div>
  </div>
  <x-watchOnAdmin />
</x-layout>