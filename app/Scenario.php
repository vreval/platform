<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Scenario extends Model
{
    use RecordsActivity;

    protected $fillable = ['name'];

    protected $touches = ['project'];

    public function path()
    {
        return "/projects/{$this->project->id}/scenarios/{$this->id}";
    }

    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
