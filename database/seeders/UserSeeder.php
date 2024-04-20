<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@example.com';
        $user->password = Hash::make('password');
        $user->role_id = 2;
        $user->number_of_lines = 0;
        $user->save();

        $user->makeDirectory();
        $user->init();

        $user = new User();
        $user->name = 'test';
        $user->email = 'test@example.com';
        $user->password = Hash::make('password');
        $user->role_id = 1;
        $user->number_of_lines = 100;
        $user->save();

        $user->makeDirectory();
        $user->init();
    }
}
