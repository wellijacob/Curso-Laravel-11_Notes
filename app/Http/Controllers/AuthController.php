<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    public function login()
    {
        return view('login');
    }

    public function loginSubmit(Request $request)
    {
        // validação do login
        $request->validate(
            // rules
            [
                'text_username' => 'required|email',
                'text_password' => 'required|min:6|max:12',
            ],
            // messages
            [
                'text_username.required' => 'O campo username é obrigatório',
                'text_username.email' => 'O campo username deve ser um email',
                'text_password.required' => 'O campo password é obrigatório',
                'text_password.min' => 'O campo password deve ter pelo menos :min caracteres',
                'text_password.max' => 'O campo password deve ter no máximo :max caracteres',
            ]
        );

        // get username and password from request
        $username = $request->input('text_username');
        $password = $request->input('text_password');

        // Verifica se o usuário existe
        $user = User::where('username', $username)
            ->where('deleted_at', null)
            ->first();

        // Verifica se o usuário existe
        if (!$user) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password inválido');
        }

        // Verifica se a password correta
        if (!password_verify($password, $user->password)) {
            return redirect()
                ->back()
                ->withInput()
                ->with('loginError', 'Username ou password inválido');
        }

        // update last login
        $user->last_login = now();
        $user->save();

        // login user
        session([
            'user' => [
                'id' => $user->id,
                'username' => $user->username
            ]
        ]);

        return redirect()->to('/');
    }

    public function logout()
    {
        // Logout user
        session()->forget('user');
        return redirect()->to('/login');
    }
}
