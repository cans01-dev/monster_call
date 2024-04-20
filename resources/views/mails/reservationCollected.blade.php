<!DOCTYPE html>
<html lang="ja">
<x-head />
<body>
  <main>
    <h1>{{ $reservation->date }}結果</h1>
    <h2>予約</h2>
    <dl>
      <dt>アンケート</dt>
      <dd><a href="{{ url("/surveys/{$reservation->survey_id}") }}">{{ $reservation->survey->title }}</a></dd>
      <dt>日付</dt>
      <dd><a href="{{ $reservation->date }}">{{ $reservation->date }}</a></dd>
      <dt>時間</dt>
      <dd>{{ $reservation->start_at }} ~ {{ $reservation->end_at }}</dd>
      <dt>url</dt>
      <dd>
        <a href="{{ url("/reservations/{$reservation->id}") }}">ここから結果の詳細を確認できます</a><br>
        <b>URLのページからCSVファイルを生成・取得できます</b>
      </dd>
    </dl>
  </main>
  <x-toast />
</body>
</html>