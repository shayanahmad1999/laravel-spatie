<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('dashboard');
            } else {
                return redirect()->route('login')->with('error', 'Either email or password is incorrect.');
            }
        } else {
            return redirect()->route('login')->withInput()->withErrors($validator);
        }
    }
    public function dashboard()
    {
        $data['users'] = User::all();
        $data['roles'] = Role::all();
        return view('dashboard')->with($data);
    }
    public function logout()
    {
        Auth::logout();
        return redirect()->route('login');
    }
}
