<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function supervisors()
    {
        return $this->hasMany(Supervisor::class);
    }

    public function interns()
    {
        return $this->hasMany(Intern::class);
    }
}
