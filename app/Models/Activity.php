<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description'
    ];

    protected $appends = ['completed'];

    public function tasks()
    {
        return $this->hasMany(Task::class, 'activity_id', 'id');
    }

    public function getCompletedAttribute()
    {
        $completed = $this->hasMany(Task::class, 'activity_id', 'id')->where('completed', 1)->count();
        $n_tasks = $this->hasMany(Task::class, 'activity_id', 'id')->count();
        if($completed == $n_tasks){
            return true;
        }else{
            return false;
        }
    }
}
