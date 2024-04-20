<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
    public function receive_result (Request $request) {
        $file_path = $request->file('file')->getRealPath();
        $contents = file_get_contents($file_path);
        $json = json_decode($contents, true);

        $reservation = Reservation::find($json["id"]);
        if ($reservation->status_id === 3) {
            Log::error('[予約: {id}]この予約は既に結果を受信しています', ['id' => $reservation->id]);
            abort(422, 'この予約は既に結果を受信しています');
        }

        $reservation->collect($json, basename($file_path));

        Log::info('[予約: {id}]結果ファイルをAPIから受信しました', ['id' => $reservation->id]);
        return response('結果ファイルをAPIから受信しました');
    }
}
