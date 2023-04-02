<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $fillable = ['title'];

    public function schedules()
    {
        return $this->hasMany(Schedule::class, 'group_id', 'id');
    }
}
