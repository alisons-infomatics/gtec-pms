<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\student;
use App\Models\department;
use App\Models\course;
use App\Models\job_role_list;
use App\Models\job_role;
use App\Models\employer;
use App\Models\employer_contact;
use DateTime;
use Auth;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function add_job_role()
    {
        $dept = department::where('status','!=','Deleted')->get();
        $courses = course::where('status','!=','Deleted')->get();
        $job_roles = job_role::where('status','!=','Deleted')->get();
        // $employers = employer::where('status','!=','Deleted')->get();
        $employers = employer::where('status','=','Active')->get();
        return view('admin.job_roles_list.add_job_role', compact('dept','courses','job_roles','employers'));
    }
    // public function job_roles_list()
    // {
    //     $roles = job_role_list::where('status','Open')->get();
    //     return view('admin.job_roles_list.job_roles_list', compact('roles'));
    // }
    
    public function job_roles_list(Request $request)
{
    $roles = job_role_list::where('status', 'Open');

    // CSV filters
    foreach (['departments' => 'department', 'genders' => 'gender', 'qualifications' => 'qualification', 'experiences' => 'experience'] as $input => $column) {
        if ($request->filled($input)) {
            $roles->where(function ($q) use ($request, $input, $column) {
                foreach ($request->$input as $val) {
                    $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]);
                }
            });
        }
    }

    // Text/ID filter
    if ($request->filled('job_roles')) {
        $roles->where(function ($q) use ($request) {
            foreach ($request->job_roles as $val) {
                $q->orWhere('id', $val)->orWhere('title', 'LIKE', "%$val%");
            }
        });
    }

    // Employer filter
    if ($request->filled('employers')) {
        $roles->whereIn('company_id', $request->employers);
    }
    
    if ($request->filled('created_from')) {
        $roles->whereDate('created_at', '>=', $request->created_from);
    }

    if ($request->filled('created_to')) {
        $roles->whereDate('created_at', '<=', $request->created_to);
    }

    $roles = $roles->get();
    $depts = department::where('status', 'Active')->get();
    $employers = employer::where('status', 'Active')->get();
    $job_roles = job_role_list::where('status', 'Open')->get();

    return view('admin.job_roles_list.job_roles_list', compact('roles', 'depts', 'employers', 'job_roles'));
}


    // public function closed_job_roles_list()
    // {
    //     $roles = job_role_list::where('status','Closed')->get();
    //     return view('admin.job_roles_list.closed_job_roles_list', compact('roles'));
    // }
    
    public function closed_job_roles_list(Request $request)
{
    $roles = job_role_list::where('status', 'Closed');

    foreach (['departments' => 'department', 'genders' => 'gender', 'qualifications' => 'qualification', 'experiences' => 'experience'] as $input => $column) {
        if ($request->filled($input)) {
            $roles->where(function ($q) use ($request, $input, $column) {
                foreach ($request->$input as $val) {
                    $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]);
                }
            });
        }
    }

    if ($request->filled('job_roles')) {
        $roles->where(function ($q) use ($request) {
            foreach ($request->job_roles as $val) {
                $q->orWhere('id', $val)->orWhere('title', 'LIKE', "%$val%");
            }
        });
    }

    if ($request->filled('employers')) {
        $roles->whereIn('company_id', $request->employers);
    }
    
    if ($request->filled('created_from')) {
        $roles->whereDate('created_at', '>=', $request->created_from);
    }

    if ($request->filled('created_to')) {
        $roles->whereDate('created_at', '<=', $request->created_to);
    }

    $roles = $roles->get();
    $depts = department::where('status', 'Active')->get();
    $employers = employer::where('status', 'Active')->get();
     $job_roles = job_role_list::where('status', 'Open')->get();

    return view('admin.job_roles_list.closed_job_roles_list', compact('roles', 'depts', 'employers', 'job_roles'));
}

    
    
    public function job_add(Request $req)
{
     $admin = Auth::guard('admin')->user();
     
    $titles = $req->input('title', []);
    $cpersons = $req->input('cperson', []);
    $mcodes = $req->input('mcode', []);
    $mobiles = $req->input('mobile', []);
    $genders = $req->input('gender', []);
    $vaccancies = $req->input('vaccancy', []);
    $remarks = $req->input('remarks', []);
    $qualis = $req->input('quali', []);
    $exps = $req->input('jexp', []);
    $depts = $req->input('jdept', []);
    $job_roles = $req->input('job_roles', []);

    $total_roles = count($titles);

    if ($total_roles > 0) {
        for ($i = 0; $i < $total_roles; $i++) {

            // 🎯 IMPORTANT: Skip if title empty
            if (empty($titles[$i])) {
                continue;
            }

            job_role_list::create([
                'company_id'     => $req->company,
                'email'          => $req->email,
                'location'       => $req->loc,
                'contact_code'   => $mcodes[$i] ?? null,
                'contact_num'    => $mobiles[$i] ?? null,
                'title'          => $titles[$i],
                'contact_person' => $cpersons[$i] ?? null,
                'gender'         => $genders[$i] ?? null,
                'qualification'  => isset($qualis[$i]) ? implode(',', json_decode($qualis[$i], true)) : null,
                'experience'     => isset($exps[$i]) ? implode(',', json_decode($exps[$i], true)) : null,
                'department'     => isset($depts[$i]) ? implode(',', json_decode($depts[$i], true)) : null,
                'job_role'       => isset($job_roles[$i]) ? implode(',', json_decode($job_roles[$i], true)) : null,
                'vacancy'        => $vaccancies[$i] ?? null,
                'remarks'        => $remarks[$i] ?? null,
                'status'         => 'Open',
                'created_by' => $admin->id,
            ]);
        }
        return response()->json(['success' => true]);
    }
    else{
        return response()->json(['success' => false, 'message' => 'No job roles to add.']);
    }

    
}




    
    public function edit_job($jid)
    {
        $dept = department::where('status','!=','Deleted')->get();
        $job_roles = job_role::where('status','!=','Deleted')->get();
        $job = job_role_list::where('id',$jid)->first();
        //$selectedDeptId = $job->department;
        $selectedDepartments = explode(',', $job->department); // Example: "1,3" → [1,3]
        $selectedJobRoles = explode(',', $job->job_role); 
        $employers = employer::where('status','!=','Deleted')->get();
        return view('admin.job_roles_list.edit_job_role', compact('dept','employers','job_roles','job','selectedDepartments','selectedJobRoles'));
    }

    public function job_edit(Request $req)
    {
        
      job_role_list::where('id',$req->job_id)->update([

            'company_id'=>$req->company,
            'email'=>$req->email,
            'location'=>$req->loc,
            'contact_code'=>$req->mcode,
            'contact_num'=>$req->mobile,
            'title'=>$req->title,
            'contact_person'=>$req->cperson,
            'gender'=>$req->gender,
            'qualification'=>$req->quali,
            'experience'=>$req->jexp,
            'department'=>$req->jdept,
            'job_role'=>$req->job_roles,
            'vacancy'=>$req->vaccancy,
            'remarks'=>$req->remarks,
            'status'=>$req->status,     
        ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }
    public function delete_student(Request $req)
    {

      student::where('id',$req->user_id)->update([

        'status'=>'Deleted',

      ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    public function getCoursesAndRoles(Request $request)
{
    $deptId = $request->dept_id;
    $courses = course::where('dept_id', $deptId)->get();
    $job_roles = job_role::where('dept_id', $deptId)->get();

    return response()->json([
        'courses' => $courses,
        'job_roles' => $job_roles,
    ]);
}

    public function getEmployerContacts(Request $request)
{
    $contacts = employer_contact::where('employer_id', $request->employer_id)
                ->get(['id', 'contact_person', 'mobile', 'mobile_code']);

    return response()->json($contacts);
}



}

