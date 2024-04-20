<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [1, '一般', 'primary'],
            [2, '管理者', 'info'],
            [3, '利用停止', 'secondary']
        ];

        foreach ($roles as $role) {
            Role::create([
                'id' => $role[0],
                'title' => $role[1],
                'bg' => $role[2]
            ]);
        }
    }
}
