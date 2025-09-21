<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>メニュー画面</title>
</head>
<body>
    <h1>メニュー画面</h1>
        @if (session('success'))
            <p style="color:green">{{ session('success') }}</p>
        @endif
        <form action="{{ route('grades.promote') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit">学年更新</button>
        </form><br>
        <button><a href="{{ route('students.index') }}">学生表示</a></button><br>
        <button><a href="{{ route('students.create') }}">学生登録</a></button>

</body>
</html>