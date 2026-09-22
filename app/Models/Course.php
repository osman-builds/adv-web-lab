<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name', 'credit_hours', 'lecturer_id'];

    public function lecturer()
    {
        return $this->belongsTo(Lecturer::class);
    }

    public function students()
    {
        return $this->belongsToMany(Student::class, 'enrolments')
                    ->withPivot('enrolled_at', 'grade')
                    ->withTimestamps();
    }
}