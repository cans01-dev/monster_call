<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use App\Models\Option;
use App\Models\Survey;
use Illuminate\Http\Request;

class FaqController extends Controller
{
    public function store (Request $request, Survey $survey) {
        $faq = new Faq();
        $faq->title = $request->title;
        $faq->text = $request->text;
        $faq->order_num = $survey->faqs()->max('order_num') + 1;
        $survey->faqs()->save($faq);
        
        $faq->voice_file = $faq->voice_file_update();
        $survey->faqs()->save($faq);

        $option = new Option();
        $option->title = '聞き直し';
        $option->dial = 0;
        $option->next_faq_id = $faq->id;
        $faq->options()->save($option);

        return redirect("/faqs/{$faq->id}")->with('toast', ['success', '質問を新規作成しました']);
    }

    public function show (Faq $faq) {
        $this->authorize('view', $faq);
        return view('pages.faq', [
            'faq' => $faq
        ]);
    }

    public function update (Request $request, Faq $faq) {
        $this->authorize('update', $faq);

        $faq->title = $request->title;
        $faq->text = $request->text;
        $faq->voice_file = $faq->voice_file_update();
        $faq->save();
        
        return back()->with('toast', ['success', '質問の設定を変更しました']);
    }

    public function destroy (Faq $faq) {
        $this->authorize('delete', $faq);
        $faq->delete();
        return redirect("/surveys/{$faq->survey_id}")->with("toast", ["danger", "質問を削除しました"]);
    }

    public function order (Request $request, Faq $faq) {
        $faq1 = $faq;
        
        if ($request->to === "up") {
            $faq2 = Faq::where("order_num", $faq1["order_num"] - 1)->where("survey_id", $faq1["survey_id"])->first();
            $faq1->decrement('order_num');
            $faq2->increment('order_num');
        } elseif ($request->to === "down") {
            $faq2 = Faq::where("order_num", $faq1["order_num"] + 1)->where("survey_id", $faq1["survey_id"])->first();;
            $faq1->increment('order_num');
            $faq2->decrement('order_num');
        }

        return back()->with("toast", ["success", "質問の並び順を変更しました"]);
    }
}
