<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = ['name','address','grade','img_path','comment'];

    public function grades()
    {
        return $this->hasMany(SchoolGrade::class, 'student_id');
    }
}
