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
                'base_url' => 'https://abitalibp.school.iq',
                'almirqab_email' => 'abitalib.programer@ag.edu.iq',
                'almirqab_password' => 'Nw6/Ms0=Km4/Fz1W', // will be encrypted by cast
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
