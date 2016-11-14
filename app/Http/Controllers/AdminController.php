<?php

namespace App\Http\Controllers;

use Exception;
use Laravel\Socialite\Facades\Socialite;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth.backend',  ['except' => [
            'redirectToGoogle',
            'handleGoogleCallback',
            'logout',
            'notice'
        ]]);
    }

    public function notice()
    {
        return view('admin.notification');
    }

    /** Redirect to G+ authenticate.
     * @return mixed
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }


    /**
     * Handle callback from G+.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->user();

            if (isset(config('site.users')[$user->email])) {
                session()->put('admin_login', $user->email);
                return redirect('admin');
            } else {
                flash('User with email='.$user->email.' not existed in database.', 'error');
                return redirect('admin/notice');
            }
        } catch (Exception $e) {
            flash('Error exception : '.$e->getMessage(), 'error');
            return redirect('admin/notice');
        }

    }

    /**
     * Logout g+.
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        session()->forget('admin_login');
        flash('Goodbye!');
        return redirect('admin/notice');
    }

    public function index()
    {
       return view('admin.index');
    }

}
