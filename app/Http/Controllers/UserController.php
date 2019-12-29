<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller {
    public function index () {
        $users = User::all();

        return view('users.index', compact('users'));
    }

    public function create (Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'login' => 'required|unique:users,login',
                'password' => 'required',
            ]);

            $user = User::create([
                'login' => $request->login,
                'password' => bcrypt($request->password),
                'is_admin' => $request->has('is_admin'),
                'horoscopes' => $request->has('horoscopes'),
                'clients' => $request->has('clients'),
                'chats' => $request->has('chats'),
                'templates' => $request->has('templates'),
                'users' => $request->has('users'),
                'rules' => $request->has('rules'),
            ]);

            return redirect()->route('users.index')->with('success', true);
        }

        return view('users.create');
    }

    public function update (Request $request, User $user) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'login' => 'required' . ($user->login != $request->login ? '|unique:users,login' : ''),
            ]);

            $user->login = $request->login;

            if ($request->has('password') && !is_null($request->password)) {
                $user->password = bcrypt($request->password);
            }

            $user->is_admin = $request->has('is_admin');
            $user->horoscopes = $request->has('horoscopes');
            $user->clients = $request->has('clients');
            $user->chats = $request->has('chats');
            $user->templates = $request->has('templates');
            $user->users = $request->has('users');
            $user->rules = $request->has('rules');

            $user->save();

            return redirect()->route('users.index')->with('success', true);
        }

        return view('users.update', compact('user'));
    }

    public function delete (User $user) {
        $user->delete();

        return redirect()->route('users.index')->with('success', true);
    }
}
