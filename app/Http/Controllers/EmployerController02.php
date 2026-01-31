<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\employer;
use App\Models\employer_contact;
use App\Models\interview;
use DateTime,Auth;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function employers(Request $request)
{
    $query = employer::where('status', '!=', 'Deleted');

    if ($request->filled('last_interview')) {
        $days = (int) $request->last_interview;
        $dateThreshold = date('Y-m-d', strtotime("-{$days} days"));

        $employerIds = interview::whereDate('interview_date', '>=', $dateThreshold)
            ->pluck('employer')  // adjust if the column is named employer_id
            ->unique();

        $query->whereIn('id', $employerIds);
    }

    $employers = $query->get();

    return view('admin.employers.employers', compact('employers'));
}


public function add_employer(Request $req)
    {
        $admin = Auth::guard('admin')->user();
      $employer=employer::create([

            'company_name'=>$req->cname,
            'email'=>$req->email,
            'address'=>$req->address,
            'status'=>'Active', 
            'created_by' => $admin->id,

        ]);

      $employer_contact=employer_contact::create([

            'employer_id'=>$employer->id,
            'contact_person'=>$req->name,
            'mobile_code'=>$req->mcode,
            'mobile'=>$req->mobile,
            'alternate_mobile_code'=>$req->mcodea,
            'alternate_mobile'=>$req->mobilea,
            'status'=>'Active',     

        ]);

      if($req->name1!='')
      {
        $employer_contact1=employer_contact::create([

            'employer_id'=>$employer->id,
            'contact_person'=>$req->name1,
            'mobile_code'=>$req->mcode1,
            'mobile'=>$req->mobile1,
            'alternate_mobile_code'=>$req->mcodea1,
            'alternate_mobile'=>$req->mobilea1,
            'status'=>'Active',     

        ]);

      }

        $data['success']='Success';
        echo json_encode($data);
       
    }

    public function edit_employer(Request $req)
    {
        $admin = Auth::guard('admin')->user();
      employer::where('id',$req->emp_id)->update([

            'company_name'=>$req->cname,
            'email'=>$req->email,
            'address'=>$req->address,
            'status'=>$req->status,      
            'created_by' => $admin->id,
        ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    public function delete_employer(Request $req)
    {

      employer::where('id',$req->emp_id)->update([

        'status'=>'Deleted',

      ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    
    public function employer_profile($eid)
    {
        $employer = employer::with('createdBy')->where('id',$eid)->first();
        $employer_contact = employer_contact::where('employer_id',$eid)->get();
        $interview = interview::where('student_id',$eid)->latest()->get();
        return view('admin.employers.employer_profile', compact('employer','employer_contact','interview'));
    }
    
   

    public function add_contact(Request $req)
    {
      
      $employer_contact=employer_contact::create([

            'employer_id'=>$req->emp_id,
            'contact_person'=>$req->pname,
            'mobile_code'=>$req->mcode,
            'mobile'=>$req->mobile,
            'alternate_mobile_code'=>$req->mcodea,
            'alternate_mobile'=>$req->mobilea,
            'status'=>'Active',     

        ]);
        $data['success']='Success';
        echo json_encode($data);
   
    }

    public function edit_contact(Request $req)
    {
      
      employer_contact::where('id',$req->contact_id)->update([

            'contact_person'=>$req->pname,
            'mobile_code'=>$req->mcode,
            'mobile'=>$req->mobile,
            'alternate_mobile_code'=>$req->mcodea,
            'alternate_mobile'=>$req->mobilea,    

        ]);
        $data['success']='Success';
        echo json_encode($data);
   
    }

    public function delete_contact(Request $req)
    {
      
      employer_contact::where('id',$req->contact_id)->delete();
        $data['success']='Success';
        echo json_encode($data);
   
    }
       
    


}

