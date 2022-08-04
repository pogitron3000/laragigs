<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function register() {
        return view('users.register');
    }
    public function store(Request $request) {
        $formFields = $request->validate([
            'name' => ['required', 'min:3'],
            'email' => ['required', 'email', Rule::unique('listings', 'email')],
            'password' => ['required', 'confirmed', 'min:6']
        ]);

        $formFields['password'] = bcrypt($formFields['password']);

        $user = User::create( $formFields);

        auth()->login($user);

        return redirect('/')->with('message', 'User successfully created and logged in');
    }

    public function logout(Request $request) {
        auth()->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/')->with('message', 'User logged out');

    }

    public function login() {
        return view('users.login');
    }

    public function authenticate(Request $request) {
        $formFields = $request->validate([
           'email' => 'required' ,
           'password' => 'required'
        ]);
        if(auth()->attempt($formFields)) {
            $request->session()->regenerate();

        return redirect('/')->with('message', 'User logged in ');
        }

        return back()->withErrors(['email'=>'Wrong Credentials']);
    }
}
