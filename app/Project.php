<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'description', 'owner_id'];

    public $old = [];

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
        return $this->hasMany(Activity::class)->latest();
    }

    public function recordActivity($description)
    {
        $this->activity()->create([
            'description' => $description,
            'changes' => $this->activityChanges($description)
        ]);
    }

    protected function activityChanges($description) {
        if ($description === 'updated') {
            return [
                'before' => array_diff($this->old, $this->getAttributes()),
                'after' => $this->getChanges(),
            ];
        }
    }

    public function scenarios()
    {
        return $this->hasMany(Scenario::class);
    }
}
