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
        'position',
        'settings'
    ];

    protected $casts = [
        'settings' => 'array'
    ];

    protected $appends = ['type_name', 'settings'];

    public function getTypeNameAttribute()
    {
        return $this->type->name;
    }

    public function getSettingsAttribute()
    {
        return $this->type->settings;
    }

    public function scenario()
    {
        return $this->belongsTo(Scenario::class, 'scenario_id');
    }

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
        return $this->belongsTo(TaskType::class, 'type_id');
    }

    public function settings()
    {
        return (object)$this->type->settings;
    }
}
