<?php

namespace App\Http\Controllers;

use App\Models\Tel;
use App\Models\ForbiddenList;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ForbiddenListController extends Controller
{
    public function index (Request $request, Survey $survey) {
        $request->session()->put("referer", ["link" => $_SERVER["REQUEST_URI"], "text" => "禁止リスト"]);

        return view('pages.forbidden_lists', [
            'survey' => $survey,
            'forbidden_lists' => $survey->forbidden_lists,
            'forbiddenListCreateDisabled' => count($survey->forbidden_lists) > 9
        ]);
    }

    public function store (Request $request, Survey $survey) {
        if (count($survey->forbidden_lists) > 9) {
            return back()->with("toast", ["danger", "エラー！<br>予約パターンは最大10個までしか登録できません"]);
        }
        $forbidden_list = new ForbiddenList();
        $forbidden_list->title = $request->title;
        $forbidden_list->enabled = $request->input('enabled', false);
        $forbidden_list->survey_id = $survey->id;
        $forbidden_list->save();

        return redirect("/forbidden_lists/{$forbidden_list->id}")->with("toast", ["success", "マイリストを作成しました"]);
    }

    public function show (Request $request, ForbiddenList $forbidden_list) {
        $this->authorize('view', $forbidden_list);

        return view('pages.forbidden_list', [
            'forbidden_list' => $forbidden_list,
            'survey' => $forbidden_list->survey
        ]);
    }

    public function update (Request $request, ForbiddenList $forbidden_list) {
        $this->authorize('update', $forbidden_list);
        $forbidden_list->title = $request->title;
        $forbidden_list->enabled = $request->input('enabled', false);
        $forbidden_list->save();

        return back()->with('toast', ['success', 'マイリストを更新しました']);
    }

    public function destroy (Request $request, ForbiddenList $forbidden_list) {
        $this->authorize('delete', $forbidden_list);
        $forbidden_list->delete();
        return redirect($request->redirect)->with("toast", ["danger", "マイリストを削除しました"]);
    }

    public function store_tel (Request $request, ForbiddenList $forbidden_list) {
        $number = str_replace('-', '', $request->tel);
        if (DB::table('tels')->where('forbidden_list_id', $forbidden_list->id)->where('tel', $number)->exists()) {
            return back()->with("toast", ["danger", "この電話番号はすでに追加されています"]);
        }

        $tel = new Tel();
        $tel->forbidden_list_id = $forbidden_list->id;
        $tel->tel = $number;
        $tel->save();

        return back()->with("toast", ["success", "電話番号を追加しました"]);
    }

    public function import_csv(Request $request, ForbiddenList $forbidden_list) {
        $path = $request->file('file')->getRealPath();
        $fp = fopen($path, 'r');
        fgetcsv($fp);

        $no_error_tels = collect();
        $error_tels = collect();

        while($line = fgetcsv($fp)){
            $tel = $line[0];
            if ($tel[0] !== "0") $tel = "0" . $tel;
            if (strlen($tel) > 11) $tel = str_replace('-', '', $tel);
        
            if (preg_match('/^0[789]0[0-9]{8}$/', $tel)) {
                $no_error_tels->push($tel);
                continue;
            }
            $error_tels->push($tel);
        }
        
        $no_error_tels = collect($no_error_tels);
        $success_tels = $no_error_tels->diff($forbidden_list->tels->pluck('tel'));
        $dup_tels = $no_error_tels->diff($success_tels);
    
        $insert_values = [];
        foreach ($no_error_tels as $tel) {
            $insert_values[] = [
                'forbidden_list_id' => $forbidden_list->id,
                'tel' => $tel
            ];
        }
        foreach (array_chunk($insert_values, 10000) as $chunk) {
            DB::table('tels')->insertOrIgnore($chunk);
        }
      
        $success_count = $success_tels->count();
        return back()
            ->with("toast", ["success", "成功: {$success_count}件の電話番号を追加しました"])
            ->with("storeTelCsvResult", [$success_tels, $error_tels, $dup_tels]);
    }
}
