<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'scenario_id',
        'start_checkpoint_id',
        'start_form_id',
        'type_id',
        'position'
    ];

    public function checkpoint()
    {
        return $this->belongsTo(Checkpoint::class, 'start_checkpoint_id');
    }

    public function form()
    {
        return $this->belongsTo(Form::class, 'start_form_id');
    }

    public function type()
    {
        return $this->belongsTo(TaskType::class);
    }
}
