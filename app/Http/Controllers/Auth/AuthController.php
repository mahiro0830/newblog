<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminFormRequest;
use App\Models\AdminUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    // public function __construct()
    // {
    //     $this->middleware('guest:admin')->except('admin.logout');
    // }

    /**
     * 
     * @return view
     */
    public function showLogin()
    {
        return view('admin.login_form');
    }

    /**
     * 
     * @param App\Http\Requests\AdminFormRequest $request
     */
    public function login(AdminFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if ( Auth::guard('admin')->attempt( $credentials ) )
        {
            $request->session()->regenerate();
            return redirect(route('admin.index'));
        }

        return back()->withErrors([
            'login_error' => 'メールアドレスかパスワードが間違っています。',
        ]);
    }

    /**
     * 
     * @param Request $request
     */
    public function logout(Request $request)
    {
        Auth::guard('admin')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect(route('admin.login'));
    }

    /**
     * 
     * @return view
     */
    public function index()
    {
        return view('admin.index');
    }
}
