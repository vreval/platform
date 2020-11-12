<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskType extends Model
{
    use HasFactory;

    protected $casts = [
        'settings' => 'array'
    ];

    public $timestamps = false;
}
