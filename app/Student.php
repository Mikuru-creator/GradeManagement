<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name','address','grade','img_path','comment'];

    // 成績（school_grades）へのリレーション
    public function grades()
    {
        return $this->hasMany(SchoolGrade::class, 'student_id');
    }
}
