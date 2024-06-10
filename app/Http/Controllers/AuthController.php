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
    public function register(Request $request)
    {
        return view('register');
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
    public function registerAuthenticate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed|min:6'
        ]);

        $user = User::create($validator->validate());

        Auth::login($user);
        
        return redirect()->route('dashboard');
           
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
