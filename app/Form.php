<?php

namespace App;

use App\helpers\FormFieldFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Form extends Model
{
    use HasFactory;

    protected $fieldFactory;
    protected $fillable = ['name', 'description', 'fields'];
    protected $casts = ['fields' => 'array'];
    protected $attributes = ['fields' => '[]'];
    protected $appends = ['attached_task'];

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fieldFactory = new FormFieldFactory();
    }

    public function getAttachedTaskAttribute()
    {
        return $this->task;
    }

    public function collectFields()
    {
        return collect($this->fields);
    }

    public function addHeader(array $template = [])
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeHeader($template)]);
    }

    public function addText(array $template = [])
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeText($template)]);
    }

    public function addSection(array $template = [])
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeSection($template)]);
    }

    public function addSelection(array $template = [])
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeSelection($template)]);
    }

    public function addRating(array $template = [])
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeRating($template)]);
    }

    public function task()
    {
        return $this->morphTo();
    }
}
