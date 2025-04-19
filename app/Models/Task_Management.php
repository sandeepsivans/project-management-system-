<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Project_Management;
use App\Models\Task_Remarks;

class Task_Management extends Model
{
    protected $fillable = [
        'project_id',
        'title',
        'description',
        'status',

    ];

    public function project()
    {
        return $this->belongsTo(Project_Management::class, 'project_id');
    }

    public function remarks()
    {
        return $this->hasMany(Task_Remarks::class, 'task_id');
    }

    protected $attributes = [
        'status' => 'pending', 
    ];
}
