<?php

namespace App\Http\Controllers;

use App\Models\DocumentRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Notifications\Notifications;
use App\Events\NotificationEvent;
use App\Models\Document;
use App\Enums\StatusEnum;

use Validator;

class ManageRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $documents = Document::all();

        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')
            ->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where(function($query) {
                $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
            })
            ->latest('document_requests.updated_at')
            ->get();

        return view('admin.requests.index')->with(['requests' => $requests, 'documents' => $documents]);
    }

    public function requests()
    {
        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')
            ->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where(function($query) {
                $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
            })
            ->latest('document_requests.updated_at')
            ->get();

        $view = view('admin.requests.requests')->with(['requests' => $requests])->render();
        return $view;
    }

    public function search(Request $request)
    {
        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where(function($query) use($request) {
                if(isset($request->document_filter)) {
                    $query->where('documents.description', $request->document_filter);
                }
            })
            ->where(function($query) use($request) {
                if(isset($request->status_filter)) {
                    $query->where('status', $request->status_filter);
                }
                else {
                    $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
                }
            })
            ->where(function($query) use($request) {
                if(isset($request->search)) {
                    $query->where('residents.lname', 'like', "%{$request->search}%")->orWhere('residents.fname', 'like', "%{$request->search}%")->orWhere('residents.mname', 'like', "%{$request->search}%")->orWhere('residents.household_no', 'like', "%{$request->search}%")->orWhere('residents.zone', 'like', "%{$request->search}%");
                }            
            })
            ->latest('document_requests.updated_at')
            ->get();

        $view = view('admin.requests.requests')->with(['requests' => $requests])->render();
        return response()->json(['success' => true, 'view' => $view, 'key' => $request->search]);
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
    public function show(DocumentRequest $documentRequest)
    {
        $documentRequest = $documentRequest->load(['document', 'user']);
        return $view = view('admin.requests.show')->with(['request' => $documentRequest]);
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
        try {
            if($documentRequest->status === StatusEnum::Approved) {
                $documentRequest->cert_id = Str::random(16);
            }
            $documentRequest->status = StatusEnum::from($request->status);
            $documentRequest->save();

            // Set Link
            if($documentRequest->status === StatusEnum::Declined || $documentRequest->status === StatusEnum::Cancelled) {
                $link = route('resident.history.show', $documentRequest);
            }
            else {
                $link = route('resident.my-request.show', $documentRequest);
            }

            // Notify User
            $documentRequest->user->notify(new Notifications(Auth::id(), "has updated your request for {$documentRequest->document->description} as {$documentRequest->status->value}", $link));

            event(new NotificationEvent($documentRequest->user->id, Auth::user()->only('username'), "has updated your request for {$documentRequest->document->description} as {$documentRequest->status->value}", $link));

            return response()->json(['success' => true, 'message' => 'Document Request has been updated successfully.', 'view' => $this->requests()]);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => "Failed to update document request. Please try again."]);
        }
    }

    public function markAsCompleted(Request $request)
    {
        $validator = Validator::make($request->input(), [
            'cert_id' => ['required', 'string', 'exists:document_requests,cert_id'],
        ]);

        if($validator->fails()) {
            return response()->json(['success' => false, 'message' => 'No request associated with the provided cert id. Please try again with a valid one.']);
        }

        try {
            // Get Document
            $document = DocumentRequest::where(function($query) use($request) {
                $query->where('cert_id', $request->cert_id);
            })->first();

            // Return error if code is already used
            if($document->status !== StatusEnum::Ready) {
                return response()->json(['success' => false, 'message' => "The document bearing this code has already been used and no longer valid."]);
            }

            // Update Record Otherwise
            $document->status = StatusEnum::Completed;
            $document->save();

            // Notify User
            $document->user->notify(new Notifications(Auth::id(), "has updated your request for {$document->document->description} as {$document->status->value}", route('resident.history.show', $document)));
            event(new NotificationEvent($document->user->id, Auth::user()->only('username'), "has updated your request for {$document->document->description} as {$document->status->value}", route('resident.history.show', $document)));

            return response()->json(['success' => true, 'message' => 'Document Request has been updated successfully.', 'view' => $this->requests()]);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => "Failed to update document request. Please try again.".$e]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DocumentRequest $documentRequest)
    {
        //
    }
}
