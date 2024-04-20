<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item active">ホーム</li>
  </x-breadcrumb>
  <x-h2>ホーム</x-h2>
  <div class="d-flex gap-3">
    <div class="w-100">
      <section id="reservations">
        <x-h3>全ての予約</x-h3>
        <div class="card p-2 mb-4">
          <form id="params">
            <table class="table table-borderless mb-0">
              <tbody>
                <tr>
                  <td>開始日 ~ 終了日</td>
                  <td>
                    <div class="input-group mb-0" style="max-width: 360px;">
                      <input
                      type="date" name="start" class="form-control form-control-sm"
                      value="{{ request()->start ?? date('Y-m-d', strtotime('first day of this month')) }}">
                      <span class="input-group-text">~</span>
                      <input
                      type="date" name="end" class="form-control form-control-sm"
                      value="{{ request()->end ?? date('Y-m-d', strtotime('last day of this month')) }}">
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
            <div class="position-absolute top-0 end-0 p-2">  
              <button class="btn btn-primary">確定</button>
            </div>
          </form>
        </div>
        <p>{{ "{$pgnt["current"]} / {$pgnt["last_page"]}ページ目 - {$pgnt["current_start"]}~{$pgnt["current_end"]} / {$pgnt["sum"]}件表示中" }}</p>
        @if ($reservations)
          <div class="calls-table-container">
            <table class="table table-hover">
              <thead>
                <tr>
                  <th>ID</th>
                  <th>アンケート</th>
                  <th>ユーザー</th>
                  <th>日付</th>
                  <th>開始・終了時間</th>
                  <th>マイリスト</th>
                  <th>ステータス</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($reservations as $reservation)
                  <tr onclick="window.location.assign('/reservations/{{ $reservation->id }}')">
                    <th>{{ $reservation->id }}</th>
                    <td>
                      <a href="/surveys/{{ $reservation->survey_id }}">{{ $reservation->survey->title }}</a>
                    </td>
                    <td><a href="/users/{{ $reservation->survey->user_id }}">{{ $reservation->survey->user->email }}</a></td>
                    <td>{{ $reservation->date }}</td>
                    <td>{{ substr($reservation->start_at, 0, -3) . " ~ " . substr($reservation->end_at, 0, -3) }}</td>
                    <td>
                      @if ($reservation->tel_list_id)
                        {{ $reservation->tel_list->title }}
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
          <ul class="pagination mb-0 mt-4" style="justify-content: center;">
            @if ($pgnt["first"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["first"] }}" form="params" class="page-link" href="#">
                  <i class="fa-solid fa-angles-left"></i>
                </button>
              </li>
            @endif
            @if ($pgnt["pprev"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["pprev"]  }}" form="params" class="page-link" href="#">
                  {{ $pgnt["pprev"] }}
                </button>
              </li>
            @endif
            @if ($pgnt["prev"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["prev"]  }}" form="params" class="page-link" href="#">
                  {{ $pgnt["prev"] }}
                </button>
              </li>
            @endif
            @if ($pgnt["current"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["current"] }}" form="params" class="page-link active" href="#">
                  {{ $pgnt["current"] }}
                </button>
              </li>
            @endif
            @if ($pgnt["next"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["next"]  }}" form="params" class="page-link" href="#">
                  {{ $pgnt["next"] }}
                </button>
              </li>
            @endif
            @if ($pgnt["nnext"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["nnext"]  }}" form="params" class="page-link" href="#">
                  {{ $pgnt["nnext"] }}
                </button>
              </li>
            @endif
            @if ($pgnt["last"])
              <li class="page-item">
                <button name="page" value="{{ $pgnt["last"]  }}" form="params" class="page-link" href="#">
                  <i class="fa-solid fa-angles-right"></i>
                </button>
              </li>
            @endif
          </ul>
        @else
          <x-noContent>該当するデータがありません、検索条件を変更して再検索してください</x-noContent>
        @endif
      </section>
    </div>
    <div class="flex-shrink-0 sticky-aside" style="width: 300px;">
      <div class="sticky-top">
        <x-h4>アンケート一覧</x-h4>
        @if ($survey)
          <div class="card mb-2">
            <div class="card-body">
              <h5 class="card-title">{{ $survey["title"] }}</h5>
              <div>{{ $survey["note"] }}</div>
              <div class="position-absolute top-0 end-0 p-3">
                <a href="/surveys/{{ $survey["id"] }}" class="card-link">編集</a>
              </div>
            </div>
          </div>
        @else
          <x-noContent>アンケートがありません</x-noContent>
        @endif
        @if ($survey)
          <x-noContent>1ユーザあたり1アンケートのみ作成できます</x-noContent>
        @else
          <x-modalOpenButton target="surveysCreateModal" />
        @endif
      </div>
    </div>
  </div>
</x-layout>