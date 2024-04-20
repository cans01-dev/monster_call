@props(['favorite'])

<div class="card">
	<div class="card-body">
		<h5 class="card-title">
			<div class="badge" style="background-color: {{ $favorite->color }};">　</div>
			{{ $favorite->title }}
		</h5>
		<table class="table table-sm mb-0">
			<tbody>
				<tr>
					<th nowrap>時間</th>
					<td>{{ date("H:i", strtotime($favorite->start_at)) }} - {{ date("H:i", strtotime($favorite->end_at)) }}</td>
				</tr>
				<tr>
					@if ($favorite->tel_list)
						<th nowrap>マイリスト</th>
						<td>{{ $favorite->tel_list->title }}</td>
					@else
						<th nowrap>エリア</th>
						<td>
							@if (count($favorite->areas) < 4)
								@foreach ($favorite->areas as $area)
									{{ $area->title }}
								@endforeach
							@else
								{{ count($favorite->areas) }}件のエリア
							@endif
						</td>
					@endif
				</tr>
			</tbody>
		</table>
		<div class="position-absolute top-0 end-0 p-3">
			<a href="/favorites/{{ $favorite->id }}" class="card-link">編集</a>
		</div>
	</div>
</div>
