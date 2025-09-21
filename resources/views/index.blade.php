<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>学生表示</title>
</head>
<body>
    <h1>学生表示</h1>
    
    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    <form action="{{ route('students.index') }}" method="GET">
        <label>学年：</label>
        <select name="grade">
            <option value="">--選択--</option>
            <option value="1" {{ request('grade') == 1 ? 'selected' : '' }}>1年</option>
            <option value="2" {{ request('grade') == 2 ? 'selected' : '' }}>2年</option>
            <option value="3" {{ request('grade') == 3 ? 'selected' : '' }}>3年</option>
        </select>

        <label>名前：</label>
        <input type="text" name="name" value="{{ request('name') }}" placeholder="名前を入力">

        <button type="submit">検索</button>
    </form>

    <table border="1" style="margin-top:20px;">
        <thead>
            <tr>
                <th>学年</th>
                <th>名前</th>
                <th>詳細</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->grade }}</td>
                    <td>{{ $student->name }}</td>
                    <td>
                        <a href="{{ route('students.show', $student->id) }}">詳細</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="3">該当する学生が見つかりません</td>
                </tr>
            @endforelse
        
        </tbody>
    </table>
    <br>
    <button type="button" onclick="location.href='{{ route('menu') }}'">戻る</button>
</body>
</html>
