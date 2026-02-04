<?php

namespace Database\Seeders;

use App\Enums\RegisteredAgentType;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompaniesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        $states = ['CA','NY','FL','TX','AR','WA','CO'];

        foreach ($users as $user) {

            // create 1-2 companies for each user
            $num = rand(1,2);

            for ($i = 0; $i < $num; $i++){
                Company::create([
                    'user_id' => $user->id,
                    'name' => "Company $user->name".uniqid(),
                    'state' => $states[array_rand($states)],
                    'registered_agent_type' => RegisteredAgentType::USER,
                    'registered_agent_id' => null,
                ]);
            }
        }
    }
}
