<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Task extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'task_name', 'task_date', 
        'total_remuneration'
    ];

    public function employees()
    {
        return $this->belongsToMany(Employee::class)->withTimestamps()->withTrashed();
    }
}
