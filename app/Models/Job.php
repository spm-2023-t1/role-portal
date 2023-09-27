<?php

namespace App\Models;

use App\Enums\JobStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'role_type',
        'flags',
    ];

    protected $casts = [
        'status' => JobStatus::class,
    ];

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class)->withTimestamps();
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }
}
