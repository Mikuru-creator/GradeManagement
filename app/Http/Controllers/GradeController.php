<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Student;
use App\SchoolGrade;

class GradeController extends Controller
{
    public function promote()
    {
        $MAX_GRADE = 3;

        $affected = DB::table('students')
        ->where('grade', '<', $MAX_GRADE)
        ->update([
            'grade' => DB::raw('grade + 1'),
            'updated_at' => now(),
        ]);

        return back()->with('status', '学年を更新しました。');
    }
    public function create($student_id)
    {
        $student = Student::findOrFail($student_id);
        return view('grades_create', compact('student'));
    }

    // 成績登録処理
    public function store(Request $request)
    {
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'grade'      => 'required|integer|in:1,2,3',
            'term'       => 'required|integer|in:1,2,3',
            'japanese'   => 'required|integer|min:1|max:5',
            'math'       => 'required|integer|min:1|max:5',
            'science'    => 'required|integer|min:1|max:5',
            'social_studies' => 'required|integer|min:1|max:5',
            'music'      => 'required|integer|min:1|max:5',
            'home_economics' => 'required|integer|min:1|max:5',
            'english'    => 'required|integer|min:1|max:5',
            'art'        => 'required|integer|min:1|max:5',
            'health_and_physical_education' => 'required|integer|min:1|max:5',
        ]);

        $g = new \App\SchoolGrade();
        $g->fill($data);
        $g->save();

        return redirect()->route('students.show', $data['student_id'])
                         ->with('success', '成績を登録しました');
    }

    // 成績編集
    public function edit($id)
    {
        $grade = \App\SchoolGrade::findOrFail($id);
        return view('grades_edit', compact('grade'));
    }

    // 成績更新
    public function update($id, Request $request)
    {
        $data = $request->validate([
            'grade'   => 'required|integer|min:1|max:3',
            'term'    => 'required|integer|min:1|max:3',
            'japanese' => 'required|integer|min:1|max:5',
            'math'     => 'required|integer|min:1|max:5',
            'science'  => 'required|integer|min:1|max:5',
            'social_studies' => 'required|integer|min:1|max:5',
            'music'     => 'required|integer|min:1|max:5',
            'home_economics' => 'required|integer|min:1|max:5',
            'english'   => 'required|integer|min:1|max:5',
            'art'       => 'required|integer|min:1|max:5',
            'health_and_physical_education' => 'required|integer|min:1|max:5',
        ]);

        $grade = SchoolGrade::findOrFail($id);
        $grade->update($data);

        return redirect()
            ->route('students.show', $grade->student_id)
            ->with('success', '成績を更新しました');
    }
}
