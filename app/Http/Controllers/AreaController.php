<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Station;
use App\Models\Survey;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function store (Request $request, Survey $survey) {
        $area = new Area();
        $area->title = $request->title;
        $area->survey_id = $survey->id;
        $area->save();

        return redirect("/areas/{$area->id}")->with("toast", ["success", "マイエリアを新規登録しました"]);
    }

    public function show (Area $area) {
        $this->authorize('view', $area);
        return view('pages.area', [
            'area' => $area,
            'areas' => Area::whereNull('survey_id')->get()
        ]);
    }

    public function update (Request $request, Area $area) {
        $this->authorize('update', $area);
        $area->title = $request->title;
        $area->save();

        return back()->with('toast', ['success', 'マイエリアを更新しました']);
    }

    public function destroy (Request $request, Area $area) {
        $this->authorize('delete', $area);
        $area->delete();
        return redirect($request->redirect)->with("toast", ["danger", "マイエリアを削除しました"]);
    }
}
