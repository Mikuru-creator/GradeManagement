<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理ユーザー登録</title>
</head>
<body>
    <h1>管理ユーザー登録</h1>

    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div>
            <label>名前：</label>
            <input type="text" name="user_name" value="{{ old('user_name') }}" required max:255>
            @error('user_name') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>メールアドレス：</label>
            <input type="text" name="email" value="{{ old('email') }}" required max:255>
            @error('email') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>パスワード：</label>
            <input type="password" name="password" required  min:8 max:72>
            @error('password') <div style="color:red;">{{ $message }}</div> @enderror
        </div>

        <div>
            <label>パスワード（確認）：</label>
            <input type="password" name="password_confirmation" required>
        </div>        
  <button type="submit">登録</button>
    </form>

    <button><a href="{{ route('login') }}">ログイン画面へ</a></button>
</body>
</html>
