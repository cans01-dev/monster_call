<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function show (User $user) {
        $this->authorize('view', $user);
        return view('pages.user', ['user' => $user]);
    }

    public function update (Request $request, User $user) {
        $this->authorize('update', $user);
        $user->email = $request->email;
        $user->name = $request->name;
        $user->save();
        
        return back()->with('toast', ['success', 'ユーザー情報を変更しました']);
    }

    public function update_password (Request $request, User $user) {
        $this->authorize('update', $user);
        if (!password_verify($request->old_password, $user->password)) {
            return back()->with('toast', ['danger', '現在のパスワードが異なります']);
        }
        if ($request->new_password !== $request->new_password_confirm) {
            return back()->with('toast', ['danger', '新しいパスワードの再入力が正しくありません']);
        }
        $user->password = $request->new_password;
        $user->save();

        return back()->with('toast', ['success', 'パスワードを変更しました']);
    }
}
