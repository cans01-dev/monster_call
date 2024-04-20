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

<header class="sticky-top" id="header-navber">
	<nav class="navbar navbar-expand-md bg-body-tertiary">
		<div class="container-fluid">
			<a class="navbar-brand" href="/home">
				{{ config('app.name') }}
			</a>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav">
					@foreach ($menu_list as $item)
						<li class="nav-item">
							<a class="nav-link" href="{{ $item[0] }}">
								<span class="text-center d-inline-block me-1" style="width: 20px;">
									<i class="fa-solid fa-{{ $item[2] }}"></i>
								</span>
								{{-- {{ $item[1] }} --}}
							</a>
						</li>
					@endforeach
          @if(Auth::user()->isAdmin())
						<li class="nav-item dropdown">
							<button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
								管理者メニュー
							</button>
							<ul class="dropdown-menu">
								@foreach ($admin_menu_list as $item)
									<li class="dropdown-item">
										<a href="{{ $item[0] }}" class="nav-link">
											<span class="text-center d-inline-block me-2" style="width: 20px;">
												<i class="fa-solid fa-{{ $item[2] }}"></i>
											</span>{{ $item[1] }}
										</a>
									</li>
								@endforeach
							</ul>
						</li>
					@endif
					<li class="nav-item dropdown">
						<button class="nav-link dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
							{{ Auth::user()->email }}
						</button>
						<ul class="dropdown-menu">
							<li><a class="dropdown-item" href="/account">アカウント設定</a></li>
							<li><hr class="dropdown-divider"></li>
							<li>
								<form action="/logout" method="post">
									@csrf
									<button class="dropdown-item" href="/logout">ログアウト</button>
								</form>
							</li>
						</ul>
					</li>
				</ul>
			</div>
		</div>
	</nav>
</header>