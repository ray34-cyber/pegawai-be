<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'employee_name', 
        'employee_hours', 
        'employee_rate',
        'extra_cost',
        'task_description',
    ];

    public function tasks()
    {
        return $this->belongsToMany(Task::class)->withTimestamps()->withTrashed();
    }
}
