@props(['survey'])

<div class="mb-2">
  <form action="/surveys/{{ $survey->id }}" method="post">
    @csrf
    @method('PUT')
    <div class="mb-3">
      <label class="form-label">アンケートのタイトル</label>
      <input type="text" name="title" class="form-control" value="{{ $survey->title }}" required>
    </div>
    <div class="mb-3">
      <label class="form-label">アンケートの説明（任意）</label>
      <textarea class="form-control" name="note" rows="3">{{ $survey->note }}</textarea>
    </div>
    <div class="mb-3">
      <label class="form-label">成功エンディング</label>
      <select class="form-select" name="success_ending_id">
        <option value="">--未設定--</option>
        @foreach ($survey->endings as $ending)
          <option
            value="{{ $ending["id"] }}"
            {{ $ending["id"] === $survey->success_ending_id ? "selected" : ""; }}
          >
          {{ $ending["title"] }}
        </option>
        @endforeach
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">読み上げのスピード</label>
      <select class="form-select" name="speaking_rate">
        @for ($i = 0.25; $i <= 4; $i = $i + 0.25)
          <option value="{{ $i }}" @selected($survey->speaking_rate === $i)>
            {{ number_format($i, 2) }}
          </option>            
        @endfor
      </select>
    </div>
    <div class="mb-3">
      <label class="form-label">
        生成する音声のタイプ
        <x-infoBtn />
      </label>
      <select class="form-select" name="voice_name">
        @foreach (config('app.voices') as $voice)
          <option
            value="{{ $voice["name"] }}"
            {{ $voice["name"] === $survey->voice_name ? "selected" : ""; }}
          >
          {{ "{$voice["name"]} ({$voice["gender"]})" }}
        </option>
        @endforeach
      </select>
    </div>
    <div class="text-end mb-2">
      <button type="submit" class="btn btn-dark">更新</button>
    </div>
    <div class="form-text">
      音声タイプの変更は、既に生成された音声ファイルには影響せず、既存の文章に反映させるには全て更新する必要があります
    </div>
  </form>
</div>
<div class="text-end">
  <button type="button" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#advancedSettingsModal">
    詳細設定
  </button>
</div>