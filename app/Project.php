<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

    protected static $recordableEvents = ['created', 'updated'];
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

    public function scenarios()
    {
        return $this->hasMany(Scenario::class);
    }

    public function activity()
    {
        return $this->hasMany(Activity::class)->latest();
    }

    public function invite(User $user)
    {
        return $this->members()->attach($user);
    }

    public function members()
    {
        return $this->belongsToMany(User::class, 'project_members');
    }
}
