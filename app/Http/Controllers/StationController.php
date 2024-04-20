<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Station;
use Illuminate\Http\Request;

class StationController extends Controller
{
    public function destroy (Station $station) {
        $station->delete();
        return back()->with("toast", ["danger", "マイエリアから局番を削除しました"]);
    }

    public function store (Request $request, Area $area) {
        $station = new Station();
        $station->area_id = $area->id;
        $station->prefix = str_replace('-', '', $request->prefix);
        $station->save();

        return back()->with("toast", ["success", "マイエリアに局番を追加しました"]);
    }
}
