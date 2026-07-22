<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'intern_id',
        'date',
        'time_in',
        'status',
    ];

    public function intern()
    {
        return $this->belongsTo(Intern::class);
    }
}
