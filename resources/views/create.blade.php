<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>学生登録</title>
</head>
<body>
    <h1>学生登録画面</h1>

    <form action="{{ route('students.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label>名前: <input type="text" name="name" required></label><br>
        <label>住所: <input type="text" name="address" required></label><br>
        <label>顔写真:<input type="file" name="img_path" required></label><br>
        <button type="submit">登録</button><br>
        <button><a href="{{ route('menu') }}">戻る</a></button>
    </form>
</body>
</html>