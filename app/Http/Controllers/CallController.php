<?php

namespace App\Http\Controllers;

use App\Libs\MyUtil;
use App\Models\Call;
use App\Models\Station;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class CallController extends Controller
{
    public function index (Request $request, Survey $survey) {
        $this->authorize('view', $survey);
        $page = $request->page ?? 1;
        $limit = 100;
        $start = $request->start ?? date('Y-m-d', strtotime('first day of this month'));
        $end = $request->end ?? date('Y-m-d', strtotime('last day of this month'));
        $number = "%" . $request->number . "%";
        $status = $request->status ?? [1, 2, 3, 4, 6];
        $offset = (($page) - 1) * $limit;

        $query = $survey->calls()
        ->whereBetween('date', [$start, $end])
        ->where('tel', 'like', $number)
        ->whereIn('status', $status);

        $pgnt = MyUtil::pagenation($limit, $query->count(), $page);

        return view('pages.calls', [
            'survey' => $survey,
            'calls' => $query->limit($limit)->offset($offset)->get(),
            'pgnt' => $pgnt,
            'stations' => Station::all(),
            'status' => $status,
        ]);
    }

    public function show (Request $request, Call $call) {
        $this->authorize('view', $call);
        return view('pages.call', [
            'call' => $call
        ]);  
    }

    public function export (Request $request) {
        $start = $request->start ?? date('Y-m-d', strtotime('first day of this month'));
        $end = $request->end ?? date('Y-m-d', strtotime('last day of this month'));
        $number = "%" . $request->number . "%";
        $status = $request->status ?? [1, 2, 3, 4, 6];

        // 制作中
    }
}
