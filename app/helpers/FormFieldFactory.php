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
                'selection' => 0,
                'random_order' => false,
                'dropdown' => false,
                'show_subtitle' => false,
                'required' => false,
                'multiple_choice' => false,
            ],
        ], $options);
    }

    public function makeRating($options = [])
    {
        return $this->mergeOptions([
            'type' => 'rating',
            'template' => [
                'question' => 'Question',
                'subtitle' => 'Subtitle',
                'levels' => 5,
                'items' => [
                    [
                        'lower_bound_label' => 'Item A Low',
                        'upper_bound_label' => 'Item A High',
                    ],
                    [
                        'lower_bound_label' => 'Item B Low',
                        'upper_bound_label' => 'Item B High',
                    ]
                ],
                'show_subtitle' => false,
                'required' => false,
                'show_labels' => true,
            ]
        ], $options);
    }
}
