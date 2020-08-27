<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    protected $fillable = ['name'];

    protected $touches = ['project'];

    protected static function boot()
    {
        parent::boot();

        static::created(function ($scenario) {
            $scenario->project->recordActivity('scenario_created');
        });

        static::updated(function ($scenario) {
            $scenario->project->recordActivity('scenario_updated');
        });
    }

    public function path()
    {
        return "/projects/{$this->project->id}/scenarios/{$this->id}";
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
