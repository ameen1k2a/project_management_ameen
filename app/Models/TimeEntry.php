<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeEntry extends Model
{
    protected $fillable = ['task_id', 'hours', 'date', 'description'];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }
}

