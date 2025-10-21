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

    <form id="grade-search" action="{{ route('students.show', $student->id) }}" method="GET" style="margin:10px 0;">
        <label>学年：</label>
        <select name="grade">
            <option value="">--</option>
            <option value="1" {{ request('grade')=='1' ? 'selected' : '' }}>1年</option>
            <option value="2" {{ request('grade')=='2' ? 'selected' : '' }}>2年</option>
            <option value="3" {{ request('grade')=='3' ? 'selected' : '' }}>3年</option>
        </select>

        <label>学期：</label>
        <select name="term">
            <option value="">--</option>
            <option value="1" {{ request('term')=='1' ? 'selected' : '' }}>1学期</option>
            <option value="2" {{ request('term')=='2' ? 'selected' : '' }}>2学期</option>
            <option value="3" {{ request('term')=='3' ? 'selected' : '' }}>3学期</option>
        </select>

        <button type="submit">検索</button>
    </form>    <table border="1">
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
        <tbody id="grades-body">
        @include('grades_rows', ['grades' => $grades])
        </tbody>
    </table>

    <p>
        <a href="{{ route('grades.create', ['student_id' => $student->id]) }}">成績登録</a>
    </p>

    <button type="button" onclick="location.href='{{ route('students.index') }}'">戻る</button>


</body>
    <script>
        (() => {
        const form  = document.getElementById('grade-search');
        const tbody = document.getElementById('grades-body');

        function params() {
            const fd = new FormData(form), p = new URLSearchParams();
            for (const [k,v] of fd.entries()) if (v !== '') p.set(k, v);
            return p;
        }

        form.addEventListener('submit', e => {
            e.preventDefault();
            const p = params();
            fetch(form.action + '?' + p.toString(), {
            headers: { 'X-Requested-With': 'XMLHttpRequest' }
            })
            .then(r => r.text())
            .then(html => { tbody.innerHTML = html; });
        });
        })();
    </script>

</html>
