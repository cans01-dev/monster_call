@php
	$survey_id = Auth::user()->survey->id;
	$menu_list = [
		["/home", 'ホーム', 'house'],
		["/surveys/{$survey_id}", '会話と音声', 'comments'],
		["/surveys/{$survey_id}/reservations", 'カレンダー', 'calendar'],
		["/surveys/{$survey_id}/asset", 'アセット', 'bookmark'],
    ["/surveys/{$survey_id}/forbidden_lists", '禁止リスト', 'ban'],
		["/surveys/{$survey_id}/calls", 'コール一覧', 'phone'],
		["/surveys/{$survey_id}/stats", '統計', 'chart-simple'],
		["/support", 'ドキュメント', 'circle-question'],
	];
	$admin_menu_list = [
		["/admin/users", 'ユーザー管理', 'users'],
		["/admin/reservations", '全ての予約', 'table-list']
	];
	$current_url_path = parse_url(URL::current(), PHP_URL_PATH);
@endphp

<header class="border-end border-2 text-bg-white" id="header-sideber">
  <div class="sticky-top container vh-100 p-3 d-flex flex-column">
    <h1 class="fs-3 fw-bold mb-0">
      <a href="/home" class="text-black" style="text-decoration: none;">
        <img src="{{ asset('img/logo_yoko.png') }}" alt="" style="width: 220px;">
      </a>
    </h1>
    <hr>
    <nav id="navbar-example2" class="mb-auto">
      <ul class="nav nav-pills vstack gap-1">
        @foreach ($menu_list as $item)
          <li class="nav-item">
            <a
              class="nav-link {{ $current_url_path === $item[0] ? 'active' : 'link-body-emphasis' }}"
              href="{{ $item[0] }}"
            >
              <span class="text-center d-inline-block me-2" style="width: 24px;">
                <i class="fa-solid fa-{{ $item[2] }} fa-lg"></i>
              </span>{{ $item[1] }}
            </a>
          </li>
        @endforeach
        @if(Auth::user()->isAdmin())
          <li class="nav-item my-2 p-1 border border-2 rounded-2">
            <h4 class="fs-6">管理者メニュー</h4>
            <ul class="nav nav-pills vstack gap-1">
              @foreach ($admin_menu_list as $item)
                <li class="nav-item">
                  <a href="{{ $item[0] }}" class="nav-link <?= request()->server->get('REDIRECT_URL') === "/admin/users" ? "active" : "link-body-emphasis" ?>">
                    <span class="text-center d-inline-block me-2" style="width: 24px;">
                      <i class="fa-solid fa-{{ $item[2] }} fa-lg"></i>
                    </span>{{ $item[1] }}
                  </a>
                </li>
              @endforeach
            </ul>
          </li>
        @endif
      </ul>
      @if(Auth::user()['role'] === 'SUSPENDED')
        <div class="alert alert-danger mt-2 mb-0" role="alert">
          <span class="text-danger">
            <i class="fa-solid fa-circle-exclamation"></i>
          </span>
          アカウントが利用停止されています<br>
          <small>ご利用を再開するには管理者に<a href="/support">お問い合わせ</a>ください</small>
        </div>
      @endif
    </nav>
    <hr>
    <div class="dropdown">
      <button class="btn btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
        {{ Auth::user()->email }}
      </button>
      <ul class="dropdown-menu dropdown-menu-dark">
        <li><a class="dropdown-item" href="/users/{{ Auth::user()['id'] }}">アカウント設定</a></li>
        <li><hr class="dropdown-divider"></li>
        <li>
          <form action="/logout" method="post">
            @csrf
            <button class="dropdown-item" href="/logout">ログアウト</button>
          </form>
        </li>
      </ul>
    </div>
  </div>
</header>