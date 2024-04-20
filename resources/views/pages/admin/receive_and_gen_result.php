<?php


if ($_SERVER["REQUEST_METHOD"] === "POST") {
  if (!$file_path = upload_file($_FILES["file"])) exit("ファイルのアップロードに失敗しました");
  $reservation_info = json_decode(file_get_contents($file_path), true);
  echo "予約情報ファイルを正常に受信しました" . PHP_EOL;

  [$json, $file_path] = gen_result_sample($reservation_info, [1,2,2,3,3,4,4,6,6]);
  
  file_put_contents($file_path, $json);
  $download = url('/storage/outputs/' . basename($file_path));
  echo "サンプル結果ファイルを生成しました: <a href='{$download}' download>{$file_path}</a>" . PHP_EOL;
}

?>

<h2>予約情報ファイルを受信、サンプル結果ファイルを生成</h2>
<form method="post" enctype="multipart/form-data">
  <label>予約情報ファイル</label>
  <input type="file" name="file">
  <button type="submit">実行</button>
</form>