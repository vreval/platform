<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;
    use HasFactory;

    protected static $recordableEvents = ['created', 'updated'];
    protected $fillable = ['name', 'description', 'owner_id'];
    protected $with = ['members', 'scenarios', 'checkpoints', 'forms'];
    protected $appends = ['relative_updated', 'formatted_created', 'is_pinned'];

    public function getRelativeUpdatedAttribute()
    {
        return $this->updated_at->diffForHumans();
    }

    public function getFormattedCreatedAttribute()
    {
        return $this->created_at->toFormattedDateString();
    }

    public function getIsPinnedAttribute()
    {
        return $this->pins->contains(auth()->user());
    }

    public function path()
    {
        return "/projects/{$this->id}";
    }

    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    public function addScenario(array $data)
    {
        return $this->scenarios()->create($data);
    }

    public function scenarios()
    {
        return $this->hasMany(Scenario::class);
    }

    public function addCheckpoint(array $data)
    {
        return $this->checkpoints()->create($data);
    }

    public function checkpoints()
    {
        return $this->hasMany(Checkpoint::class);
    }

    public function addForm(array $data)
    {
        return $this->forms()->create($data);
    }

    public function forms()
    {
        return $this->hasMany(Form::class);
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
        return $this->belongsToMany(User::class, 'project_members')->withTimestamps();
    }

    public function syncMembers($members)
    {
        if (empty($members)) {
            $this->members()->detach();
        } else {
            $this->members()->sync($members);
        }
    }

    public function pins()
    {
        return $this->belongsToMany(User::class, 'pins');
    }

    public function pinBy(User $user)
    {
        return $this->pins()->attach($user);
    }

    public function unpinBy(User $user)
    {
        return $this->pins()->detach($user);
    }
}
