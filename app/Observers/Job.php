<?php

namespace App\Observers;

class Job
{
    
    protected $table = 'jobs';

    protected $fillable = ['id', ];

    public function comments()
    {
        // return $this->hasMany(Comment::class);
    }

}
