<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Checkpoint extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'position', 'rotation'];
    protected $casts = [
        'position' => 'array',
        'rotation' => 'array',
    ];

    public function isPositioned()
    {
        return $this->position !== null;
    }

    public function scenarios()
    {
        return $this->belongsToMany(Scenario::class, 'scenario_checkpoints')
            ->withPivot('sort_position')
            ->orderBy('sort_position');
    }
}
