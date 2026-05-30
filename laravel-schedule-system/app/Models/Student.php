<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'student_number',
        'full_name',
        'email',
        'section_id',
        'course',
        'year_level',
        'enrollment_date',
        'is_active',
    ];

    protected $casts = [
        'enrollment_date' => 'date',
        'is_active' => 'boolean',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function schedules(): HasMany
    {
        return $this->section->schedules();
    }

    public function getClassSchedules()
    {
        return $this->section->schedules()->with('subject', 'instructor', 'room')->get();
    }
}
