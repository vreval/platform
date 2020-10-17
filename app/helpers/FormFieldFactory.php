<?php


namespace App\helpers;


use Illuminate\Support\Str;

class FormFieldFactory
{
    public function makeHeader($options = [])
    {
        return $this->mergeOptions([
            'type' => 'header',
            'template' => [
                'text' => 'Header Text',
                'show_subtitle' => false,
            ]
        ], $options);
    }

    protected function mergeOptions($defaults, $options): array
    {
        $newOptions = [];
        foreach ($defaults['template'] as $key => $value) {
            if (isset($options[$key])) {
                $newOptions[$key] = $options[$key];
            } else {
                $newOptions[$key] = $value;
            }
        }
        $defaults['template'] = $newOptions;
        return $defaults;
    }

    public function makeText($options = [])
    {
        return $this->mergeOptions([
            'type' => 'text',
            'template' => ['text' => 'Text Block']
        ], $options);
    }

    public function makeSection()
    {
        return ['type' => 'section', 'template' => []];
    }

    public function makeSelection($options = [])
    {
        return $this->mergeOptions([
            'type' => 'selection',
            'template' => [
                'question' => 'Question',
                'subtitle' => 'Subtitle',
                'options' => ['Option 1', 'Option 2', 'Option 3'],
                'random_order' => false,
                'dropdown' => false,
                'show_subtitle' => false,
                'required' => false,
                'multiple_choice' => false,
            ],
        ], $options);
    }

    public function makeEvaluation($options = [])
    {
        return $this->mergeOptions([
            'type' => 'evaluation',
            'template' => [
                'question' => 'Question',
                'subtitle' => 'Subtitle',
                'scale_size' => 5,
                'lower_bound_label' => 'Label A',
                'upper_bound_label' => 'Label B',
                'show_subtitle' => false,
                'required' => false,
                'show_labels' => true,
            ]
        ], $options);
    }
}
