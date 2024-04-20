<?php

namespace App\Http\Controllers;

use App\Models\Area;
use App\Models\Favorite;
use App\Models\Survey;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    public function store (Request $request, Survey $survey) {
        if (strtotime($request->start_at) + 3600 > strtotime($request->end_at)) {
            return back()->with("toast", ["danger", "開始・終了時間は".(config('app.MIN_INTERVAL') / 3600)."時間以上の間隔をあけてください"]);
        }
        if (count($survey->favorites) > 4) {
            return back()->with("toast", ["danger", "エラー！<br>予約パターンは最大５つまでしか登録できません"]);
        }

        $favorite = new Favorite();    
        $favorite->survey_id = $survey->id;
        $favorite->title = $request->title;
        $favorite->color = $request->color;
        $favorite->start_at = $request->start_at;
        $favorite->end_at = $request->end_at;
        $favorite->save();

        return redirect("/favorites/{$favorite->id}")->with("toast", ["success", "お気に入り設定を追加しました"]);
    }

    public function show (Request $request, Favorite $favorite) {
        $this->authorize('view', $favorite);
        $request->session()->put("referer2", ["link" => $_SERVER["REQUEST_URI"], "text" => "予約パターン: {$favorite["title"]}"]);

        return view('pages.favorite', [
            'favorite' => $favorite,
            'survey' => $favorite->survey,
            'areas' => Area::whereNull('survey_id')->get()
        ]);
    }

    public function update (Request $request, Favorite $favorite) {
        $this->authorize('update', $favorite);
        $favorite->title = $request->title;
        $favorite->color = $request->color;
        $favorite->start_at = $request->start_at;
        $favorite->end_at = $request->end_at;
        $favorite->tel_list_id = $request->tel_list_id;
        $favorite->save();

        return back()->with('toast', ['success', '予約パターンを更新しました']);
    }

    public function destroy (Request $request, Favorite $favorite) {
        $this->authorize('delete', $favorite);
        $favorite->delete();
        return redirect($request->redirect)->with("toast", ["danger", "予約パターンを削除しました"]);
    }

    public function attach_area (Request $request, Favorite $favorite) {
        $favorite->areas()->attach($request->area_id);

        return back()->with("toast", ["success", "エリアを追加しました"]);
    }

    public function detach_area (Request $request, Favorite $favorite) {
        $favorite->areas()->detach($request->area_id);

        return back()->with("toast", ["danger", "エリアを削除しました"]);
    }

}
