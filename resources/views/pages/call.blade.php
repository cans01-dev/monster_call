<x-layout>
  <x-breadcrumb>
    <li class="breadcrumb-item"><a href="/">ホーム</a></li>
    <li class="breadcrumb-item"><a href="/surveys/{{ $call->reservation->survey->id }}/calls">コール一覧</a></li>
    <li class="breadcrumb-item active">{{ $call->tel }}</li>
  </x-breadcrumb>
  <x-h2>{{ $call->tel }}</x-h2>
  <table class="table table-bordered">
    <thead style="top: 43px;">
      <tr>
        <th>ID</th>
        <th>日付・時間</th>
        <th>電話番号</th>
        <th>ステータス</th>
        <th>通話成立時間</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>{{ $call->id }}</td>
        <td><a href="/reservations/{{ $call->reservation_id }}">{{ $call->reservation->date }}</a> | {{ $call->time }}</td>
        <td>{{ $call->tel }}</td>
        <td>{{ $call->status()["text"] }}</td>
        <td>{{ $call->duration }}</td>
      </tr>
    </tbody>
  </table>
  <hr class="my-3" />
  @if ($call->answers()->exists())
    @foreach ($call->answers as $answer)
      <div class="card mb-2" id="faq{{ $answer["id"] }}">
        <div class="card-body">
          <h5 class="card-title mb-3">
            <span class="badge bg-primary-subtle text-black me-2">質問</span>{{ $answer["title"] }}
          </h5>
          <p class="card-text">{{ $answer["text"] }}</p>
          <table class="table table-sm mb-0">
            <thead>
              <tr>
                <th scope="col">ダイヤル番号</th>
                <th scope="col">TITLE</th>
                <th scope="col">NEXT</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($answer->faq->options as $option)
              <tr class="{{ $option->id === $answer["option_id"] ? "table-success" : "" }}">
                <th scope="row"><span class="">{{ $option->dial }}</span></th>
                <td>{{ $option->title }}</td>
                <td>
                  @if ($option->next_faq)
                    @if ($option->next_faq->id !== $answer["id"])
                      <a href="/faqs/{{ $option->next_faq->id }}" class="badge bg-primary-subtle text-black" style="text-decoration: none;">
                        {{ $option->next_faq->title; }}
                      </a>
                    @else
                      <span class="badge bg-info-subtle text-black">聞き直し</span>
                    @endif
                    @elseif ($option->next_ending)
                      <span class="badge bg-dark-subtle text-black">{{ $option->next_ending->title }}</span>
                    @endif
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    @endforeach
  @else
    <x-noContent>回答データはありません</x-noContent>
  @endif
  <x-watchOnAdmin />
</x-layout>