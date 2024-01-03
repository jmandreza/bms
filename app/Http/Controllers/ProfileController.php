<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user()->load('resident'),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function updatePersonal(Request $request, User $user)
    {
        $request->validate([
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
            $user->resident->lname = $request->lname;
            $user->resident->fname = $request->fname;
            $user->resident->mname = $request->mname;
            $user->resident->birthdate = $request->birthdate;
            $user->resident->gender = $request->gender;
            $user->resident->phone = $request->phone;
            $user->resident->household_no = $request->household_no;
            $user->resident->zone = $request->zone;
            $user->resident->civil_status = $request->civil_status;
            $user->resident->occupation = $request->occupation;
            $user->resident->nationality = $request->nationality;
            $user->resident->fourps_member = $request->fourps_member;
            $user->resident->fully_vaxxed = $request->fully_vaxxed;
            $user->resident->voter = $request->voter;
            $user->resident->save();

            return redirect()->back();
        }
        catch(\Exception $e) {
            return redirect()->back()->withErrors();
        }
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
