<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>成績編集</title>
</head>
<body>
    <h1>成績編集</h1>

    <form action="{{ route('grades.update', $grade->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div>
            <label>学年</label>
            <select name="grade" require>
                @for($i=1;$i<=3;$i++)
                    <option value="{{ $i }}" {{ old('grade', $grade->grade) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        <div>
            <label>学期</label>
            <select name="term" require>
                @for($i=1;$i<=3;$i++)
                    <option value="{{ $i }}" {{ old('term', $grade->term) == $i ? 'selected' : '' }}>{{ $i }}</option>
                @endfor
            </select>
        </div>

        @php
            $five = [1,2,3,4,5];
            $subjects = [
                'japanese' => '国語','math' => '数学','science' => '理科','social_studies' => '社会',
                'music' => '音楽','home_economics' => '家庭科','english' => '英語','art' => '美術',
                'health_and_physical_education' => '保健体育',
            ];
        @endphp

        @foreach($subjects as $name => $label)
        <div>
            <label>{{ $label }}（現在: {{ $grade->$name }}）</label>
            <select name="{{ $name }}" required>
                @foreach ($five as $v)
                    <option value="{{ $v }}"
                        {{ (string)old($name, (string)$grade->$name) === (string)$v ? 'selected' : '' }}>{{ $v }}
                    </option>
                @endforeach
            </select>
            @error($name)
                <div style="color:red">{{ $message }}</div>
            @enderror
          </div>
            @endforeach

        <button type="submit">更新</button>
    </form>

    <button type="button" onclick="location.href='{{ route('students.show', $grade->student_id) }}'">戻る</button>
</body>
</html>
