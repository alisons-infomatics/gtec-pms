<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\employer;
use App\Models\employer_contact;
use App\Models\interview;
use DateTime,Auth, DB ;
use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\EmployerEnquiryExport;


class EmployerEnquiryController extends Controller
{
    public function index(Request $request)
    {
        $query = Employer::whereNotIn('status', ['Active', 'Deleted'])
            ->with([
                'contacts',
                'latest_enquiry'
            ]);
    
       
        if ($request->has('filterStatus') && $request->filterStatus != '') {
            // $query->whereHas('latest_enquiry', function ($q) use ($request) {
                $query->where('status', $request->filterStatus);
            // });
        }
    
        if ($request->filled('from_date') && $request->filled('to_date')) {
            $from = $request->from_date;
            $to = $request->to_date;
    
            $query->whereHas('latest_enquiry', function ($q) use ($from, $to) {
                $q->whereBetween('follow_up_date', [$from, $to]);
            });
        }
        
        $employers = $query->get();
    
        if ($request->has('export')) {
            return Excel::download(new EmployerEnquiryExport($employers), 'employer_enquiry.xlsx');
        }

        
       
        return view("admin.employer_enquiry.list", compact('employers'));
    }

    
    public function add_employer_enquiry(Request $req)
    {
        
        $admin = Auth::guard('admin')->user();
        
        DB::table('employer_enquiry')->insert([
            'employer_id'    => $req->company,       
            'contact_person' => $req->name,
            'contact_number' => $req->mobile,
            'contact_date'   => $req->date,
            'follow_up_date' => $req->next_contact_date,
            'remarks'        => $req->remarks,
            'status'         => $req->status,
            'created_by'     => $admin->id,        
            'created_at'     => now(),
            'updated_at'     => now(),
        ]);
    
        return redirect()->back()->with('success', 'Enquiry saved successfully!');
            
    }
}