<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use App\Models\Document;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

use Validator;
use App\Events\NotificationEvent;
use App\Notifications\Notifications;
use App\Enums\StatusEnum;

class DocumentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // if(Auth::user()->admin) {
        //     $prefix = "admin";
        //     $requests = DocumentRequest::with(['document', 'user' => function($query) {
        //         $query->with('resident')->select('user_id', 'lname', 'fname', 'name', 'household_no', 'zone');
        //         $query->select('id');
        //     }])->where(function($query) {
        //         $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Accepted);
        //     })->get();
        //     return view('admin.requests.index')->with(['requests' => $requests]);
        // }
        
        $prefix = Auth::user()->admin ? "admin" : "resident";
        $documents = Document::all();
        return view('resident.requests.index')->with(['documents' => $documents]);   
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
        try {
            $validator = Validator::make($request->input(), [
                'document_id' => ['required', 'exists:documents,id'],
                'purpose'  => ['required', 'string', 'min:1'],
            ]);
    
            if($validator->fails()) {
                return response()->json(['success' => false, 'message' => 'Validation fails. Please check your inputs and try again.', 'errors' => $validator->errors()]);
            }

            // // Check if Ongoing Request Exists
            // $exists = DocumentRequest::where(function($query) use ($request) {
            //     $query->where('user_id', Auth::id());
            //     $query->where('document_id', $request->document_id);
            //     $query->where(function($query) {
            //         $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
            //     });
            // })->exists();
            
            // if($exists) {
            //     return response()->json(['success' => false, 'message' => 'Ongoing request for this document exists. Request not sent']);
            // }
    
            DocumentRequest::create([
                'user_id' => Auth::id(),
                'document_id' => $request->document_id,
                'purpose' => $request->purpose,
            ]);

            // Notify Admin
            $admin = User::where('admin', true)->first();
            $document = Document::find($request->document_id);

            $admin->notify(new Notifications(Auth::id(), "has requested for {$document->description}", route('admin.document-request.show', $document)));
            event(new NotificationEvent($admin->id, Auth::user()->resident->only('fname', 'lname'), "has requested for {$document->description}", route('admin.document-request.show', $document)));

            return response()->json(['success' => true, 'message' => 'Document request has been saved successfully.']);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to send document request. Please try again'.$e]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(DocumentRequest $documentRequest)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DocumentRequest $documentRequest)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, DocumentRequest $documentRequest)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentRequest $documentRequest)
    {
        //
    }
}
