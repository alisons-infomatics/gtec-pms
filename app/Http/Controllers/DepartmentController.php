<?php

namespace App\Http\Controllers;

use App\Models\admin_detail;
use App\Models\department;
use DateTime;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function departments()
    {
        $departments = department::where('status','!=','Deleted')->get();
        return view('admin.departments.departments', compact('departments'));
    }

public function add_department(Request $req)
    {
       if(department::where('department',$req->dept)->where('status','!=','Deleted')->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
        department::create([

            'department'=>$req->dept,
            'status'=>'Active',      

        ]);

        $data['success']='Success';

       }
      
        echo json_encode($data);
       
    }

    public function edit_department(Request $req)
    {
        if(department::where('department',$req->dept)->where('status','!=','Deleted')->where('id','!=',$req->dept_id)->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      department::where('id',$req->dept_id)->update([

            'department'=>$req->dept,
            'status'=>$req->status,      

        ]);

        $data['success']='Success';
      }
        echo json_encode($data);
       
    }

    public function delete_department(Request $req)
    {

      department::where('id',$req->dept_id)->update([
          
          'status'=>'Deleted',
          
          ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    


}

