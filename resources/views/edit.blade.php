<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>学生編集画面</title>
</head>
<body>
<h1>学生編集</h1>

<form action="{{ route('students.update', $student->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    {{-- 学生ID（固定表示） --}}
    <div>
        <label>学生ID：</label>
        <span>{{ $student->id }}</span>
    </div>

    {{-- 学年：セレクトボックス --}}
    <div>
        <label>学年：</label>
        <select name="grade" required>
            @for ($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}" {{ (int)old('grade', $student->grade) === $i ? 'selected' : '' }}>
                    {{ $i }}
                </option>
            @endfor
        </select>
        @error('grade')<div style="color:red">{{ $message }}</div>@enderror
    </div>

    {{-- 名前：テキストボックス --}}
    <div>
        <label>名前：</label>
        <input type="text" name="name" value="{{ old('name', $student->name) }}" required>
        @error('name')<div style="color:red">{{ $message }}</div>@enderror
    </div>

    {{-- 住所：テキストボックス --}}
    <div>
        <label>住所：</label>
        <input type="text" name="address" value="{{ old('address', $student->address) }}" required>
        @error('address')<div style="color:red">{{ $message }}</div>@enderror
    </div>

    {{-- 顔写真：ファイルセレクタ（現在値の表示つき） --}}
    <div>
        <label>顔写真：</label>
        <input type="file" name="img_path" accept="image/*">
        @if ($student->img_path)
            <div style="margin-top:8px;">
                <img src="{{ asset('storage/' . $student->img_path) }}" alt="現在の顔写真" style="max-width:180px;">
            </div>
        @endif
        @error('img_path')<div style="color:red">{{ $message }}</div>@enderror
    </div>

    {{-- コメント：テキストエリア --}}
    <div>
        <label>コメント：</label><br>
        <textarea name="comment" rows="4" cols="40">{{ old('comment', $student->comment) }}</textarea>
        @error('comment')<div style="color:red">{{ $message }}</div>@enderror
    </div>

    {{-- ボタン --}}
    <div style="margin-top:12px;">
        <button type="submit">編集</button>
         <button><a href="{{ route('students.show', $student->id) }}">戻る</a></button>
    </form>
    </div>
    
    {{-- 学生削除ボタン --}}
    <form action="{{ route('students.destroy', $student->id) }}"
        method="POST"
        onsubmit="return confirm('本当に削除しますか？この学生と関連する成績も全て削除されます。');"
        style="display:inline-block; margin-top:.5rem;">
    @csrf
    @method('DELETE')
    <button type="submit">学生を削除</button>
    </form>

</body>
</html>
