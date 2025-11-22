<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SkillClass extends Model
{
    use HasFactory;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'description',
        'instructor_name',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
    ];

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class, 'class_id');
    }

    public function participants()
    {
        return $this->belongsToMany(User::class, 'enrollments')
                    ->withPivot('status')
                    ->withTimestamps();
    }
}
