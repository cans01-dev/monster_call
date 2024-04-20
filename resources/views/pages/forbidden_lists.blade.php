<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $survey->id }}">{{ $survey->title }}</a></li>
    <li class="breadcrumb-item active">アセット</li>
  </x-breadcrumb>
  <x-h2>禁止リスト（CSVインポート）</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      <section id="mylist">
        <div class="form-text mb-2">
          <span>CSVファイルから架電リストを登録できます。</span>
          <span>最大10個まで登録できます。</span>
        </div>
        @if ($survey->forbidden_lists()->exists())
          <table class="table table-hover">
            <thead>
              <tr>
                <th>ID</th>
                <th>タイトル</th>
                <th>電話番号数</th>
                <th>有効/無効</th>
                <th>作成日</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($forbidden_lists as $forbidden_list)
                <tr onclick="window.location.assign('/forbidden_lists/{{ $forbidden_list->id }}')">
                  <th>{{ $forbidden_list->id }}</th>
                  <td>{{ $forbidden_list->title }}</td>
                  <td>{{ $forbidden_list->tels()->count() }}件</td>
                  <td>
                    @if ($forbidden_list->enabled)
                      有効
                    @else
                      無効
                    @endif
                  </td>
                  <td>{{ $forbidden_list->created_at }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        @else
          <x-noContent>禁止リストが登録されていません</x-noContent>
        @endif
        <x-modalOpenButton target="forbiddenListCreateModal" :disabled="$forbiddenListCreateDisabled" />
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

  <x-modal id="forbiddenListCreateModal" title="禁止リストを新規登録">
    <form action="/surveys/{{ $survey->id }}/forbidden_lists" method="post" enctype="multipart/form-data">
      @csrf
      <div class="mb-3">
        <label class="form-label">禁止リストのタイトル</label>
        <input type="text" name="title" class="form-control" placeholder="〇〇のリスト" required>
      </div>
      <div class="form-check form-switch mb-3">
        <label class="form-label">無効 / 有効</label>
        <input class="form-check-input" type="checkbox" value="1" name="enabled" checked />
      </div>
      <div class="text-end">
        <button type="submit" class="btn btn-primary">登録</button>
      </div>
    </form>
  </x-modal>
</x-layout>