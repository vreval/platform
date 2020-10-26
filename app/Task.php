<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['project_id', 'description'];
    protected $appends = ['type'];

    public function getTypeAttribute()
    {
        return get_class($this);
    }

    public function saveWith(array $data)
    {
        collect($data)
            ->except('type')
            ->each(fn($item, $key) => $this->$key = $item);

        $this->save();

        return $this;
    }

    public function assignTo(Form $form)
    {
        $form->task()->associate($this);
        $form->save();

        return $this;
    }

    public function form()
    {
        return $this->morphOne(Form::class, 'task');
    }
}
