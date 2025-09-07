<!-- resources/views/grades/create.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>成績登録</title>
</head>
<body>
    <h1>成績登録</h1>

    @if (session('success'))
        <p style="color:green">{{ session('success') }}</p>
    @endif

    @if ($errors->any())
        <ul style="color:red; margin-bottom:1rem;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    @isset($student)
        <p>対象学生：{{ $student->name }}（ID: {{ $student->id }}）</p>
    @endisset

    <p style="margin: .5rem 0;">
        {{-- 戻るボタン（学生詳細があればそっちへ、なければ一覧へ） --}}
        @isset($student)
            <a href="{{ route('students.show', $student->id) }}">← 戻る</a>
        @else
            <a href="{{ route('students.index') }}">← 戻る</a>
        @endisset
    </p>

    <form action="{{ route('grades.store') }}" method="POST">
        @csrf
        <input type="hidden" name="student_id"
               value="{{ old('student_id', $student->id ?? '') }}">

        {{-- 学年 --}}
        <div>
            <label>学年（必須）</label>
            <select name="grade" required>
                <option value="">選択してください</option>
                @for ($i = 1; $i <= 3; $i++)
                    <option value="{{ $i }}" {{ old('grade') == $i ? 'selected' : '' }}>
                        {{ $i }}年
                    </option>
                @endfor
            </select>
            @error('grade')<div style="color:red">{{ $message }}</div>@enderror
        </div>

        {{-- 学期 --}}
        <div>
            <label>学期（必須）</label>
            <select name="term" required>
                <option value="">選択してください</option>
                @foreach (['1'=>'1学期','2'=>'2学期','3'=>'3学期'] as $val => $label)
                    <option value="{{ $val }}" {{ old('term') == $val ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>
            @error('term')<div style="color:red">{{ $message }}</div>@enderror
        </div>

        @php
            // 5段階評価でプルダウン生成
            $five = [1,2,3,4,5];
            $subjects = [
                'japanese' => '国語',
                'math' => '数学',
                'science' => '理科',
                'social_studies' => '社会',
                'music' => '音楽',
                'home_economics' => '家庭科',
                'english' => '英語',
                'art' => '美術',
                'health_and_physical_education' => '保健体育',
            ];
        @endphp

        @foreach ($subjects as $name => $label)
            <div>
                <label>{{ $label }}（必須）</label>
                <select name="{{ $name }}" required>
                    <option value="">選択してください</option>
                    @foreach ($five as $v)
                        <option value="{{ $v }}" {{ old($name) == $v ? 'selected' : '' }}>
                            {{ $v }}
                        </option>
                    @endforeach
                </select>
                @error($name)<div style="color:red">{{ $message }}</div>@enderror
            </div>
        @endforeach

        <div style="margin-top:1rem;">
            <button type="submit">成績を登録する</button>
        </div>
    </form>

    <p style="margin-top: .5rem;">
        @isset($student)
            <a href="{{ route('students.show', $student->id) }}">← 戻る</a>
        @else
            <a href="{{ route('students.index') }}">← 戻る</a>
        @endisset
    </p>
</body>
</html>
