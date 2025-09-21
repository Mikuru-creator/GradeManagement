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
        $query = \App\Student::query();

        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $students = $query->get();

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
    public function show($id)
    {
        $student = Student::with('grades')->findOrFail($id);
        return view('show', compact('student'));
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
            'grade'    => 'required|integer|min:1|max:6',
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
        
        return back()->withErrors(['message' => '更新に失敗しました']) // ← $errors に入れる
                     ->withInput();

        }
    }