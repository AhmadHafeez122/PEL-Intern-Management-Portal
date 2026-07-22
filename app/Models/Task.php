<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'title',
        'description',
        'status',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
