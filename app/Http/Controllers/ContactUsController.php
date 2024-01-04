<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Validator;
use App\Events\NotificationEvent;
use App\Notifications\Notifications;

use App\Models\User;
use App\Models\ContactUs;

class ContactUsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $prefix = Auth::check() ? ($request->user()->admin ? 'admin' : 'resident') : 'guest';
        return view($prefix.'.contact-us.index');
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
            'email' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'message' => ['required', 'string'],
        ]);

        if($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Invalid input found. Please corrent the errors and try again.', 'errors' => $validator->errors()]);
        }

        try {
            $concern = ContactUs::create([
                'email' => $request->email,
                'subject' => $request->subject,
                'message' => $request->message,
            ]);

            // Notify admin
            if(Auth::check()) {
                $userId = Auth::id();
                $username = Auth::user()->resident->only('fname', 'lname');
            }
            else {
                $userId = 0;
                $username = (object) ['username' => 'Guest User'];
            }

            $admin = User::where('admin', true)->first();
            $admin->notify(new Notifications($userId, "has sent their concern regarding {$request->subject}"), route('admin.concerns.show', $concern));
            event(new NotificationEvent($admin->id, $username, "has sent their concern regarding {$request->subject}"), route('admin.concerns.show', $concern));

            return response()->json(['success' => true, 'message' => 'Your concern has been sent successfully. Please wait for the administration\'s feedback.']);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send your concern. Please try again'.$e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $contactUs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactUs $contactUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $contactUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $contactUs)
    {
        //
    }
}
