<?php

namespace App\Http\Controllers;

use App\Libs\MyCalendar;
use App\Models\Area;
use App\Models\Favorite;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use App\Models\Survey;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index (Request $request, Survey $survey, ?int $year=null, ?int $month=null, ?string $mode='month') {
        $this->authorize('view', $survey);
        $year = $year ?? date("Y");
        $month = $month ?? date("m");
        
        $reservations = $survey->reservations()->whereMonth('date', $month)->whereYear('date', $year)->orderBy('date', 'desc')->get();
      
        $schedules = [];
        foreach ($reservations as $reservation) {
          $day = date("d", strtotime($reservation->date));
          $schedules[$day] = $reservation;
        }
        $calendar = new MyCalendar($month, $year, $schedules);      

        $request->session()->put("referer", ["link" => $_SERVER["REQUEST_URI"], "text" => "カレンダー {$year}年 {$month}月"]);

        return view('pages.reservations', [
            'survey' => $survey,
            'reservations' => $reservations,
            'calendar' => $calendar,
            'mode' => $mode,
            'statuses' => ReservationStatus::all()
        ]);
    }

    public function store (Request $request, Survey $survey) {
        if ($favorite = Favorite::find($request->favorite_id)) {
            $reservation = new Reservation();
            $reservation->survey_id = $survey->id;
            $reservation->date = $request->date;
            $reservation->start_at = $favorite->start_at;
            $reservation->end_at = $favorite->end_at;
            $reservation->status_id = 1;
            $reservation->tel_list_id = $favorite->tel_list_id;
            $reservation->save();

            foreach ($favorite->areas as $area) {
                $reservation->areas()->attach($area->id);
            }
            return back()->with("toast", ["success", "パターンから予約を作成しました"]);
        } else {
            if (strtotime($request->start_at) + 3600 > strtotime($request->end_at)) {
                return back()->with("toast", ["danger", "開始・終了時間は".(config('app.MIN_INTERVAL') / 3600)."時間以上の間隔をあけてください"]);
            }
            $reservation = new Reservation();
            $reservation->survey_id = $survey->id;
            $reservation->date = $request->date;
            $reservation->start_at = $request->start_at;
            $reservation->end_at = $request->end_at;
            $reservation->status_id = 1;
            $reservation->save();
        }
        return redirect("/reservations/{$reservation->id}")->with("toast", ["success", "予約を作成しました"]);      
    }

    public function show (Request $request, Reservation $reservation) {
        $this->authorize('view', $reservation);
        $request->session()->put("referer2", ["link" => $_SERVER["REQUEST_URI"], "text" => "予約: {$reservation->date}"]);

        $stats = [];
        if ($reservation->status_id === 3) {
            $stats["all_calls"] = $reservation->calls()->count();
            $stats["responsed_calls"] = $reservation->calls()->where('status', 1)->count();
            $stats["success_calls"] = $reservation->answers()->whereIn(
                'option_id',
                $reservation->survey->success_ending_options()->pluck('id')
            )->count();
            $stats["all_actions"] = $reservation->answers()->count();
            $stats["action_calls"] = $reservation->calls()->has('answers')->count();
            $stats["total_duration"] = $reservation->calls()->sum('duration');
        }

        return view('pages.reservation', [
            'reservation' => $reservation,
            'survey' => $reservation->survey,
            'areas' => Area::whereNull('survey_id')->get(),
            'stats' => $stats
        ]);
    }

    public function update (Request $request, Reservation $reservation) {
        $this->authorize('update', $reservation);
        if (strtotime($request->start_at) + 3600 > strtotime($request->end_at)) {
            return back()->with("toast", ["danger", "開始・終了時間は".(config('app.MIN_INTERVAL') / 3600)."時間以上の間隔をあけてください"]);
        }
        $reservation->start_at = $request->start_at;
        $reservation->end_at = $request->end_at;
        $reservation->tel_list_id = $request->tel_list_id ? $request->tel_list_id : null;
        $reservation->save();

        return back()->with("toast", ["success", "予約の基本設定を変更しました"]);
    }
      

    public function destroy (Request $request, Reservation $reservation) {
        $this->authorize('delete', $reservation);
        $reservation->delete();
        return redirect($request->redirect)->with("toast", ["danger", "予約を削除しました"]);
    }

    public function attach_area (Request $request, Reservation $reservation) {
        $reservation->areas()->attach($request->area_id);

        return back()->with("toast", ["success", "エリアを追加しました"]);
    }

    public function detach_area (Request $request, Reservation $reservation) {
        $reservation->areas()->detach($request->area_id);

        return back()->with("toast", ["danger", "エリアを削除しました"]);
    }
}
