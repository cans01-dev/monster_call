<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Models\Ending;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EndingController extends Controller
{
    public function store (Request $request, Survey $survey) {
        $ending = new Ending();
        $ending->title = $request->title;
        $ending->text = $request->text;
        $survey->endings()->save($ending);

        $ending->voice_file = $ending->voice_file_update();
        $ending->save();

        return back()->with('toast', ['success', "エンディングを作成しました"]);
    }

    public function update (Request $request, Ending $ending) {
        $this->authorize('update', $ending);

        $ending->title = $request->title;
        $ending->text = $request->text;
        $ending->voice_file = $ending->voice_file_update();
        $ending->save();

        return back()->with('toast', ['success', 'エンディングを変更しました']);
    }

    public function destroy (Ending $ending) {
        $this->authorize('delete', $ending);
        $ending->delete();
        return redirect("/surveys/{$ending->survey_id}")->with("toast", ["danger", "エンディングを削除しました"]);
    }
}
