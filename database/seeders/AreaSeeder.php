<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $areas = [
            [1, '四国', NULL],
            [2, '中国', NULL],
            [3, '関西', NULL],
            [4, '関東&甲信越', NULL],
            [5, '東北', NULL],
            [6, '九州', NULL],
            [7, '中部', NULL],
            [8, '関東&中部', NULL],
            [9, '中国&九州&沖縄', NULL],
            [10, '関東（東京）', NULL],
            [11, '北海道', NULL],
            [12, '北陸', NULL],
            [13, '関東', NULL],
            [14, '沖縄', NULL],
            [15, '北海道&九州', NULL],
            [16, '北陸&中国&九州', NULL],
            [17, '中部&北陸', NULL],
            [18, '東京&中部&関西', NULL],
            [19, '中部&関西', NULL],
            [20, '関西&関東', NULL],
            [21, '関西&中部&東京', NULL],
            [22, '中国&九州&北陸', NULL],
            [23, '北海道&関西', NULL],
            [24, '東北&九州&四国', NULL],
            [25, '中国&四国&九州', NULL],
            [26, '中国&関西', NULL],
            [27, '東京&関西', NULL],
            [28, '中部&東京', NULL],
        ];

        foreach ($areas as $area) {
            Area::create([
                'id' => $area[0],
                'title' => $area[1],
                'survey_id' => $area[2]
            ]);
        }
    }
}
