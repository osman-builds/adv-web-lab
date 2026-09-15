<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['code', 'title', 'lecturer_id'];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function students()
    {
        return $this->hasMany(Student::class);
    }
}