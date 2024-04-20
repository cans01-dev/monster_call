<?php

namespace App\Http\Controllers;

use App\Models\SendEmail;
use App\Models\User;
use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    public function store (Request $request, User $user) {
        $send_email = new SendEmail();
        $send_email->email = $request->email;
        $send_email->enabled = $request->input('enabled', false);
        $user->send_emails()->save($send_email);

        return back()->with('toast', ['success', '送信先メールアドレスを追加しました']);
    }

    public function update (Request $request, SendEmail $send_email) {
        $this->authorize('update', $send_email);
        $send_email->update([
            'email' => $request->email,
            'enabled' => $request->input('enabled', false)
        ]);
        return back()->with('toast', ['success', '送信先メールアドレスを変更しました']);
    }

    public function destroy (Request $request, SendEmail $send_email) {
        $this->authorize('delete', $send_email);
        $send_email->delete();
        return back()->with('toast', ['success', '送信先メールアドレスを削除しました']);
    }
}
