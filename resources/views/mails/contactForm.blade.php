<!DOCTYPE html>
<html lang="ja">
<x-head />
<body>
  <main>
    <h2>お問い合わせフォーム</h2>
    <h3>ユーザー</h3>
    <table>
      <tbody>
        <tr>
          <th>email</th>
          <td>{{ $user_email }}</td>
        </tr>
        <tr>
          <th>url</th>
          <td>{{ $user_url }}</td>
        </tr>
      </tbody>
    </table>
    <h3>お問い合わせ</h3>
    <table>
      <tbody>
        <tr>
          <th>type</th>
          <td>{{ $user_email }}</td>
        </tr>
        <tr>
          <th>text</th>
          <td>{{ $text }}</td>
        </tr>
      </tbody>
    </table>
  </main>
  <x-toast />
</body>
</html>