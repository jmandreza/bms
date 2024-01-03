<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Document;
use App\Models\DocumentRequest;
use App\Enums\StatusEnum;

class HistoryController extends Controller
{
    public function index()
    {
        $prefix = Auth::user()->admin ? 'admin' : 'resident';
        $documents = Document::all();
        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')
            ->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where(function($query) {
                if(!Auth::user()->admin) {
                    $query->where('document_requests.user_id', Auth::id());
                }
            })
            ->where(function($query) {
                $query->where('status', StatusEnum::Declined)->orWhere('status', StatusEnum::Completed);
            })
            ->latest('document_requests.updated_at')
            ->get();

            return view($prefix.'.history.index')->with(['requests' => $requests, 'documents' => $documents]);
    }

    public function requestHistory()
    {

    }

    public function search(Request $request)
    {
        $prefix = Auth::user()->admin ? 'admin' : 'resident';
        $requests = DocumentRequest::join('users', 'document_requests.user_id', 'users.id')->join('residents', 'residents.user_id', 'users.id')
            ->join('documents', 'document_requests.document_id', 'documents.id')
            ->select('document_requests.*', 'residents.lname', 'residents.fname', 'residents.mname', 'residents.household_no', 'residents.zone', 'documents.description')
            ->where(function($query) {
                if(!Auth::user()->admin) {
                    $query->where('document_requests.user_id', Auth::id());
                }
            })
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

        $view = view($prefix.'.history.history')->with(['requests' => $requests])->render();
        return response()->json(['success' => true, 'view' => $view, 'key' => $request->search]);
    }

    public function preview(DocumentRequest $request)
    {
        $prefix = Auth::user()->admin ? 'admin' : 'resident';
        $request = $request->load(['document', 'user']);

        $view = view($prefix.'.history.preview')->with(['request' => $request])->render();

        return response()->json(['success' => true, 'view' => $view]);
    }

    public function show(DocumentRequest $request)
    {
        $request = $request->load('document');

        return view('resident.history.show')->with(['request' => $request]);
    }
}
