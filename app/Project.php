<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'owner_id'];

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function addScenario(string $name)
    {
        return $this->scenarios()->create(['name' => $name]);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class);
    }

    public function recordActivity($description)
    {
        Activity::create([
            'project_id' => $this->id,
            'description' => $description
        ]);
    }

    public function scenarios()
    {
        return $this->hasMany(Scenario::class);
    }
}
