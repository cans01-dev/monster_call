<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class AdminUserController extends Controller
{
    public function index () {
        $users = User::all();
        $roles = Role::all();
        return view('pages.admin.users', ['users' => $users, 'roles' => $roles]);
    }

    public function store (Request $request) {
        if ($request->password !== $request->password_confirm) {
            return back()->with('toast', ['danger', 'パスワードの再入力が正しくありません'])->withInput();
        }
        if (User::where('email', $request->email)->exists()) {
            return back()->with('toast', ['danger', 'このメールアドレスは既に使用されています'])->withInput();
        }

        DB::transaction(function () use ($request) {
            $user = new User();
            $user->email = $request->email;
            $user->password = $request->password;
            $user->role_id = $request->role_id;
            $user->number_of_lines = $request->number_of_lines;
            $user->name = $request->name;
            $user->role_id = $request->role_id;
            $user->save();
            $user->makeDirectory();
            $user->init();
        });

        return back()->with('toast', ['success', 'ユーザーを新規作成しました']);
    }

    public function update (Request $request, User $user) {
        $user->role_id = $request->role_id;
        $user->number_of_lines = $request->number_of_lines;
        $user->save();
        
        return back()->with('toast', ['success', 'ユーザー情報を変更しました']);
    }

    public function destroy (Request $request, User $user) {
        $user->deleteDirectory();
        $user->delete();
        return back()->with('toast', ['success', 'ユーザーを削除しました']);
    }

    public function update_password (Request $request, User $user) {
        if ($request->new_password !== $request->new_password_confirm) {
            back()->with('toast', ['success', 'パスワードの再入力が正しくありません']);
        }
        $user->password = $request->new_password;
        $user->save();

        return back()->with('toast', ['success', 'パスワードを変更しました']);
    }

    public function clean_dir(User $user) {
        $count = $user->deleteAllFile();

        return back()->with('toast', ['success', "{$user->email}のディレクトリ内{$count}件のファイルを削除しました"]);
    }
}
