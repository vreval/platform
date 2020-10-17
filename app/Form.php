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

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->fieldFactory = new FormFieldFactory();
    }

    public function addHeader($template)
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeHeader($template)]);
    }

    public function addText($template)
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeText($template)]);
    }

    public function addSection($template = [])
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeSection($template)]);
    }

    public function addSelection(array $template)
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeSelection($template)]);
    }

    public function addEvaluation(array $template)
    {
        $this->fields = array_merge($this->fields, [$this->fieldFactory->makeEvaluation($template)]);
    }
}
