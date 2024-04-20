<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OptionController extends Controller
{
    public function store (Request $request, Faq $faq) {
        $options = $faq->options;
        $next_type = substr($request->next, 0, 1);
        $next_id = substr($request->next, 1);

        $option = new Option();
        $option->faq_id = $faq["id"];
        $option->title = $request->title;
        $option->dial = count($options) ? $options->max("dial") + 1 : 0;
        $option->next_ending_id = $next_type == "e" ? $next_id : null;
        $option->next_faq_id = $next_type == "f" ? $next_id : null;
        $option->save();

        return back()->with("toast", ["success", "選択肢を新規作成しました"]);
    }

    public function update (Request $request, Option $option) {     
        $this->authorize('update', $option);   
        $next_type = substr($request->next, 0, 1);
        $next_id = substr($request->next, 1);

        $option->title = $request->title;
        $option->next_ending_id = $next_type == "e" ? $next_id : null;
        $option->next_faq_id = $next_type == "f" ? $next_id : null;
        $option->save();

        return back()->with("toast", ["success", "選択肢の設定を変更しました"]);
    }

    public function destroy (Option $option) {
        $this->authorize('delete', $option); 
        $target_options = Option::where("faq_id", $option["faq_id"])->where("dial", ">", $option["dial"])->get();
        foreach ($target_options as $to) {
            $to->dial = $to->dial - 1;
            $to->save();
        }
        
        $option->delete();

        return redirect("/faqs/{$option["faq_id"]}")->with("toast", ["info", "選択肢を削除しました"]);
    }

    public function change_order (Request $request, Option $option) {
        $option1 = $option;
        
        if ($request->to === "up") {
            $option2 = Option::where("dial", $option1["dial"] - 1)->where("faq_id", $option1["faq_id"])->first();
            $option1->decrement('dial');
            $option2->increment('dial');
        } elseif ($request->to === "down") {
            $option2 = Option::where("dial", $option1["dial"] + 1)->where("faq_id", $option1["faq_id"])->first();;
            $option1->increment('dial');
            $option2->decrement('dial');
        }

        return back()->with("toast", ["success", "選択肢のダイヤルを変更しました"]);
      }      
}
