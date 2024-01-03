<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use Validator;

use App\Models\User;
use App\Models\Resident;
use App\Notifications\Notifications;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $users = User::with('resident')->whereHas('resident', function($query) {
        //     $query->latest('updated_at');
        // })->where('admin', false)->latest('updated_at')->get();
        $users = User::join('residents', 'residents.user_id', 'users.id')->where('admin', false)->select('residents.*', 'users.id', 'users.username', 'users.email')->latest('residents.updated_at')->get();
        return view('admin.residents.index')->with(['users' => $users]);
    }

    public function residents()
    {
        // $users = User::with('resident')->whereHas('resident', function($query) {
        //     $query->latest('updated_at');
        // })->where('admin', false)->latest('updated_at')->get();
        $users = User::join('residents', 'residents.user_id', 'users.id')->where('admin', false)->select('residents.*', 'users.id', 'users.username', 'users.email')->latest('residents.updated_at')->get();
        $view = view('admin.residents.residents')->with(['users' => $users])->render();

        return $view;
    }

    public function search(Request $request) {
        // $users = User::with('resident')->whereHas('resident', function($query) use($request) {
        //     $query->where('fname', 'like', "%{$request->search}%")->orWhere('lname', 'like', "%{$request->search}%")->orWhere('mname', 'like', "%{$request->search}%")->orWhere('phone', 'like', "%{$request->search}%");
        // })->latest('updated_at')->get();

        $users = User::join('residents', 'residents.user_id', 'users.id')->where(function($query) use($request) {
            $query->where('fname', 'like', "%{$request->search}%")->orWhere('lname', 'like', "%{$request->search}%")->orWhere('mname', 'like', "%{$request->search}%")->orWhere('phone', 'like', "%{$request->search}%")->orWhere('username', 'like', "%{$request->search}%")->orWhere('email', 'like', "%{$request->search}%");
        })->select('residents.*', 'users.id', 'users.username', 'users.email')->latest('residents.updated_at')->get();

        $view = view('admin.residents.residents')->with(['users' => $users])->render();

        return response()->json(['success' => true, 'view' => $view]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
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

        if($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validaiton failed. Please try again.', 'errors' => $validator->errors()]);
        }

        $password = Str::random(8);

        try {
            $user = User::create([
                'username' => Str::random(12),
                'email' => $request->email,
                'password' => Hash::make($password),
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

            return response()->json(['success' => true, 'message' => 'New resident has been added successfully.', 'view' => $this->residents()]);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to add new resident. Please try again.'.$e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        $view = view('admin.residents.edit')->with(['user' => $user->load('resident')])->render();

        return response()->json(['success' => true, 'view' => $view]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $validator = Validator::make($request->input(), [
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
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

        if($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validaiton failed. Please try again.', 'errors' => $validator->errors()]);
        }

        try {
            // Update Residents Table;
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

            // Update Users Table;
            $user->email = $request->email;
            $user->save();

            return response()->json(['success' => true, 'message' => 'Resident Information has been updated successfully.', 'view' => $this->residents()]);
        }

        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to updated resident information. Please try again.'.$e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();

            return response()->json(['success' => true, 'message' => 'The selected resident has been deleted successfully.', 'view' => $this->residents()]);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to delete resident record. Please try again.'.$e]);
        }
    }
}
