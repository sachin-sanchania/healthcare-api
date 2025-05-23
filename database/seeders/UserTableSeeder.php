<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Schema;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        User::truncate();
        Schema::enableForeignKeyConstraints();

        $users = [
            ['name' => 'John Doe', 'email' => 'johndoe@example.com'],
            ['name' => 'Jane Smith', 'email' => 'janesmith@example.com'],
            ['name' => 'Michael Johnson', 'email' => 'michaeljohnson@example.com'],
            ['name' => 'Sarah Davis', 'email' => 'sarahdavis@example.com'],
            ['name' => 'David Wilson', 'email' => 'davidwilson@example.com'],
            ['name' => 'Emily Brown', 'email' => 'emilybrown@example.com'],
            ['name' => 'Daniel Taylor', 'email' => 'danieltaylor@example.com'],
            ['name' => 'Olivia Miller', 'email' => 'oliviamiller@example.com'],
            ['name' => 'Sophia Williams', 'email' => 'sophiawilliams@example.com'],
            ['name' => 'Christopher Lee', 'email' => 'christopherlee@example.com'],
        ];

        foreach ($users as $user) {
            User::create([
                'name' => $user['name'],
                'email' => $user['email'],
                'password' => bcrypt('12345678'), // Set the password as 12345678
            ]);
        }
    }
}
