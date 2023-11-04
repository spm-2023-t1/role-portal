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

    protected $primaryKey = 'id';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'role_name',
        'description',
        'role_type',
        'listing_status',
        'deadline',
        'source_manager'
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
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'update_user_id');
    }

    public function applicants(): BelongsToMany
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function viewers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'job_viewer')->withTimestamps();
    }
    
    public function source_manager(): BelongsTo
    {
        return $this->belongsTo(User::class)->withTimestamps();
    }
    // public function roleApplications(): HasMany{
    //     return $this->hasMany(Application::class, 'job_id');
    // }
}
