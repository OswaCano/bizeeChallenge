<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            ['name' => 'Oswaldo', 'email' => 'oswa@mail.com', 'password' => bcrypt('Gato0123')],
            ['name' => 'Robert', 'email' => 'robert@mail.com', 'password' => bcrypt('Perro456')],
            ['name' => 'Ricardo', 'email' => 'ricardo@mail.com', 'password' => bcrypt('Loro7890')],
            ['name' => 'Juan', 'email' => 'juan@mail.com', 'password' => bcrypt('Elefante309')],
            ['name' => 'Jair', 'email' => 'jair@mail.com', 'password' => bcrypt('Tigre247')],
            ['name' => 'Lalo', 'email' => 'lalo@mail.com', 'password' => bcrypt('Pantera97')],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
