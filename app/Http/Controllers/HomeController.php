<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use App\Models\Resident;
use App\Models\DocumentRequest;
use App\Enums\StatusEnum;

class HomeController extends Controller
{
    public function getData()
    {
        try{
            $residents = Resident::get();
            // Get Count by Document Requests per Day
            $reqs = DocumentRequest::where('created_at', '>=', Carbon::now()->subDays(13))->get()->groupBy(function($col) {
                // return ucfirst($col->status->value);
                return $col->created_at->format('M d');
            })->map(function($value, $key) {
                return $value->count();
            });
            
            // Assing value for each day
            $dateRange = CarbonPeriod::create(Carbon::now()->subDays(13), Carbon::now());
            foreach($dateRange as $key => $value) {
                $requests[$value->format("M d")] = $reqs[$value->format("M d")] ?? 0;
            }
            
            // Get Document Request Status Count
            $status = DocumentRequest::where(function($query) {
                // $query->where('status', '!=', StatusEnum::Declined)->orWhere('status', '!=', StatusEnum::Cancelled)->orWhere('status', '!=', StatusEnum::Completed);
                $query->where('status', StatusEnum::Pending)->orWhere('status', StatusEnum::Approved)->orWhere('status', StatusEnum::Ready);
            })->get()->groupBy(function($col) {
                return ucfirst($col->status->value);
            })->map(function($value, $key) {
                return $value->count();
            });

            // Get Total Residents
            $totalResidets = $residents->count();

            // Get Total Count by 4Ps members
            $fourps = $residents->groupBy(function($col) {
                return $col->fourps_member ? 'Yes' : 'No';
            })->map(function($value) {
                return $value->count();
            });

            // Get Total Count by Fully Vaccinated
            $fullyVaxxed = $residents->groupBy(function($col) {
                return $col->fully_vaxxed ? 'Yes' : 'No';
            })->map(function($value) {
                return $value->count();
            });

            // Get Total Count by Registered Voters
            $voter = $residents->groupBy(function($col) {
                return $col->voter ? 'Yes' : 'No';
            })->map(function($value) {
                return $value->count();
            });

            // Get Total Count by Gender
            $gender = $residents->groupBy(function($col) {
                return ucfirst($col->gender);
            })->map(function($value) {
                return $value->count();
            });
            
            return response()->json(['success' => true, 'requests' => $requests, 'status' => $status, 'fourps' => $fourps, 'fullyVaxxed' => $fullyVaxxed, 'voter' => $voter, 'gender' => $gender]);
        }
        catch(\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Failed to retrieve statistics. Please try again']);
        }
    }

    public function resident()
    {
        return view('resident.index');
    }

    public function admin()
    {
        return view('admin.index');
    }

}
