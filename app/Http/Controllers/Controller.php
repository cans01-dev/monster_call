<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Mail\ContactForm;
use App\Models\Reservation;
use Illuminate\Support\Str;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;

    public function home (Request $request) {
        $survey = $request->user()->survey;

        $page = $request->page ?? 1;
        $limit = 100;
        $start = $request->start ?? date('Y-m-d', strtotime('first day of this month'));
        $end = $request->end ?? date('Y-m-d', strtotime('last day of this month'));
        $offset = (($page) - 1) * $limit;

        $reservations = Reservation::where('survey_id', $survey->id)
            ->whereBetween('date', [$start, $end])
            ->offset($offset)->limit($limit)->orderBy('date', 'desc')
            ->get();

        $count = Reservation::where('survey_id', $survey->id)
            ->whereBetween('date', [$start, $end])
            ->count();
      
        $pgnt = MyUtil::pagenation($limit, $count, $page);


        $request->session()->put("referer", ["link" => $_SERVER["REQUEST_URI"], "text" => "ホーム"]);
    
        return view('pages.home', [
            'survey' => $survey,
            'reservations' => $reservations,
            'pgnt' => $pgnt
        ]);
    }

    public function support (Request $request) {
        $markdown = Str::markdown(Storage::disk('public')->get('support.md'));
        return view('pages.support', [
            'markdown' => $markdown
        ]);
    }

    public function send_contact (Request $request) {
        $user = $request->user();
        Mail::to('autocall@e-ivr.net')->send(new ContactForm(
            $request->type,
            $request->text,
            $user->email,
            url("/users/{$user->id}")
        ));

        return back()->with('toast', ['success', 'お問い合わせを送信しました']);
    }
}
