<?php

namespace Database\Seeders;

use App\TaskType;
use Illuminate\Database\Seeder;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $defaultSettings = [
            'start_checkpoint_id' => null,
            'start_form_id' => null,

            'avatar' => [
                'movement' => 'walking',
                'speed' => 5,
                'walking_sound' => false
            ],

            // Unit: Meters
            'walkable_distance_limit' => 300,
            'walkable_distance_limit_unit' => 'm',

            // Unit: Boolean
            // Should the marker perimeter restrict the walkable area?
            'perimeter_boundary' => false,
        ];

        $answerTimeLimit = [
            'min' => 120,
            'max' => 300,
        ];

        $tracking = [
            // Unit: Samples per Second
            'tracking_frequency' => 4,
            'tracking_frequency_unit' => 'samples per second'
        ];

        $types = [
            [
                'name' => 'Annotation',
                'slug' => 'annotation',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Suspendisse sed nisi lacus sed viverra tellus in. Viverra accumsan in nisl nisi. Enim praesent elementum facilisis leo vel fringilla. Fringilla ut morbi tincidunt augue interdum velit.',
                'icon' => 'fas fa-tags',
                'settings' => array_merge(
                    $defaultSettings,
                    $tracking,
                    [
                        'description' => 'Annotation description',
                        'count' => 3,
                    ]
                )
            ],
            [
                'name' => 'Pointing',
                'slug' => 'pointing',
                'icon' => 'fas fa-hand-point-up',
                'description' => 'Velit dignissim sodales ut eu sem integer vitae justo eget. Gravida dictum fusce ut placerat orci nulla pellentesque. Proin sagittis nisl rhoncus mattis rhoncus urna neque. Cursus eget nunc scelerisque viverra mauris in. Nulla at volutpat diam ut venenatis tellus in metus.',
                'settings' => array_merge(
                    $defaultSettings,
                    $tracking,
                    [
                        'description' => 'Pointing task description',
                        'count' => 3,
                    ]
                )
            ],
            [
                'name' => 'Placing',
                'slug' => 'placing',
                'icon' => 'fas fa-map-pin',
                'description' => 'Condimentum vitae sapien pellentesque habitant morbi tristique senectus. Laoreet non curabitur gravida arcu ac tortor dignissim. Pellentesque habitant morbi tristique senectus et netus et malesuada fames. Nisi quis eleifend quam adipiscing vitae proin sagittis nisl.',
                'settings' => array_merge(
                    $defaultSettings,
                    $tracking,
                    [
                        'description' => 'Placing task description',
                        'count' => 3,
                    ]
                )
            ],
            [
                'name' => 'Questionnaire',
                'slug' => 'questionnaire',
                'icon' => 'fas fa-map-pin',
                'description' => 'Pellentesque diam volutpat commodo sed egestas egestas fringilla. Curabitur gravida arcu ac tortor. Ullamcorper eget nulla facilisi etiam dignissim. Odio pellentesque diam volutpat commodo sed egestas egestas fringilla. Eget nunc lobortis mattis aliquam faucibus purus in.',
                'settings' => array_merge(
                    $defaultSettings,
                    $answerTimeLimit,
                    [
                        'description' => 'Spatial experience description',
                        'forms' => [],
                    ]
                )
            ],
            [
                'name' => 'Wayfinding',
                'slug' => 'wayfinding',
                'icon' => 'fas fa-route',
                'description' => 'At tellus at urna condimentum mattis pellentesque. Mi tempus imperdiet nulla malesuada pellentesque elit eget gravida cum. Maecenas pharetra convallis posuere morbi leo urna molestie at. Duis ut diam quam nulla. Nulla at volutpat diam ut venenatis tellus in metus vulputate.',
                'settings' => array_merge(
                    $defaultSettings,
                    $tracking,
                    [
                        'description' => 'Wayfinding description',
                        'destination' => null,
                    ]
                )
            ],
            [
                'name' => 'Camera Path',
                'slug' => 'camera-path',
                'icon' => 'fas fa-video',
                'description' => 'Pellentesque pulvinar pellentesque habitant morbi tristique. Enim nec dui nunc mattis enim ut tellus elementum sagittis. Nunc pulvinar sapien et ligula ullamcorper malesuada proin libero nunc. Eu facilisis sed odio morbi quis commodo. Ornare arcu dui vivamus arcu felis bibendum ut tristique. Consectetur adipiscing elit duis tristique sollicitudin nibh.',
                'settings' => array_merge(
                    $defaultSettings,
                    [
                        'description' => 'Camera path description',
                        'route' => [],
                    ]
                )
            ],
        ];

        foreach($types as $type) {
            TaskType::create($type);
        }
    }
}
