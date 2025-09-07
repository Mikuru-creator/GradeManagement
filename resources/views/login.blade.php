<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理ユーザーログイン</title>
</head>
<body>
    <h1>管理ユーザーログイン</h1>

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label>メールアドレス：</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>パスワード：</label>
            <input type="password" name="password" required>
        </div>
        <button type="submit">ログイン</button>
    </form>

    @if ($errors->any())
      <ul style="color:red; margin-bottom:1rem;">
        @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    @endif
    
    <button><a href="{{ route('register') }}">新規登録</a></button>
</body>
</html>