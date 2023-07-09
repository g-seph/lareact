<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function loginPage(): \Illuminate\Contracts\View\View|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('user.login-page');
    }

    /**
     * @throws ValidationException
     */
    public function login(FormRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'email' => 'required',
            'password' => 'required'
        ]);
        $authenticated = Auth::attempt([
            'email' => $request->input('email'),
            'password' => $request->input('password'),
        ]);
        if ($authenticated) {
            return redirect()->route('home.page');
        }
        return redirect()->back();
    }
    public function registerPage() {
        return view('user.register-page');
    }

    /**
     * @throws ValidationException
     */
    public function register(FormRequest $request): \Illuminate\Http\RedirectResponse
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:8'
        ]);

        $user = new User([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
        $user->save();
        return redirect()->route('login.page');
    }

    public function userDetails() {
        if (!Auth::check())
            return redirect()->route('home.page')->with(
                [
                    'errors' => new Collection(['Must be logged in'])
                ]
            );
        return view('user.details');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('home.page');
    }
}
