<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Mail\ReservationCollected;
use App\Models\Reservation;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class AdminReservationController extends Controller
{
    public function index (Request $request) {
        $page = $request->query('page') ?? 1;
        $limit = 100;
        $start = $request->query('start') ?? date('Y-m-d', strtotime('first day of this month'));
        $end = $request->query('end') ?? date('Y-m-d', strtotime('last day of this month'));
        $offset = (($page) - 1) * $limit;
        
        $user_id = $request->query('user_id');
            
        $count = Reservation::join('surveys', 'reservations.survey_id', '=', 'surveys.id')
            ->whereBetween('reservations.date', [$start, $end])
            ->when($user_id, function (Builder $query, $user_id) {
                $query->where('surveys.user_id', $user_id);
            })->count();
        $pgnt = MyUtil::pagenation($limit, $count, $page);

        $reservations = Reservation::whereBetween('reservations.date', [$start, $end])
            ->offset($offset)->limit($limit)->orderBy('date', 'desc')->get();
      
        return view('pages.admin.reservations', [
            'reservations' => $reservations,
            'pgnt' => $pgnt,
            'users' => User::all()
        ]);
    }

    public function forward_confirmed (Reservation $reservation) {
        $reservation->confirm();

        Log::info('[予約: {id}]手動で予約情報ファイルを生成しステータスを確定済にしました', ['id' => $reservation->id]);
        return back()->with("toast", ["success", "予約情報ファイルを生成しステータスを確定済にしました"]);      
    }

    public function back_reservationd (Reservation $reservation) {
        $reservation->status_id = 1;
        $reservation->reservation_file = null;
        $reservation->save();
      
        Log::info('[予約: {id}]手動で予約情報ファイルを削除しステータスを予約済に戻しました', ['id' => $reservation->id]);
        return back()->with("toast", ["success", "ステータスを予約済に戻しました"]);
    }

    public function forward_collected (Request $request, Reservation $reservation) {
        $file_path = $request->file('file')->store('uploads');
        $json = Storage::json($file_path);
      
        if ($json["id"] == $reservation->id) {
            $reservation->collect($json, basename($file_path));
            Log::info('[予約: {id}]手動で結果ファイルを受信しました', ['id' => $reservation->id]);
            return back()->with("toast", ["success", "結果ファイルを処理しステータスを集計済にしました"]); 
        }
        return back()->with("toast", ["error", "指定された予約と結果ファイルの予約が異なります"]);    
    }

    public function generate_sample_result (Reservation $reservation) {
        $file_name = "ac_res{$reservation->id}_{$reservation->date}.json";
        $file_contents = $reservation->generate_sample_result([1,2,2,3,3,4,4,6,6]);

        $file_path = "users/{$reservation->survey->user_id}/outputs/{$file_name}";
        storage::disk('public')->put($file_path, $file_contents);
        return Storage::download('public/'.$file_path);
    }

    public function back_confirmed (Reservation $reservation) {
        $reservation->status_id = 2;
        $reservation->result_file = null;
        $reservation->save();

        $reservation->answers()->delete();
        $reservation->calls()->delete();

        return back()->with("toast", ["success", "結果データを削除しステータスを確定済に戻しました"]);
    }
}
