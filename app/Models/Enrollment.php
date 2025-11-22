<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'class_id',
        'status',
    ];

    public function peserta()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function skillClass()
    {
        return $this->belongsTo(SkillClass::class, 'class_id');
    }
}
