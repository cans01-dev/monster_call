@props(['area'])

<div class="card">
	<div class="card-body">
		<h5 class="card-title">
			{{ $area["title"] }}
		</h5>
		<table class="table table-sm mb-0">
			<tbody>
				<tr>
					<th nowrap>局番</th>
					<td>
						@if ($area->stations->count() < 4)
							{{ MyUtil::array_str($area->stations->pluck('prefix')->all(), ', ') }}
						@else
							{{ $area->stations->count() }}件の局番
						@endif
					</td>
				</tr>
			</tbody>
		</table>
		<div class="position-absolute top-0 end-0 p-3">
			<a href="/areas/{{ $area->id }}" class="card-link">編集</a>
		</div>
	</div>
</div>
