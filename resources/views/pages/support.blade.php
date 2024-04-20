<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item active">サポート</li>
  </x-breadcrumb>
  <x-h2>ドキュメント</x-h2>
  <div>
    <x-h4>お問い合わせ</x-h2>
    <div class="form-text mb-2">ドキュメントを読んでも分からない、その他バグの報告・要望などはこちら</div>
    <button
      class="btn btn-primary"
      data-bs-toggle="modal"
      data-bs-target="#contactModal"
    >お問い合わせ</button>
    <hr class="my-4">
    
    <x-h4>音声タイプのサンプル</x-h2>
    <table class="table table-sm">
      <thead>
        <tr>
          <td>名前</td>
          <td>性別</td>
          <td>サンプル</td>
        </tr>
      </thead>
      <tbody>
        @foreach (config('app.voices') as $voice)
          <tr>
            <td>{{ $voice["name"] }}</td>
            <td>{{ $voice["gender"] }}</td>
            <td>
              <audio src="{{ asset("samples/{$voice["name"]}.wav") }}" controls></audio>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
    <hr class="my-4">
    <div class="markdown-body w-100 pt-3">
      {!! $markdown !!}
    </div>
  </div>

  <x-modal id="contactModal" title="お問い合わせ">
    <form action="/support/contact" method="post">
      @csrf
      <div class="mb-3">
        <label class="form-label">ユーザー</label>
        <input type="text" class="form-control" value="{{ Auth::user()["email"] }}" disabled>
      </div>
      <div class="mb-3">
        <label class="form-label">ご連絡の種類</label>
        <select name="type" class="form-select">
          <option value="機能についてのご質問">機能についてのご質問</option>
          <option value="バグ、エラーの報告">バグ、エラーの報告</option>
          <option value="その他のご連絡">その他のご連絡</option>
        </select>
      </div>
      <div class="mb-3">
        <label class="form-label">本文</label>
        <textarea class="form-control" name="text" rows="10"></textarea>
      </div>
      <div class="text-end">
        <input type="hidden" name="user_id" value="{{ Auth::user()["id"] }}">
        <button type="submit" class="btn btn-primary">送信</button>
      </div>
    </form>
  </x-modal>
</x-layout>