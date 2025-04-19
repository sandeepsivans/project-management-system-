<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Task_Management;
class Project_Management extends Model
{
    protected $fillable =[
        'title',  
        'user_id',
        'description',

    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task_Management::class, 'project_id');
    }
}
