<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\admin_detail;
use App\Models\student;
use App\Models\interview;
use App\Models\department;	
use App\Models\employer;
use App\Models\course;
use App\Models\job_role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use DB;
use Illuminate\Support\Str;
use Mail;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{

    public function sign_in(){

        return view('admin.authentication.sign-in');
    }

    public function reset_password()
    {
        return view('admin.authentication.forgot_password');
       // print_r(bcrypt("admin"));
    }

     public function admin_mail_chk(Request $req)
    {
   
      $email=$req->email;      
      $cnt=admin_detail::where('mail_id',$email)->count();
      if($cnt==0)
      {
        $data['err']='Invalid Mail Id';
      }
       else
      {
        $token=Str::random(64);

        $pswcnt=DB::table('password_resets')->where('email',$email)->count();
        if($pswcnt==0)
        {

             DB::table('password_resets')->insert([

            'email'=>$email,
            'token'=>$token,
            'created_at'=>date('Y-m-d H:i:s'),

            ]);
        }
        else
        {
            DB::table('password_resets')->where('email',$email)->update([

            'token'=>$token,
            'created_at'=>date('Y-m-d H:i:s'),

            ]); 
        }

        $details=[
            'email'=>$email,
            'token'=>$token
        ];

        Mail::to($email)->send(new ForgotPasswordMail($details));
        $data['success']='An email has been successfully sent to change your password';
        
      }
      

        echo json_encode($data);
    }


    public function admin_password_reset($tok,$em)
    {
        $cnt=DB::table('password_resets')->where('email',$em)->where('token',$tok)->count();
        if($cnt==0)
        {
            return view('admin.authentication.AdminResetPasswordExpired');
        }
        else
        {
        return view('admin.authentication.AdminResetPassword',['token'=>$tok,'email'=>$em]);
         }
       // print_r(bcrypt("admin"));
    }

    public function adminpsw_reset(Request $req)
    {
        //$currentpass=auth()->guard('admin')->user()->password;
       // $oldpass=$req->oldpass;
        $newpass=$req->newpass;

        // if(Hash::check($oldpass, $currentpass))
        // {
            admin_detail::where('mail_id',$req->email)->update([
                'password'=>bcrypt($newpass)
            ]) ;

             DB::table('password_resets')->where('email',$req->email)->delete();

            $data['success']="success";
        // }
        // else{
        //     $data['err']="err";
        // }
        echo json_encode($data);
       
    }


     private function generateRandomString($length = 3)
     {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $randomString;
    }


    public function do_sign_in(Request $req)
    {
        $rememberStatus=$req->rememberStatus;
        $username=$req->username;
        $password=$req->password;
        if($rememberStatus==0)
        {
            if((Auth::guard('admin')->attempt(['username' => $username, 'password' => $password])))
                {
                    if(auth()->guard('admin')->user()->status=='Pending')
                    {
                       $data['err']='Approval pending...'; 
                    }
                    else if(auth()->guard('admin')->user()->status=='Rejected')
                    {
                       $data['err']='Account rejected...'; 
                    }
                    else if(auth()->guard('admin')->user()->status=='Blocked')
                    {
                       $data['err']='Account blocked...'; 
                    }
                    else
                    {
                       $data['success']='Login success.Please wait...'; 
                    }

                    
                }
            else
                {
                    $data['err']='Invalid user !';
                }
        }
        else if($rememberStatus==1)
        {
            if((Auth::guard('admin')->attempt(['username' => $req->username, 'password' => $req->password],true)))
                {
                    if(auth()->guard('admin')->user()->status=='Pending')
                    {
                       $data['err']='Approval pending...'; 
                    }
                    else if(auth()->guard('admin')->user()->status=='Rejected')
                    {
                       $data['err']='Account rejected...'; 
                    }
                    else if(auth()->guard('admin')->user()->status=='Blocked')
                    {
                       $data['err']='Account blocked...'; 
                    }
                    else
                    {
                       $data['success']='Login success.Please wait...'; 
                    }
                }
            else
                {
                    $data['err']='Invalid user !';
                }

        }

        return response()->json($data);


    }


    public function getCounsilerDepartments($counsilerId)
    {
        
        $user = admin_detail::find($counsilerId);
    
        if (!$user || !$user->department) {
            return response()->json([]);
        }
    
        $deptIds = explode(',', $user->department);
        $departments = Department::whereIn('id', $deptIds)->get(['id', 'department']);
    
        return response()->json($departments);
    }
    
    public function counsilerReport(Request $request)
    {
        //dd($request->all());
        // === Full data (all time) ===
        if($request->counsilers != 'All'){
        $std = student::whereNotIn('status', ['Deleted', 'Pending'])->where('approved_by',$request->counsilers)->get();
        //$dept = department::whereNotIn('status', ['Deleted', 'Pending'])->get();
       //dd($std);
        }else{
            $std = student::whereNotIn('status', ['Deleted', 'Pending'])->get();
        }
        $admin = Auth::guard('admin')->user();
    
        if ($admin->id == 1) {
            // Super admin sees all active (non-deleted/pending) departments
            $dept = department::whereNotIn('status', ['Deleted', 'Pending'])->get();
        } else {
            // Other users see only their assigned departments
            $deptIds = explode(',', $admin->department);
        
            $dept = department::whereIn('id', $deptIds)
                              ->whereNotIn('status', ['Deleted', 'Pending'])
                              ->get();
        }
    
    
        $fullLiveCount = $std->where('status', 'Live')->whereNotNull('approve_date')->count();
        $fullPlacedCount = $std->where('status', 'Placed')->count();
        $fullLivePlacedPercentage = ($fullLiveCount > 0) ? ($fullPlacedCount / $fullLiveCount) * 100 : 0;
    
        // === Filtered data (date wise) ===
        if($request->counsilers == 'All'){
            $query = student::whereNotIn('status', ['Deleted', 'Pending'])->whereNotNull('approve_date');
        }else{
        $query = student::whereNotIn('status', ['Deleted', 'Pending'])->whereNotNull('approve_date')->where('approved_by',$request->counsilers);
        }
        if ($request->start_date && $request->end_date) {
            $sdt = $request->start_date;
            $edt = $request->end_date;
            $query->whereBetween('approve_date', [$sdt, $edt]);
        } else {
            $sdt = date('Y-m-01');
            $edt = date('Y-m-t');
            $query->whereBetween('approve_date', [$sdt, $edt]);
        }
        if ($request->departments && $request->departments != 'All') {
            $query->where('dept', $request->departments);
            $cdept=$request->dept;
        }
        else{
            $cdept='All';
    
        }
        
        if($request->counsilers == 'All'){
            $interviewsCount = interview::get()->count();
            $empCount = employer::get()->count();
        }else{
            $interviewsCount = interview::where('created_by',$request->counsilers)->count();
            $empCount = employer::where('created_by',$request->counsilers)->count();
        }
        $filteredStd = $query->get();
    
    //dd($filteredStd,$request->all());
        $filteredLiveCount = $filteredStd->where('status', 'Live')->whereNotNull('approve_date')->count();
        $filteredPlacedCount = $filteredStd->where('status', 'Placed')->count();
        $filteredLivePlacedPercentage = ($filteredLiveCount > 0) ? ($filteredPlacedCount / $filteredLiveCount) * 100 : 0;
        $admin = Auth::guard('admin')->user();
        
        if($admin->id == 1){
            $counsilers = admin_detail::where('user_type', '!=', 1)
            ->where('status', 'active') 
            ->get();
            $deptIds = explode(',', $admin->department);
            $departments = department::whereIn('id', $deptIds)
                          ->whereNotIn('status', ['Deleted', 'Pending'])
                          ->get();
                          
        }else{ 
            $counsilers = ' '; 
            $departments = ' ';
        }
        
    
        // === Send to Blade ===
        $html = view('admin.counsilar_report', compact(
            'std',
            'filteredStd',
            'fullLivePlacedPercentage',
            'filteredLivePlacedPercentage',
            'sdt',
            'edt',
            'dept',
            'cdept',
            'counsilers',
            'departments',
            'interviewsCount',
            'empCount'
        ))->render();
        return response($html);
    }
    
    public function dashboard(Request $request)
    {
    
        // === Full data (all time) ===
        $std = student::whereNotIn('status', ['Deleted', 'Pending'])->get();
        //$dept = department::whereNotIn('status', ['Deleted', 'Pending'])->get();
       
        $admin = Auth::guard('admin')->user();
    
        if ($admin->id == 1) {
            // Super admin sees all active (non-deleted/pending) departments
            $dept = department::whereNotIn('status', ['Deleted', 'Pending'])->get();
        } else {
            // Other users see only their assigned departments
            $deptIds = explode(',', $admin->department);
        
            $dept = department::whereIn('id', $deptIds)
                              ->whereNotIn('status', ['Deleted', 'Pending'])
                              ->get();
        }
    
    
        $fullLiveCount = $std->where('status', 'Live')->whereNotNull('approve_date')->count();
        $fullPlacedCount = $std->where('status', 'Placed')->count();
        $fullLivePlacedPercentage = ($fullLiveCount > 0) ? ($fullPlacedCount / $fullLiveCount) * 100 : 0;
    
        // === Filtered data (date wise) ===
        $query = student::whereNotIn('status', ['Deleted', 'Pending']);
    
        if ($request->start_date && $request->end_date) {
            $sdt = $request->start_date;
            $edt = $request->end_date;
            $query->whereBetween('approve_date', [$sdt, $edt]);
        } else {
            $sdt = date('Y-m-01');
            $edt = date('Y-m-t');
            $query->whereBetween('approve_date', [$sdt, $edt]);
        }
        if ($request->dept && $request->dept != 'All') {
            $query->where('dept', $request->dept);
            $cdept=$request->dept;
        }
        else{
            $cdept='All';
    
        }
    
        $filteredStd = $query->get();
    
        $filteredLiveCount = $filteredStd->where('status', 'Live')->whereNotNull('approve_date')->count();
        $filteredPlacedCount = $filteredStd->where('status', 'Placed')->count();
        $filteredLivePlacedPercentage = ($filteredLiveCount > 0) ? ($filteredPlacedCount / $filteredLiveCount) * 100 : 0;
        $admin = Auth::guard('admin')->user();
        
        if($admin->id == 1){
            $counsilers = admin_detail::where('user_type', '!=', 1)
            ->where('status', 'active') 
            ->get();
            $deptIds = explode(',', $admin->department);
            $departments = department::whereIn('id', $deptIds)
                          ->whereNotIn('status', ['Deleted', 'Pending'])
                          ->get();
                          
        }else{ 
            $counsilers = ' '; 
            $departments = ' ';
        }
        
    
        // === Send to Blade ===
        return view('admin.dashboard', compact(
            'std',
            'filteredStd',
            'fullLivePlacedPercentage',
            'filteredLivePlacedPercentage',
            'sdt',
            'edt',
            'dept',
            'cdept',
            'counsilers',
            'departments'
        ));
    }



    public function admin_profile()
    {
        $adid = Auth::guard('admin')->user()->id;
        $adm = admin_detail::where('id', $adid)->first();
        return view('admin.admin_profile', ['adm' => $adm]);
    }

    public function admin_profile_update(Request $req)
    {
    
    
        $adid = Auth::guard('admin')->user()->id;
        if(admin_detail::where('username',$req->username)->where('id','!=',$adid)->exists())
        {
            $data['err']="err";
        }
        else if(admin_detail::where('mail_id',$req->mail_id)->where('id','!=',$adid)->exists())
        {
            $data['err1']="err1";
        }
        else if(admin_detail::where('mobile',$req->mobile)->where('id','!=',$adid)->exists())
        {
            $data['err2']="err2";
        }
        else
        {
        $adm = admin_detail::where('id', $adid)->first();
    
        $img = $req->file('profile_image');
        if ($img == '') {
            $new_name = $adm->profile_image;
        } else {
            //$imgWillDelete = public_path() . '/uploads/admins/' . $adm->profile_image;
            //File::delete($imgWillDelete);
    
            $new_name = "uploads/admins/" . time() . '.' . $img->getClientOriginalExtension();
            $img->move(public_path('uploads/admins'), $new_name);
        }
    
        admin_detail::where('id', $adid)->update([
            'name' => $req->name,
            'username' => $req->username,
            'mobile' => $req->mobile,
            'mail_id' => $req->mail_id,
            'profile_image' => $new_name,
        ]);
    
        $data['success'] = "success";
    }
        echo json_encode($data);
    }


    public function change_password()
    {
        return view('admin.changepass');
    }


    public function password_update(Request $req)
    {
        $adid = Auth::guard('admin')->user()->id;
        $currentpass = auth()->guard('admin')->user()->password;
        $current_password = $req->current_password;
        $new_password = $req->new_password;
        $confirm_password = $req->confirm_password;
    
        $data = [];
    
        if (Hash::check($current_password, $currentpass)) {
            if ($new_password === $confirm_password) {
                admin_detail::where('id', $adid)->update([
                    'password' => bcrypt($new_password)
                ]);
                $data['success'] = "success";
            } else {
                $data['err'] = "Password are not matching";
            }
        } else {
            $data['err'] = "Current password is incorrect";
        }
    
        echo json_encode($data);
    }


    public function logout()
    {
        Auth::guard('admin')->logout();
        return redirect()->route('sign_in');
    }


    //////////////////////////////


    public function register(){

        $dept = department::where('status','!=','Deleted')->get();
        $courses = course::where('status','!=','Deleted')->get();
        $job_roles = job_role::where('status','!=','Deleted')->get();
        return view('registration.index',compact('dept','courses','job_roles'));
    }

    public function student_register(Request $req)
    {
        //dd($req->all());
        $admin = Auth::guard('admin')->user();
        
        $photo = $req->file('photo');
            if ($photo == '') {
                $new_name = "";
            } else {
                $image = $req->file('photo');
                $new_name = "uploads/students/" . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/students'), $new_name);
            }
        
      student::create([

            'first_name'=>$req->fname,
            'middle_name'=>$req->mname,
            'last_name'=>$req->lname,
            'mobile_code'=>$req->mcode,
            'mobile'=>$req->mobile,
            'alternate_mobile_code'=>$req->mcode1,
            'alternate_mobile'=>$req->mobile1,
            'reg_num'=>$req->regnum,
            'gender'=>$req->gender,
            'address'=>$req->address,
            'place'=>$req->place,
            'dob'=>$req->dob,
            'age'=>$req->age,
            'marital_status'=>$req->marital_status,
            'email'=>$req->email ?? null,
            'qualification'=>$req->quali,
            'qualification_course'=>$req->course,
            'dept'=>$req->dept,
            //'course'=>$req->crs,implode(',', $req->input('job_roles'))
            'course'=>implode(',', $req->input('crs')),
            'experience'=>$req->exp,
            'experience_in'=>$req->experience_area,
            'remarks'=>$req->experience_remarks,
            // 'job_role'=>$req->job_roles,
            'job_role'=>implode(',', $req->input('job_roles')),
            'photo'=>$new_name,
            'status'=>'Pending', 
            'approve_date'=> date('Y-m-d'),
            'approved_by' => $admin->id ?? NULL,
            

        ]);

        // $data['success']='Success';
        // echo json_encode($data);
        return redirect()->back()->with('success', 'Registration completed successfully!');
       
    }



}
