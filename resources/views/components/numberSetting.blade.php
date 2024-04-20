@props(['survey', 'selected_tel_list_id', 'selected_areas', 'form_id', 'attach_area_url', 'areas'])

<ul class="list-group mb-2">
	@if ($survey->tel_lists()->exists())
		@foreach ($survey->tel_lists as $tel_list)
			<li class="list-group-item">
				<div class="d-flex justify-content-between">
					<div>
						<input
							class="form-check-input me-1" name="tel_list_id" type="radio" id="numberListRadio{{ $tel_list["id"] }}"
							form="{{ $form_id }}" value="{{ $tel_list->id }}"
							{{ $selected_tel_list_id == $tel_list->id ? "checked" : "" }}
							onchange="submit(this.form)"
						>
						<label class="form-check-label" for="numberListRadio{{ $tel_list->id }}">
							マイリスト: {{ $tel_list->title }}
							<span class="badge bg-secondary">{{ $tel_list->count }}件の電話番号</span>
						</label>
					</div>
					<div>
						<a href="/tel_lists/{{ $tel_list->id }}" class="">編集</a>
					</div>
				</div>
			</li>
		@endforeach
	@else
		<li class="list-group-item text-center py-3">マイリストが登録されていません</li>
	@endif
	<li class="list-group-item py-0">▶
		<a href="/surveys/{{ $survey->id }}/asset#area" class="btn btn-link ps-1">マイリストを編集</a>
	</li>
	<li class="list-group-item">
		<div>
			<input
			class="form-check-input me-1" name="tel_list_id" type="radio" id="firstCheckbox"
			onchange="submit(this.form)" value=""
			form="{{ $form_id }}"
			{{ $selected_tel_list_id ? "" : "checked" }}
			>
			<label class="form-check-label" for="firstCheckbox">
				<b>モンスターコールから作成（地域指定）</b>
			</label>
		</div>
		<section id="area" class="mt-3 {{ $selected_tel_list_id ? "opacity-50 pe-none" : "" }}">
			<div class="form-text mb-2">
				指定されたエリアからランダムで電話番号が指定されコールされます
			</div>
			<div class="vstack gap-4">
				<div>
					<div class="card">
						<div class="card-header">
							マイエリア（局番リスト）
						</div>
						@if ($survey->areas()->exists())
							<ul class="list-group list-group-flush area-list-group">
								@foreach ($survey->areas as $area)
									<li class="list-group-item d-flex align-items-center justify-content-between">
										<div>
											{{ $area->title }}
											<span class="badge bg-secondary">{{ $area->count }}件の局番</span>
										</div>
										<div>
											<a href="/areas/{{ $area->id }}" class="card-link me-2">編集</a>
											<div class="d-inline-block">
												<form action="{{ $attach_area_url }}" method="post">
													@csrf
													<input type="hidden" name="area_id" value="{{ $area->id }}">
													<button
														type="submit" class="btn btn-primary"
														{{ $selected_areas->pluck('id')->contains($area->id) ? "disabled" : "" }}
													>
														追加
													</button>
												</form>
											</div>
										</div>
									</li>
								@endforeach
							</ul>
						@else
							<div class="text-center py-3">マイエリアが登録されていません</div>
						@endif
					</div>
					▶<a href="/surveys/{{ $survey->id }}/asset#area" class="btn btn-link ps-1">マイエリアを編集</a>
				</div>
				<div class="card">
					<div class="card-header">
						<div class="">地域指定</div>
					</div>
					<ul class="list-group list-group-flush area-list-group">
						@foreach ($areas as $area)
							<li class="list-group-item d-flex align-items-center justify-content-between">
								<div>
									{{ $area->title }}
									<a href="/areas/{{ $area->id }}" class="text-body-tertiary">
										<i class="fa-solid fa-circle-info"></i>
									</a>
								</div>
								<form action="{{ $attach_area_url }}" method="post">
									@csrf
									<input type="hidden" name="area_id" value="{{ $area->id }}">
									<button
										type="submit" class="btn btn-primary"
										{{ $selected_areas->pluck('id')->contains($area->id) ? "disabled" : "" }}
									>
										追加
									</button>
								</form>
							</li>
						@endforeach
					</ul>
				</div>
			</div>
		</section>
	</li>
</ul>
