<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\employer;
use App\Models\employer_contact;
use App\Models\interview;
use DateTime,Auth, DB;
use Illuminate\Http\Request;

class EmployerController extends Controller
{
    public function employers(Request $request)
{
    $query = employer::where('status', '=', 'Active');

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


    // public function add_employer(Request $req)
    // {
    //     $exists = employer_contact::
    //             where(function ($query) use ($req) {
    //                 $mobiles = [
    //                     $req->mobile,
    //                     $req->mobile1,
    //                     $req->mobilea,
    //                     $req->mobilea1
    //                 ];
            
    //                 foreach ($mobiles as $mob) {
    //                     if ($mob) {
    //                         $query->orWhere('mobile', $mob)
    //                               ->orWhere('alternate_mobile', $mob);
    //                     }
    //                 }
    //             })
    //             ->exists();
            
    //         if ($exists) {
    //             return response()->json([
    //                 'err' => true,
    //                 'message' => 'One of the mobile numbers already exists for this employer!'
    //             ]);
    //         }
            
    //     $email = employer::where('email', $req->email)->exists();
        
    //     if($email){
    //         return response()->json([
    //             'err' => true,
    //             'message' => 'Email already exists!'
    //         ]);
    //     }
        
    //     $admin = Auth::guard('admin')->user();
    //   $employer=employer::create([

    //         'company_name'=>$req->cname,
    //         'email'=>$req->email,
    //         'address'=>$req->address,
    //         'status'=> $req->status ?? 'Active', 
    //         'created_by' => $admin->id,

    //     ]);

    //   $employer_contact=employer_contact::create([

    //         'employer_id'=>$employer->id,
    //         'contact_person'=>$req->name,
    //         'mobile_code'=>$req->mcode,
    //         'mobile'=>$req->mobile,
    //         'alternate_mobile_code'=>$req->mcodea,
    //         'alternate_mobile'=>$req->mobilea,
    //         'status'=>'Active',     

    //     ]);

    //   if($req->name1!='')
    //   {
    //     $employer_contact1=employer_contact::create([

    //         'employer_id'=>$employer->id,
    //         'contact_person'=>$req->name1,
    //         'mobile_code'=>$req->mcode1,
    //         'mobile'=>$req->mobile1,
    //         'alternate_mobile_code'=>$req->mcodea1,
    //         'alternate_mobile'=>$req->mobilea1,
    //         'status'=>'Active',     

    //     ]);

    //   }

    //     $data['success']='Success';
    //     echo json_encode($data);
       
    // }
    
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
        $enquiries = DB::table('employer_enquiry')->where('employer_id',$eid)
                    ->join('employers', 'employer_enquiry.employer_id', '=', 'employers.id')
                    ->join('admin_details', 'employer_enquiry.created_by', '=', 'admin_details.id')
                    ->select(
                        'employer_enquiry.*',
                        'employers.company_name as employer_name',
                        'admin_details.name as created_by_name'
                    )
                    ->orderBy('employer_enquiry.created_at', 'desc')
                    ->get();
        $employer = employer::with('createdBy')->where('id',$eid)->first();
        $employer_contact = employer_contact::where('employer_id',$eid)->get();
        $interview = interview::where('employer',$eid)->get();
        return view('admin.employers.employer_profile', compact('employer','employer_contact','interview','enquiries'));
    }
    
   

    public function add_contact(Request $req)
    {
        
        $exists = employer_contact::
            where(function ($query) use ($req) {
                $query->where('mobile', $req->mobile)
                      ->orWhere('alternate_mobile', $req->mobile)
                      ->orWhere('mobile', $req->mobilea)
                      ->orWhere('alternate_mobile', $req->mobilea);
            })
            ->exists();
    
        if ($exists) {
            return response()->json([
                'err' => true,
                'message' => 'Contact number already exists!'
            ]);
        }
    
        
        employer_contact::create([
            'employer_id'          => $req->emp_id,
            'contact_person'       => $req->pname,
            'mobile_code'          => $req->mcode,
            'mobile'               => $req->mobile,
            'alternate_mobile_code'=> $req->mcodea,
            'alternate_mobile'     => $req->mobilea,
            'status'               => 'Active',
        ]);
    
        return response()->json([
            'success' => true,
            'message' => 'Contact added successfully.'
        ]);
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

