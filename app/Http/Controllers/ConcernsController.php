<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\ReplyMail;
use Carbon\Carbon;
use Validator;

class ConcernsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $concerns = ContactUs::whereNull('replied_at')->latest('updated_at')->get();

        return view('admin.concerns.index')->with(['concerns' => $concerns]);
    }

    public function concerns()
    {
        $concerns = ContactUs::whereNull('replied_at')->latest('updated_at')->get();
        $view = view('admin.concerns.concerns')->with(['concerns' => $concerns])->render();

        return $view;
    }

    public function search(Request $request) 
    {
        $concerns = ContactUs::where(function($query) use ($request) {
            if($request->status_filter) {
                $query->whereNotNull('replied_at');
            }
            else {
                $query->whereNull('replied_at');
            }
        })->where(function($query) use($request) {
            $query->where('email', 'like', "%{$request->search}%")->orWhere('subject', 'like', "%{$request->search}%");
        })->latest('updated_at')->get();

        $view = view('admin.concerns.concerns')->with(['concerns' => $concerns])->render();

        return response()->json(['success' => true, 'view' => $view]);
    }

    public function preview(ContactUs $preview)
    {
        $view = view('admin.concerns.preview')->with(['concern' => $preview])->render();

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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(ContactUs $concern)
    {
        return view('admin.concerns.show')->with(['concern' => $concern]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ContactUs $concern)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ContactUs $concern)
    {
        $validator = Validator::make($request->input(), [
            'email' => ['required', 'email'],
            'subject' => ['required', 'string'],
            'reply' => ['required', 'string'],
        ]);

        if($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'Validation failed. Please try again.']);
        }

        try {
            // Send Mail
            Mail::to($request->email)->send(new ReplyMail($request->subject, $request->reply));

            $concern->replied_at = Carbon::now();
            $concern->save();

            return response()->json(['success' => true, 'message' => 'Reply sent successfully.', 'view' => $this->concerns()]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send reply to target email. Please try again.'.$e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ContactUs $concern)
    {
        //
    }
}
