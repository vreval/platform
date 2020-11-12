<?php

namespace Database\Seeders;

use App\TaskType;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'annotation',
                'description' => '',
                'settings' => []
            ],
            [
                'name' => 'pointing',
                'description' => '',
                'settings' => []
            ],
            [
                'name' => 'placing',
                'description' => '',
                'settings' => []
            ],
            [
                'name' => 'questionnaire',
                'description' => '',
                'settings' => []
            ],
            [
                'name' => 'wayfinding',
                'description' => '',
                'settings' => []
            ],
        ];

        foreach($types as $type) {
            TaskType::create($type);
        }
    }
}
