<?php

namespace Database\Seeders;

use App\Models\RegisteredAgent;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RegisteredAgentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // list of states on ISO codes to shorten names
        $states = [
            'AL','AK','AZ','AR','CA','CO','CT','DE','FL','GA','HI','ID','IL','IN','IA','KS','KY','LA',
            'ME','MD','MA','MI','MN','MS','MO','MT','NE','NV','NH','NJ','NM','NY','NC','ND','OH','OK',
            'OR','PA','RI','SC','SD','TN','TX','UT','VT','VA','WA','WV','WI','WY'
        ];

        foreach ($states as $state) {

            // ignore Illinois
            if ($state === 'IL') continue;

            $count = in_array($state, ['CA', 'TX']) ? 2 : 1;

            for ($i = 0; $i < $count; $i++) {

                RegisteredAgent::create([
                    'state' => $state,
                    'name' => "Agent $state ".Str::random(6),
                    'email' => "agent_{$state}_$i@mail.com",
                    'capacity' => rand(5, 15),
                ]);

            }
        }
    }
}
