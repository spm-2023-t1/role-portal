<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'staff_id',
        'fname',
        'lname',
        'dept',
        'email',
        'phone_num',
        'biz_address',
        'current_role',
        'reporting_officer_id',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'role' => UserRole::class,
    ];

    public function skills(): BelongsToMany
    {
        return $this->belongsToMany(Skill::class, 'user_skill')->withTimestamps();
    }

    public function jobs(): HasMany
    {
        return $this->hasMany(Job::class, 'owner_id');
    }

    public function updaters(): HasMany
    {
        return $this->hasMany(Job::class, 'update_user_id');
    }

    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'job_user')
        ->withTimestamps()
        ->withPivot(['start_date', 'remarks', 'role_app_status']);
    }

    public function manage_sources(): HasMany
    {
        return $this->hasMany(Job::class);
    }

    public function reporting_officer(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'reporting_officer_id');
    }

    public function report(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'reporting_officer_id');
    }

    public function isHR()
    {
        return $this->role == UserRole::HumanResource;
    }

    public function isStaff()
    {
        return $this->role == UserRole::Staff;
    }

    public function isManager()
    {
        return $this->role == UserRole::Manager;
    }
}
