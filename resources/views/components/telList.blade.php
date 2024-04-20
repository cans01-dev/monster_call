@props(['tel_list'])

<div class="card">
	<div class="card-body">
		<h5 class="card-title">
			{{ $tel_list->title }}
		</h5>
		<table class="table table-sm mb-0">
			<tbody>
				<tr>
					<th nowrap>電話番号</th>
					<td>
						{{ $tel_list->tels->count()  }}件の電話番号
					</td>
				</tr>
			</tbody>
		</table>
		<div class="position-absolute top-0 end-0 p-3">
			<a href="/tel_lists/{{ $tel_list->id }}" class="card-link">編集</a>
		</div>
	</div>
</div>
