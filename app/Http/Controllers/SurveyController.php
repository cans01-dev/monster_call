<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Models\Area;
use App\Models\Survey;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SurveyController extends Controller
{
    public function show (Request $request, Survey $survey) {
        $this->authorize('view', $survey);
        return view('pages.survey', ['survey' => $survey]);
    }

    public function store (Request $request, User $user) {
        if ($user->survey()->exists()) {
            return back()->with('toast', ['danger', '現在のユーザーでは一つ以上のアンケートを作成することはできません']);
        }
        $file_uniqid = config('app.default_greeting_file_name');
        Storage::copy('samples/defaultGreeting.wav', "users/{$user->id}/{$file_uniqid}.wav");

        $survey = new Survey();
        $survey->title = $request->title;
        $survey->note = $request->note;
        $survey->voice_name = $request->voice_name;
        $survey->save();

        return redirect("/surveys/{$request->id}")->with('toast', ['success', 'アンケートを新規作成しました']);
    }

    public function update (Request $request, Survey $survey) {
        $this->authorize('update', $survey);

        $survey->title = $request->title;
        $survey->note = $request->note;
        $survey->voice_name = $request->voice_name;
        $survey->success_ending_id = $request->success_ending_id;
        $survey->speaking_rate = $request->speaking_rate;
        $survey->save();
        
        return back()->with('toast', ['success', 'アンケートの情報を変更しました']);
    }

    public function destroy (Survey $survey) {
        $this->authorize('delete', $survey);
        $survey->delete();
        return redirect('/home')->with("toast", ["danger", "アンケートを削除しました"]);
    }

    public function asset (Request $request, Survey $survey) {
        $this->authorize('asset', $survey);
        $request->session()->put("referer", ["link" => $_SERVER["REQUEST_URI"], "text" => "アセット"]);
        $request->session()->forget('referer2');

        return view('pages.asset', [
            'survey' => $survey,
            'favoriteCreateDisabled' => count($survey->favorites) > 4,
            'numberListCreateDisabled' => count($survey->tel_lists) > 9
        ]);
    }

    public function stats (Request $request, Survey $survey) {
        $this->authorize('stats', $survey);
        $stats = [];
        $stats['collected_reservations'] = $survey->reservations()->where('status_id', 3)->count();
        $stats["all_calls"] = $survey->calls->count();
        $stats["responsed_calls"] = $survey->calls()->where('status', 1)->count();
        $stats["success_calls"] = $survey->answers()->whereIn(
            'option_id',
            $survey->success_ending_options()->pluck('id')
        )->count();
        $stats["all_actions"] = $survey->answers()->count();
        $stats["action_calls"] = $survey->calls()->has('answers')->count();
        $stats["total_duration"] = $survey->calls()->sum('duration');

        $billings = $survey->calls()->select(
            DB::raw('sum(duration) as `total_duration`'),
            DB::raw("DATE_FORMAT(date, '%Y-%m') date"),
            DB::raw('YEAR(date) year, MONTH(date) month')
        )->groupby('year','month')->get();

        return view('pages.stats', [
            'survey' => $survey,
            'def_areas' => Area::whereNull('survey_id')->get(),
            'stats' => $stats,
            'billings' => $billings
        ]);
    }

    public function update_greeting (Request $request, Survey $survey) {
        $this->authorize('update', $survey);

        $survey->greeting = $request->greeting;
        $survey->greeting_voice_file = $survey->greeting_voice_file_update();
        $survey->save();

        return back()->with('toast', ['success', 'グリーティングを変更しました']);
    }

    public function stats_area (Request $request, Survey $survey, Area $area) {
        $stats["all_numbers"] = $area->stations()->count() * 100000;
        $stats["called_numbers"] = 0;
        $stats["responsed_numbers"] = 0;
        foreach ($area->stations as $station) {
            $stats["called_numbers"] += $survey->calls()
                ->where('tel', 'like', "{$station->prefix}%")->count();

            $stats["called_numbers"] += $survey->calls()
                ->where('tel', 'like', "{$station->prefix}%")
                ->where('status', 1)
                ->count();
        }
        return view('pages.area', [
            'area' => $area,
            'stats' => $stats
        ]);
    }


    public function all_voice_file_re_gen (Survey $survey) {
        $survey->greeting_voice_file = $survey->greeting_voice_file_update();
        $survey->save();

        foreach ($survey->endings as $ending) {
            $ending->voice_file = $ending->voice_file_update();
            $ending->save();
        }

        foreach ($survey->faqs as $faq) {
            $faq->voice_file = $faq->voice_file_update();
            $faq->save();
        }

        return back()->with('toast', ['success', '全ての音声ファイルを変更しました']);
    }
}
