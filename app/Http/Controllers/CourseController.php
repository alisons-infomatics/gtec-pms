<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use App\Models\admin_detail;
use App\Models\course;
use App\Models\department;
use DateTime;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function courses()
    {
        $courses = course::where('status','!=','Deleted')->get();
        $departments = department::where('status','!=','Deleted')->get();
        return view('admin.courses.courses', compact('courses','departments'));
    }
    
    public function bulkUploadCourses(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt'
        ]);
    
        $file = $request->file('csv_file');
        $handle = fopen($file, 'r');
        $header = fgetcsv($handle); // skip header
    
        $departments = department::pluck('id', 'department')->mapWithKeys(function ($id, $name) {
            return [strtolower(trim($name)) => $id];
        });
    
        $inserted = 0;
        $skipped = [];
    
        while (($row = fgetcsv($handle)) !== false) {
            $courseName = trim($row[0]);
            $deptName = strtolower(trim($row[1]));
    
            if (!$courseName || !$deptName || !isset($departments[$deptName])) {
                $skipped[] = $courseName ?: '[Unnamed]';
                continue;
            }
    
            $deptId = $departments[$deptName];
    
            $exists = course::where('course', $courseName)
                ->where('dept_id', $deptId)
                ->where('status', '!=', 'Deleted')
                ->exists();
    
            if (!$exists) {
                Course::create([
                    'course' => $courseName,
                    'dept_id' => $deptId,
                    'status' => 'Active',
                ]);
                $inserted++;
            } else {
                $skipped[] = $courseName;
            }
        }
    
        fclose($handle);
    
        return response()->json([
            'success' => "$inserted courses added successfully.",
            'skipped' => $skipped
        ]);
    }

    public function add_course(Request $req)
    {
        if(course::where('course',$req->course)->where('status','!=','Deleted')->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      course::create([

            'dept_id'=>$req->dept,
            'course'=>$req->course,
            'status'=>'Active',      

        ]);

        $data['success']='Success';
        }
            echo json_encode($data);
           
    }

    public function edit_course(Request $req)
    {
        if(course::where('course',$req->course)->where('status','!=','Deleted')->where('id','!=',$req->course_id)->exists()) 
       {
        $data['err']='Error';
       }
       else
       {
      course::where('id',$req->course_id)->update([

            'dept_id'=>$req->dept,
            'course'=>$req->course,
            'status'=>$req->status,      

        ]);

        $data['success']='Success';
    }
        echo json_encode($data);
       
    }

    public function delete_course(Request $req)
    {
     
      course::where('id',$req->course_id)->update([
          
          'status'=>'Deleted',
          
          ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    


}

