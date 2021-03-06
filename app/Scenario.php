<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class Scenario extends Model
{
    use HasFactory;
    use RecordsActivity;

    protected $fillable = ['name', 'description'];
    protected $touches = ['project'];
    protected $appends = ['checkpoint_count'];

    public function getCheckpointCountAttribute()
    {
        return $this->checkpoints()->get()->count();
    }

    public function path()
    {
        return "/projects/{$this->project->id}/scenarios/{$this->id}";
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function checkpoints()
    {
        return $this->belongsToMany(Checkpoint::class, 'scenario_checkpoints')
            ->withPivot('sort_position')
            ->orderBy('sort_position');
    }

    public function addCheckpoints(Collection $checkpoints)
    {
        $ids = $checkpoints->pluck('id');
        $ordered = [];
        foreach($ids as $key => $value) {
            $ordered[$value] = ['sort_position' => $key];
        }
        $this->checkpoints()->sync($ordered);
    }

    public function update(array $attributes = [], array $options = [])
    {
        if (isset($attributes['checkpoints'])) {
            $this->addCheckpoints(collect($attributes['checkpoints']));
        }
        parent::update($attributes, $options); // TODO: Change the autogenerated stub
    }
}
