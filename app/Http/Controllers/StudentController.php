<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Student;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;


class StudentController extends Controller
{
    // 学生登録フォーム表示
    public function create()
    {
        return view('create');
    }

    // 学生登録処理
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'img_path' => 'required|image',
        ]);

        $imgPath = $request->file('img_path')->store('images', 'public');

        Student::create([
            'name' => $request->name,
            'address' => $request->address,
            'grade' => 1,
            'img_path' => $imgPath,
        ]);

        return redirect()->route('students.index')->with('success', '学生を登録しました');
    }

    //　学生検索
    public function index(Request $request)
    {
        $q = Student::query();

        if ($request->filled('grade')) $q->where('grade', $request->grade);
        if ($request->filled('name'))  $q->where('name', 'like', '%'.$request->name.'%');

        if ($request->get('sort') === 'grade') {
            $q->orderBy('grade', $request->get('dir') === 'desc' ? 'desc' : 'asc')
            ->orderBy('id', 'asc');
        }

        $students = $q->get();

        if ($request->ajax()) {
            return view('rows', compact('students')); 
        }
        return view('index', compact('students'));
    }

    //学生削除
    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        DB::transaction(function () use ($student) {
            $student->grades()->delete();
            $student->delete();
        });

          if (!empty($student->img_path)) {
            Storage::disk('public')->delete($student->img_path);
        }

        return redirect()
            ->route('students.index')
            ->with('success', '学生を削除しました。');
    }

    // 学生詳細表示
    public function show($id, \Illuminate\Http\Request $request)
    {
        $student = \App\Student::findOrFail($id);

        $grades = $student->grades()
            ->when($request->filled('grade'), fn($q) => $q->where('grade', $request->grade))
            ->when($request->filled('term'),  fn($q) => $q->where('term',  $request->term))
            ->orderBy('id','asc')
            ->get();

        if ($request->ajax()) {
            return view('grades_rows', compact('grades'))->render();
        }

        return view('show', compact('student', 'grades'));
    }


    // 学生編集表示
    public function edit($id)
    {
        $student = Student::findOrFail($id);
        return view('edit', compact('student'));
    }

    // 更新処理
    public function update(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        $data = $request->validate([
            'grade'    => 'required|integer|min:1|max:3',
            'name'     => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'comment'  => 'nullable|string|max:1000',
            'img_path' => 'nullable|image',
        ]);

        if ($request->hasFile('img_path')) {
            if ($student->img_path && Storage::disk('public')->exists($student->img_path)) {
                Storage::disk('public')->delete($student->img_path);
            }
            $data['img_path'] = $request->file('img_path')->store('images', 'public');
        } else {
            unset($data['img_path']);
        }

        $student->grade   = $data['grade'];
        $student->name    = $data['name'];
        $student->address = $data['address'];
        $student->comment = $data['comment'] ?? null;
        if (isset($data['img_path'])) {
            $student->img_path = $data['img_path'];
        }
        $student->save();

        return redirect()->route('students.show', $student->id)
                        ->with('success', '学生情報を更新しました');
        }
    }