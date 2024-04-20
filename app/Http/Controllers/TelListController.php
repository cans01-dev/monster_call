<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Models\Survey;
use App\Models\Tel;
use App\Models\TelList;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class TelListController extends Controller
{
    public function store (Request $request, Survey $survey) {
        if (count($survey->tel_lists) > 9) {
            return back()->with("toast", ["danger", "エラー！<br>予約パターンは最大10個までしか登録できません"]);
        }
        $tel_list = new TelList();
        $tel_list->title = $request->title;
        $tel_list->survey_id = $survey->id;
        $tel_list->save();

        return redirect("/tel_lists/{$tel_list->id}")->with("toast", ["success", "マイリストを作成しました"]);
    }

    public function show (Request $request, TelList $tel_list) {
        $this->authorize('view', $tel_list);
        $stats = [];
        $stats["all_calls"] = $tel_list->calls()->count();
        $stats["responsed_calls"] = $tel_list->calls()->where('status', 1)->count();
        $stats["success_calls"] = $tel_list->answers()->whereIn(
            'option_id',
            $tel_list->survey->success_ending_options()->pluck('id')
        )->count();
        $stats["all_actions"] = $tel_list->answers()->count();
        $stats["action_calls"] = $tel_list->calls()->has('answers')->count();
        $stats["total_duration"] = $tel_list->calls()->sum('duration');

        return view('pages.tel_list', [
            'tel_list' => $tel_list,
            'survey' => $tel_list->survey,
            'stats' => $stats,
        ]);
    }

    public function update (Request $request, TelList $tel_list) {
        $this->authorize('update', $tel_list);
        $tel_list->title = $request->title;
        $tel_list->save();

        return back()->with('toast', ['success', 'マイリストを更新しました']);
    }

    public function destroy (Request $request, TelList $tel_list) {
        $this->authorize('delete', $tel_list);
        $tel_list->delete();
        return redirect($request->redirect)->with("toast", ["danger", "マイリストを削除しました"]);
    }

    public function store_tel (Request $request, TelList $tel_list) {
        $number = str_replace('-', '', $request->tel);
        if (DB::table('tels')->where('tel_list_id', $tel_list->id)->where('tel', $number)->exists()) {
            return back()->with("toast", ["danger", "この電話番号はすでに追加されています"]);
        }

        $tel = new Tel();
        $tel->tel_list_id = $tel_list->id;
        $tel->tel = $number;
        $tel->save();

        return back()->with("toast", ["success", "電話番号を追加しました"]);
    }

    public function import_csv(Request $request, TelList $tel_list) {
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
        $success_tels = $no_error_tels->diff($tel_list->tels->pluck('tel'));
        $dup_tels = $no_error_tels->diff($success_tels);
    
        $insert_values = [];
        foreach ($no_error_tels as $tel) {
            $insert_values[] = [
                'tel_list_id' => $tel_list->id,
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
