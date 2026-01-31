<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\job_role;
use App\Models\department;
use DateTime,Auth;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class JobRoleController extends Controller
{
    public function uploadJobRoles()
{
    $mapping = [
        'OFFICE AUTOMATION' => 12,
        'ACCOUNTING' => 5,
        'MULTIMEDIA' => 9,
        'CAD' => 11,
        'HARDWARE & NETWORKING' => 10,
        'SOFTWARE' => 6,
    ];

    $data = [
        ['OFFICE AUTOMATION', 'OFFICE STAFF'],
        ['OFFICE AUTOMATION', 'DATA ENTRY OPERATOR'],
        ['OFFICE AUTOMATION', 'ADMINISTRATOR'],
        ['OFFICE AUTOMATION', 'TELECALLER'],
        ['OFFICE AUTOMATION', 'SALE & MARKETING'],
        
        ['ACCOUNTING', 'ACCOUNTANT'],
        ['ACCOUNTING', 'BILLING STAFF'],
        ['ACCOUNTING', 'OFFICE STAFF'],
        ['ACCOUNTING', 'DATA ENTRY OPERATOR'],
        ['ACCOUNTING', 'ADMINISTRATOR'],
        ['ACCOUNTING', 'TELECALLER'],
        ['ACCOUNTING', 'SALE & MARKETING'],
        ['ACCOUNTING', 'INTERNSHIP'],
        
        ['MULTIMEDIA', 'GRAPHIC DESIGNER'],
        ['MULTIMEDIA', 'EDITOR'],
        ['MULTIMEDIA', 'ANIMATOR'],
        ['MULTIMEDIA', 'WEB DESIGNER'],
        ['MULTIMEDIA', 'UI/UX DESIGNER'],
        ['MULTIMEDIA', 'MOTION GRAPHIC EXPERT'],
        ['MULTIMEDIA', 'DIGITAL MARKETER'],
        ['MULTIMEDIA', 'INTERNSHIP'],
        
        ['CAD', 'DRAFTSMAN'],
        ['CAD', 'INTERIOR DESIGNER'],
        
        ['HARDWARE & NETWORKING', 'HARDWARE TECHNICIAN'],
        ['HARDWARE & NETWORKING', 'NETWORK ENGINEER'],
        ['HARDWARE & NETWORKING', 'MOBILE TECHNICIAN'],
        ['HARDWARE & NETWORKING', 'CCTV TECHNICIAN'],
        ['HARDWARE & NETWORKING', 'CHIPLEVEL TECHNICIAN'],
        ['HARDWARE & NETWORKING', 'SYSTEM ADMINISTRATOR'],
        ['HARDWARE & NETWORKING', 'ETHICAL HACKER'],
        ['HARDWARE & NETWORKING', 'DESKTOP SUPPORT ENGINEER'],
        
        ['SOFTWARE', 'DATA ANALYST'],
        ['SOFTWARE', 'PYTHON DEVELOPER'],
        ['SOFTWARE', 'WEB DEVELOPER'],
        ['SOFTWARE', 'JAVA DEVELOPER'],
        ['SOFTWARE', 'PHP DEVELOPER'],
        ['SOFTWARE', 'FLUTTER DEVELOPER'],
        ['SOFTWARE', 'MERNSTACK DEVELOPER'],
        ['SOFTWARE', 'INTERNSHIP'],
    ];

    $insertData = [];
    $now = Carbon::now();

    foreach ($data as [$deptName, $jobRole]) {
        $insertData[] = [
            'dept_id' => $mapping[$deptName],
            'job_role' => $jobRole,
            'status' => 'Active',
            'created_by' => 1,
            'created_at' => $now,
            'updated_at' => $now
        ];
    }

    DB::table('job_roles')->insert($insertData);

    return response()->json(['success' => true, 'message' => 'Job roles uploaded successfully']);
}

    public function job_roles()
    {
        $job_roles = job_role::where('status','!=','Deleted')->get();
        //$departments = department::where('status','!=','Deleted')->get();
        $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $departments = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $departments = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
        return view('admin.job_roles.job_roles', compact('job_roles','departments'));
    }

public function add_job_role(Request $req)
    {
       
        $admin = Auth::guard('admin')->user();
        if(job_role::where('job_role',$req->job_role)->where('status','!=','Deleted')->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      job_role::create([

            'dept_id'=>$req->dept,
            'job_role'=>$req->job_role,
            'status'=>'Active',      
            'created_by' => $admin->id,
        ]);

        $data['success']='Success';
    }
        echo json_encode($data);
       
    }

    public function edit_job_role(Request $req)
    {

        if(job_role::where('job_role',$req->job_role)->where('status','!=','Deleted')->where('id','!=',$req->job_role_id)->exists()) 
       {
        $data['err']='Error';
       }
       else
       {

      job_role::where('id',$req->job_role_id)->update([

            'dept_id'=>$req->dept,
            'job_role'=>$req->job_role,
            'status'=>$req->status,      

        ]);

        $data['success']='Success';
        }
        echo json_encode($data);
       
    }

    public function delete_job_role(Request $req)
    {

      job_role::where('id',$req->job_role_id)->update([
          
          'status'=>'Deleted',
          
          ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    


}

