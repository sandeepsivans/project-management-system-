<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Task_Management;

class Task_Remarks extends Model
{
    protected $fillable = [
        'task_id',
        'remarks',

    ];

    public function task()
    {
        return $this->belongsTo(Task_Management::class, 'task_id');
    }
}
