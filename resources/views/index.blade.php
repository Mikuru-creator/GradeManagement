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
        <th><a href="#" id="sort-grade" data-dir="asc">学年</a></th>
        <th>名前</th>
        <th>詳細</th>
    </tr>
    </thead>
    <tbody id="students-body">
    @include('rows', ['students' => $students])
    </tbody>    </table>
    <br>
    <button type="button" onclick="location.href='{{ route('menu') }}'">戻る</button>
</body>

<script>
(() => {
  const form  = document.querySelector('form');
  const link  = document.getElementById('sort-grade');
  const tbody = document.getElementById('students-body');

  function currentParams() {
    const fd = new FormData(form), p = new URLSearchParams();
    for (const [k,v] of fd.entries()) if (v !== '') p.set(k, v);
    return p;
  }

  function runSearch() {
    const p = currentParams();

    if (link.dataset.dir) { p.set('sort','grade'); p.set('dir', link.dataset.dir); }

    fetch(`{{ route('students.index') }}?` + p.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => { tbody.innerHTML = html; });
  }

  form.addEventListener('submit', (e) => {
    e.preventDefault();
    runSearch();
  });

  link.addEventListener('click', (e) => {
    e.preventDefault();
    const dir = link.dataset.dir || 'asc';
    const p = currentParams();
    p.set('sort', 'grade');
    p.set('dir', dir);

    fetch(`{{ route('students.index') }}?` + p.toString(), {
      headers: { 'X-Requested-With': 'XMLHttpRequest' }
    })
    .then(r => r.text())
    .then(html => {
      tbody.innerHTML = html;
      link.dataset.dir = dir === 'asc' ? 'desc' : 'asc';
    });
  });
})();
</script>

</html>
