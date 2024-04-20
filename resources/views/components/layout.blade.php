<!DOCTYPE html>
<html lang="ja">
<x-head />
<body style="background-color: #ececec;">
	<x-header />
  <div class="flex-container">
    <x-sidebar />
    <main class="layout-main">
      <div class="main-container position-relative">
        {{ $slot }}
        <x-modal id="surveysCreateModal" title="アンケートを新規作成">
          <form action="/users/{{ Auth::user()->id }}/surveys" method="post">
            @csrf
            <div class="mb-3">
              <label class="form-label">アンケートのタイトル</label>
              <input type="text" name="title" class="form-control" placeholder="〇〇のアンケート"  required>
            </div>
            <div class="mb-3">
              <label class="form-label">アンケートの説明（任意）</label>
              <textarea class="form-control" name="note" rows="3"></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">
                生成する音声のタイプ
                <x-infoBtn />
              </label>
              <select class="form-select" name="voice_name">
                @foreach (config('app.voices') as $voice)
                  <option value="{{ $voice['name'] }}">
                    {{ $voice['name'] }} ({{ $voice['gender'] }})
                  </option>
                @endforeach
              </select>
            </div>
            <div class="text-end">
              <button type="submit" class="btn btn-primary">作成</button>
            </div>
          </form>
        </x-modal>
      </div>
    </main>
  </div>
  <x-toast />
</body>
</html>