<?php

namespace App\Http\Controllers;

use App\{User, Token};
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function create()
    {
        return view('login.create');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users'
        ]);

        $user = User::where('email', $request->get('email'))->first();

        Token::generateFor($user)->sendByEmail();

        return redirect()->route('login_confirmation');
    }

    public function confirm()
    {
        return view('login/confirm');
    }
}
