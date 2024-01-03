<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Str;
// use App\Notifications\Notifications;
// use App\Events\NotificationEvent;
use App\Models\DocumentRequest;
use App\Models\Document;
use App\Enums\StatusEnum;

use Validator;

class RequestStatusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $documents = Document::all();

        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where('document_requests.user_id', Auth::id())
            ->where(function($query) {
                $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
            })
            ->latest('document_requests.updated_at')
            ->get();
        return view('resident.my-requests.index')->with(['requests' => $requests, 'documents' => $documents]);
    }

    // public function requests()
    // {
    //     $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')
    //         ->join('residents', 'residents.user_id', 'users.id')
    //         ->join('documents', 'document_requests.document_id', 'documents.id')
    //         ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
    //         ->where('document_requests.user_id', Auth::id())
    //         ->where(function($query) {
    //             $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
    //         })
    //         ->latest('document_requests.updated_at')
    //         ->get();

    //     $view = view('admin.requests.requests')->with(['requests' => $requests])->render();
    //     return $view;
    // }

    public function search(Request $request)
    {
        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')
            ->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where('document_requests.user_id', Auth::id())
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
        
            
        $view = view('resident.my-requests.requests')->with(['requests' => $requests])->render();return response()->json(['success' => true, 'view' => $view, 'key' => $request->search]);
    }

    public function preview(DocumentRequest $documentRequest) {
        if(!Auth::user()->admin) {
            if(!Auth::user()->admin) {
                $documentRequest = $documentRequest->load('document');
                $view = view('resident.my-requests.preview')->with('request', $documentRequest)->render();
    
                return response()->json(['success' => true, 'view' => $view]);
            }
        }
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
        $documentRequest = $documentRequest->load('document');
        return $view = view('resident.my-requests.show')->with(['request' => $documentRequest]);
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
