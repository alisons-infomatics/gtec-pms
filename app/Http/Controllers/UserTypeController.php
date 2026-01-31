<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\user_type;
use App\Models\department;
use DateTime;
use Illuminate\Http\Request;


class UserTypeController extends Controller
{
    public function user_types()
    {
        $user_types = user_type::where('status','!=','Deleted')->get();
        return view('admin.user_types.user_types', compact('user_types'));
    }

public function add_user_type(Request $req)
    {
        if(user_type::where('user_type',$req->type)->where('status','!=','Deleted')->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      user_type::create([

            'user_type'=>$req->type,
            'status'=>'Active',      

        ]);

        $data['success']='Success';
        }
        echo json_encode($data);
       
    }

    public function edit_user_type(Request $req)
    {

        if(user_type::where('user_type',$req->type)->where('status','!=','Deleted')->where('id','!=',$req->type_id)->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      user_type::where('id',$req->type_id)->update([

            'user_type'=>$req->type,
            'status'=>$req->status,      

        ]);

        $data['success']='Success';
    }
        echo json_encode($data);
       
    }

    public function delete_user_type(Request $req)
    {

      user_type::where('id',$req->type_id)->delete();

        $data['success']='Success';
        echo json_encode($data);
       
    }


    ///////////////////////


    public function users()
    {
        $users = admin_detail::where('status','!=','Deleted')->get();
        $types = user_type::where('status','!=','Deleted')->get();
        $dept = department::where('status','!=','Deleted')->get();
        return view('admin.users.users', compact('users','types','dept'));
    }

public function add_user(Request $req)
    {
        if(admin_detail::where('username',$req->username)->where('status','!=','Deleted')->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      admin_detail::create([

            'name'=>$req->name,
            'username'=>$req->username,
            'password'=>bcrypt($req->password),
            'department'=>$req->dept,
            'user_type'=>$req->type,
            'status'=>'Active',      

        ]);

        $data['success']='Success';
        }
        echo json_encode($data);
       
    }

    public function edit_user(Request $req)
    {

        if(admin_detail::where('username',$req->username)->where('status','!=','Deleted')->where('id','!=',$req->user_id)->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
        if($req->password=='')
        {
            admin_detail::where('id',$req->user_id)->update([

            'name'=>$req->name,
            'username'=>$req->username,
            'department'=>$req->dept,
            'user_type'=>$req->type,
            'status'=>$req->status,       

        ]);

        }
        else
        {
              admin_detail::where('id',$req->user_id)->update([

                    'name'=>$req->name,
                    'username'=>$req->username,
                    'password'=>bcrypt($req->password),
                    'department'=>$req->dept,
                    'user_type'=>$req->type,
                    'status'=>$req->status,       

                ]);
      }

        $data['success']='Success';
    }
        echo json_encode($data);
       
    }

    public function delete_user(Request $req)
    {

      admin_detail::where('id',$req->user_id)->update([
          
          'status'=>'Deleted',
          
          ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    public function rules($uid)
    {
        $user_type = user_type::where('id',$uid)->first();
        return view('admin.user_types.rules', compact('user_type'));
    }

 
public function set_rules(Request $request)
{
    // Validation (optional but good practice)
    $request->validate([
        'rules' => 'required|array',
    ]);

    $userTypeId = $request->input('user_type_id');  // make sure you pass user_type_id hidden in form
    $rulesArray = $request->input('rules', []);

    // Convert to comma separated string
    $rulesString = implode(',', $rulesArray);

    // Save into database
    $userType = user_type::find($userTypeId);

    if ($userType) {
        $userType->rules = $rulesString;
        $userType->save();

        return redirect()->back()->with('success', 'Permissions saved successfully!');
    }

    return redirect()->back()->with('error', 'User Type not found!');
}


    


}

