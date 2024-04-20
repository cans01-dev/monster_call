<?php

namespace Database\Seeders;

use App\Models\ReservationStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [1, "予約済", "primary"],
            [2, "確定済", "info"],
            // ["実行中", "light"],
            // ["集計中", "secondary"],
            [3, "集計済", "dark"]
        ];

        foreach ($statuses as $status) {
            ReservationStatus::create([
                'id' => $status[0],
                'title' => $status[1],
                'bg' => $status[2]
            ]);
        }
    }
}
