<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学生詳細</title>
</head>
<body>
    <h1>学生詳細画面</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <h2>学生情報</h2>
    <table border="1">
        <tr><th>学年</th><td>{{ $student->grade }}</td></tr>
        <tr><th>名前</th><td>{{ $student->name }}</td></tr>
        <tr><th>住所</th><td>{{ $student->address }}</td></tr>
        <tr><th>顔写真</th>
            <td>
                @if($student->img_path)
                    <img src="{{ asset('storage/' . $student->img_path) }}" alt="顔写真" width="100">
                @endif
            </td>
        </tr>
        <tr><th>コメント</th><td>{{ $student->comment }}</td></tr>
    </table>

    <p>
        <a href="{{ route('students.edit', $student->id) }}">学生編集</a>
    </p>

    <h2>成績</h2>
    <table border="1">
        <thead>
            <tr>
                <th>学年</th>
                <th>学期</th>
                <th>国語</th>
                <th>数学</th>
                <th>理科</th>
                <th>社会</th>
                <th>音楽</th>
                <th>家庭科</th>
                <th>英語</th>
                <th>美術</th>
                <th>保健体育</th>
                <th>編集</th>
            </tr>
        </thead>
        <tbody>
            @foreach($student->grades as $grade)
            <tr>
                <td>{{ $grade->grade }}</td>
                <td>{{ $grade->term }}</td>
                <td>{{ $grade->japanese }}</td>
                <td>{{ $grade->math }}</td>
                <td>{{ $grade->science }}</td>
                <td>{{ $grade->social_studies }}</td>
                <td>{{ $grade->music }}</td>
                <td>{{ $grade->home_economics }}</td>
                <td>{{ $grade->english }}</td>
                <td>{{ $grade->art }}</td>
                <td>{{ $grade->health_and_physical_education }}</td>
                <td>
                    <a href="{{ route('grades.edit', $grade->id) }}">編集</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p>
        <a href="{{ route('grades.create', ['student_id' => $student->id]) }}">成績登録</a>
    </p>

    <button><a href="{{ route('students.index') }}">戻る</a></button>

</body>
</html>
