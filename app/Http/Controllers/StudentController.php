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
        // バリデーション
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'img_path' => 'required|image',
        ]);

        // 画像アップロード処理
        $imgPath = $request->file('img_path')->store('images', 'public');

        // データ保存
        Student::create([
            'name' => $request->name,
            'address' => $request->address,
            'grade' => 1,
            'img_path' => $imgPath,
        ]);

        return redirect()->route('students.index')->with('success', '学生を登録しました');
    }
    public function index(Request $request)
    {
        $query = \App\Student::query();

        // 学年で絞り込み
        if ($request->filled('grade')) {
            $query->where('grade', $request->grade);
        }

        // 名前で絞り込み（部分一致）
        if ($request->filled('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        $students = $query->get();

        return view('index', compact('students'));
    }

    public function destroy($id)
    {
        $student = Student::findOrFail($id);

        DB::transaction(function () use ($student) {
            // 成績を先に全削除（リレーション想定）
            if (method_exists($student, 'grades')) {
                $student->grades()->delete();
            }

            // 顔写真があればストレージから削除
            if (!empty($student->img_path)) {
                Storage::disk('public')->delete($student->img_path);
            }

            // 学生本体を削除
            $student->delete();
        });

        return redirect()
            ->route('students.index')
            ->with('success', '学生を削除しました。');
    }

    public function show($id)
    {
        $student = Student::with('grades')->findOrFail($id);
        return view('show', compact('student'));
    }

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

    // 画像が来たら差し替え
    if ($request->hasFile('img_path')) {
        if ($student->img_path && Storage::disk('public')->exists($student->img_path)) {
            Storage::disk('public')->delete($student->img_path);
        }
        $data['img_path'] = $request->file('img_path')->store('images', 'public');
    } else {
        unset($data['img_path']);
    }

    // fillable気にせず安全に代入
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
