<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

use App\Models\Resident;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => ['required', 'string', 'max:255', 'unique:'.User::class],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],

            'fname' => ['required', 'string'],
            'mname' => ['nullable', 'string'],
            'lname' => ['required', 'string'],
            'birthdate' => ['required', 'date', 'before:today'],
            'gender' => ['required', 'in:male,female,others'],
            'phone' => ['required', 'string', 'regex:/^(09)+([\d]{9})$/'],
            'household_no' => ['required', 'integer'],
            'zone' => ['required', 'integer'],
            'civil_status' => ['required', 'in:single,married,widowed,separated'],
            'occupation' => ['required', 'string'],
            'nationality' => ['required', 'string'],
            'fourps_member' => ['required', 'boolean'],
            'fully_vaxxed' => ['required', 'boolean'],
            'voter' => ['required', 'boolean'],
        ]);

        try {
            $user = User::create([
                'username' => $request->username,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
    
            Resident::create([
                'user_id' => $user->id,
                'fname' => $request->fname,
                'mname' => $request->mname,
                'lname' => $request->lname,
                'birthdate' => $request->birthdate,
                'gender' => $request->gender,
                'phone' => $request->phone,
                'household_no' => $request->household_no,
                'zone' => $request->zone,
                'civil_status' => $request->civil_status,
                'occupation' => $request->occupation,
                'nationality' => $request->nationality,
                'fourps_member' => $request->fourps_member,
                'fully_vaxxed' => $request->fully_vaxxed,
                'voter' => $request->voter,
            ]);
    
            event(new Registered($user));
    
            Auth::login($user);
            if(Auth::user()->admin) {
                return redirect(RouteServiceProvider::ADMIN);
            }
            return redirect(RouteServiceProvider::RESIDENT);
        }
        catch(\Exception $e) {
            return redirect()->back()->withInput();
        }
    }
}
