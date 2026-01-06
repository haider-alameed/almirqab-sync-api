<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\School;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $schools = [
            [
                'name' => 'Abitalib Primary',
                'mongo_id' => 'mongo_id',
            ],

        ];

        foreach ($schools as $data) {
            School::updateOrCreate(
                ['base_url' => $data['base_url']],
                $data
            );
        }
    }
}
