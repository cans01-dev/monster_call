<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    @if ($area->survey)
      <li class="breadcrumb-item"><a href="/surveys/{{ $area->survey->id }}">{{ $area->survey->title }}</a></li>
    @endif
    @if ($referer = Session::get("referer"))
      <li class="breadcrumb-item"><a href="{{ $referer["link"] }}">{{ $referer["text"] }}</a></li>
    @endif
    @if ($referer2 = Session::get("referer2"))
      <li class="breadcrumb-item"><a href="{{ $referer2["link"] }}">{{ $referer2["text"] }}</a></li>
    @endif
    <li class="breadcrumb-item active">マイエリア: {{ $area->title }}</li>
  </x-breadcrumb>
  <x-h2>{{ $area->survey_id ? "マイエリア: {$area->title}" : "エリア: {$area->title}" }}</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      @if (@$stats["called_numbers"])
        <section id="area">
          <x-h3>エリア別の統計を見る</x-h3>
          <table class="table">
            <thead>
              <tr>
                <th scope="col">エリア</th>
                <th scope="col">進捗率(総コール数 / エリア内番号数)</th>
                <th scope="col">応答率</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th scope="row">
                  {{ $area->title }}
                  @if ($area->survey_id)
                    <span class="badge bg-primary">マイエリア</span>
                  @endif
                </th>
                <td>
                  <div class="progress" role="progressbar" aria-label="Example with label" aria-valuenow="44" aria-valuemin="0" aria-valuemax="100">
                    <div class="progress-bar" style="width: {{ round($stats["called_numbers"] / $stats["all_numbers"] * 100) }}%">
                      {{ round($stats["called_numbers"] / $stats["all_numbers"] * 100) }}%
                    </div>
                  </div>
                  <span>({{ $stats["called_numbers"] }} / {{ $stats["all_numbers"] }}) {{ round($stats["called_numbers"] / $stats["all_numbers"] * 100, 4) }}%</span>
                </td>
                <td>
                  {{ round($stats["responsed_numbers"] / $stats["called_numbers"] * 100) }}% ({{ $stats["responsed_numbers"] }} / {{ $stats["called_numbers"] }})
                </td>
              </tr>
            </tbody>
          </table>
        </section>
      @else
        @if ($area->survey_id)
          <section id="addStation">
          <x-h3>局番を追加</x-h3>
          <div class="card text-bg-light mb-3">
            <div class="card-header">
              プレフィックスを入力して局番を追加
            </div>
            <div class="card-body">
              <p class="mb-2">ハイフンなし、6桁の番号を入力してください</p>
              <form action="/areas/{{ $area->id }}/stations" method="post">
                @csrf
                <div class="input-group" style="max-width: 320px;">
                  <input type="text" name="prefix" class="form-control" placeholder="090123" pattern="^0[789]0[0-9]{3}$">
                  <button class="btn btn-outline-secondary" id="button-addon1">追加</button>
                </div>
              </form>
            </div>
          </div>
          <div class="card text-bg-light mb-3">
            <div class="card-header">
              デフォルトのエリアから局番を追加
            </div>
            <div class="card-body area-list-group">
              <div class="vstack gap-3">
                @foreach ($areas as $def_area)
                  <div>
                    <h6>{{ $def_area->title }}</h6>
                    @foreach ($def_area->stations as $station)
                      <div class="d-inline-block">
                        <form action="/areas/{{ $area->id }}/stations" method="post">
                          @csrf
                          <input type="hidden" name="prefix" value="{{ $station->prefix }}">
                          <button
                            class="btn btn-light btn-sm stationButton"
                            @disabled($area->stations->pluck('prefix')->contains($station->prefix))
                          >
                            {{ $station->prefix }}
                          </button>
                        </form>
                      </div>
                    @endforeach
                  </div>
                @endforeach
              </div>
            </div>
          </div>
          </section>
        @endif
      @endif
    </div>
    <div class="flex-shrink-0 sticky-aside" style="width: 300px;">
      <div class="sticky-top">
        <section id="summary">
          <x-h4>設定</x-h4>
          <div class="mb-3">
            <form action="/areas/{{ $area->id }}" method="post" id="editAreaForm">
              @csrf
              @method('PUT')
              <label class="form-label">タイトル</label>
              <input type="text" name="title" class="form-control" value="{{ $area->title }}" {{ !$area->survey_id ? "disabled" : "" }}>
            </form>
          </div>
          <div class="mb-3">
            <label class="form-label">局番</label>
            @if ($area->stations)
              <div>
                @foreach ($area->stations()->orderBy('prefix')->get() as $station)
                  <span class="badge bg-secondary fs-6 mb-1">
                    <form action="/stations/{{ $station["id"] }}" method="post">
                      @csrf
                      @method('DELETE')
                      {{ $station["prefix"] }}
                      <button type="submit" class="bg-transparent border-0" {{ !$area->survey_id ? "disabled" : "" }}>
                        <i class="fa-solid fa-xmark text-white"></i>
                      </button>
                    </form>
                  </span>
                @endforeach
              </div>
            @else
              <x-noContent>局番が設定されていません</x-noContent>
            @endif
          </div>
          <div class="text-end">
            <button type="submit" class="btn btn-dark" form="editAreaForm" {{ !$area->survey_id ? "disabled" : "" }}>更新</button>
          </div>
          @if ($area->survey_id)
            <form method="post" onsubmit="return window.confirm('本当に削除しますか？')">
              @csrf
              @method('DELETE')
              <input type="hidden" name="redirect" value="{{ Session::get("referer2")["link"] ?? Session::get("referer")["link"] }}">
              <div class="text-end">
                <input type="submit" class="btn btn-link" value="このマイエリアを削除">
              </div>
            </form>
          @else
            <div class="form-text">
              デフォルトのエリアは編集できません。
            </div>
          @endif
        </section>
      </div>
    </div>
  </div>

  <x-watchOnAdmin />
</x-layout>