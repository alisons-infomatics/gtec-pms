<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\student;
use App\Models\department;
use App\Models\course;
use App\Models\job_role;
use App\Models\interview;
use App\Models\employer;
use App\Models\job_role_list;
use Auth;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\InterviewsExport;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\DB;


class InterviewController extends Controller
{
    public function add_interview(Request $req)
    {
        $admin = Auth::guard('admin')->user();
      interview::create([

            'student_id'=>$req->student_id,
            'interview_date'=>$req->idate,
            'interview_time'=>$req->itime,
            'employer'=>$req->emp,
            'job_role'=>$req->job_role,
            'remarks'=>$req->remarks,
            'attendance'=>'Not Attended',
            'status'=>'Pending',
            'created_by'=> $admin->id,
        ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }
    
    public function export(Request $request, $type, $status)
    {
        $interviews = interview::with(['jobRole','GetStd'])->where('status', $status);

        $interviews->whereHas('jobRole', function ($query) use ($request) {
    
            if ($request->filled('departments')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->departments as $dept) {
                        $q->orWhereRaw("FIND_IN_SET(?, department)", [$dept]);
                    }
                });
            }
    
            if ($request->filled('job_roles')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->job_roles as $role) {
                        $q->orWhereRaw("FIND_IN_SET(?, job_role)", [$role]);
                    }
                });
            }
    
            if ($request->filled('genders')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->genders as $gender) {
                        $q->orWhereRaw("FIND_IN_SET(?, gender)", [$gender]);
                    }
                });
            }
    
            if ($request->filled('qualifications')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->qualifications as $qualification) {
                        $q->orWhereRaw("FIND_IN_SET(?, qualification)", [$qualification]);
                    }
                });
            }
            // if ($request->filled('quali_courses')) {
            //     $query->where(function ($q) use ($request) {
            //         foreach ($request->quali_courses as $quali_courses) {
            //             $q->orWhereRaw("FIND_IN_SET(?, qualification_course)", [$quali_courses]);
            //         }
            //     });
            // }
            
            
    
            if ($request->filled('experiences')) {
                $query->where(function ($q) use ($request) {
                    foreach ($request->experiences as $exp) {
                        $q->orWhereRaw("FIND_IN_SET(?, experience)", [$exp]);
                    }
                });
            }
        });
    
        // Direct interview filters
        if ($request->filled('employers')) {
            $interviews->whereIn('employer', $request->employers);
        }
    
        if ($request->filled('stages')) {
            $interviews->whereIn('interview_stage', $request->stages);
        }
        
         if ($request->filled('date_from')) {
            $interviews->whereDate('interview_date', '>=', $request->date_from);
        }
    
        if ($request->filled('date_to')) {
            $interviews->whereDate('interview_date', '<=', $request->date_to);
        }
    
        $interviews = $interviews->get();
            
        if ($type === 'excel') {
            return Excel::download(new InterviewsExport($interviews), 'interviews.xlsx');
        } elseif ($type === 'pdf') {
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('students.interview_pdf', compact('interviews'))->render());
            $dompdf->render();
            return response($dompdf->output(), 200)
                  ->header('Content-Type', 'application/pdf')
                  ->header('Content-Disposition', 'attachment; filename="interview.pdf"');
        }
    
        return redirect()->back()->with('error', 'Invalid export type');
    }
    
    // public function add_interviews(Request $req)
    // {
        
    //     foreach ($req->student_ids as $studentId) {
    //         interview::create([
    //             'student_id'    => $studentId,
    //             'interview_date'=> $req->idate,
    //             'interview_time'=> $req->itime,
    //             'employer'      => $req->emp,
    //             'job_role'      => $req->job_role,
    //             'remarks'       => $req->remarks,
    //             'attendance'    => 'Not Attended',
    //             'status'        => 'Pending',
    //             'created_by'    => $admin->id,
    //         ]);
    //     }
    
    //     return response()->json(['success' => true]);
    // }
    
   

    public function add_interviews(Request $req)
    {   
        $admin = Auth::guard('admin')->user();
    
        DB::beginTransaction();
    
        try {
            foreach ($req->student_ids as $studentId) {
    
                // Insert interview
                $interviewId = DB::table('interviews')->insertGetId([
                    'student_id'     => $studentId,
                    'interview_date' => $req->idate,
                    'interview_time' => $req->itime,
                    'employer'       => $req->emp,
                    'job_role'       => $req->job_role,
                    'remarks'        => $req->remarks,
                    'attendance'     => 'Not Attended',
                    'status'         => 'Pending',
                    'created_by'     => $admin->id,
                    'created_at'     => now(),
                    'updated_at'     => now(),
                ]);
    
                
                    DB::table('student_interview_stages')->insert([
                        'student_id'   => $studentId,
                        'interview_id' => $interviewId,
                        'stage'   => 1, 
                        'status'       => 'Pending',
                        'updated_at'   => now(),
                    ]);
                
            }
    
            DB::commit();
    
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $e->getMessage()], 500);
        }
    }



    // public function edit_interview(Request $req)
    // {
        
    //     $admin = Auth::guard('admin')->user();
    //   interview::where('id',$req->interview_id)->update([

    //         'interview_date'=>$req->idate,
    //         'interview_time'=>$req->itime,
    //         'employer'=>$req->emp,
    //         'job_role'=>$req->job_role,
    //         'remarks'=>$req->remarks,
    //         'attendance'=>$req->attendance,
    //         'interview_stage'=>$req->stage,
    //         'status'=>$req->status,
    //         'created_by' =>$admin->id,
    //     ]);

    //     $data['success']='Success';
    //     echo json_encode($data);
       
    // }
    


    public function edit_interview(Request $req)
    {
        $admin = Auth::guard('admin')->user();
    
        if($req->attendance == "Not Attended"){
            $status = "Pending" ;
        }else{
            $status = $req->status ;
        }
        
        DB::table('interviews')->where('id', $req->interview_id)->update([
            'interview_date'   => $req->idate,
            'interview_time'   => $req->itime,
            'employer'         => $req->emp,
            'job_role'         => $req->job_role,
            'remarks'          => $req->remarks,
            'attendance'       => $req->attendance,
            'interview_stage'  => $req->stage,
            'status'           => $status,
            'created_by'       => $admin->id,
            'updated_at'       => now(),
        ]);
    
        $interview = DB::table('interviews')->where('id', $req->interview_id)->first();
    
        if ($interview) {
            
            DB::table('student_interview_stages')->insert([
                'student_id'   => $interview->student_id,
                'interview_id' => $interview->id,
                'stage'   => $req->stage, 
                'status'       => $status,
                'updated_at'   => now(),
            ]);
        }

        return response()->json(['success' => 'Success']);
    }


    public function delete_interview(Request $req)
    {
        
      interview::where('id',$req->interview_id)->update([
          
          'status'=>'Deleted',
          
          ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    public function getJobRolesByEmployer(Request $request)
    {
        $employerId = $request->employer_id;

        $job_roles = job_role_list::where('company_id', $employerId)
                    ->where('status', 'Open') // optional filter if needed
                    ->get();

        return response()->json([
            'job_roles' => $job_roles,
        ]);
    }

    // public function pending_interviews()
    // {
    //     $interviews = interview::where('status','Pending')->get();
    //     $employers = employer::where('status','Active')->orderBy('company_name','ASC')->get();
    //     $depts=department::where('status','Active')->get();
    //     $job_roles=job_role_list::where('status','Open')->get();
    //     return view('admin.interviews.pending_interviews', compact('interviews','employers','depts','job_roles'));
    // }
    
  public function pending_interviews(Request $request)
{
    //dd($request->all());
    $interviews = interview::with('jobRole')->where('status', 'Pending');

    $interviews->whereHas('jobRole', function ($query) use ($request) {

        if ($request->filled('departments')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->departments as $dept) {
                    $q->orWhereRaw("FIND_IN_SET(?, department)", [$dept]);
                }
            });
        }

        if ($request->filled('job_roles')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->job_roles as $role) {
                    $q->orWhereRaw("FIND_IN_SET(?, job_role)", [$role]);
                }
            });
        }

        if ($request->filled('genders')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genders as $gender) {
                    $q->orWhereRaw("FIND_IN_SET(?, gender)", [$gender]);
                }
            });
        }

        if ($request->filled('qualifications')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->qualifications as $qualification) {
                    $q->orWhereRaw("FIND_IN_SET(?, qualification)", [$qualification]);
                }
            });
        }
        // if ($request->filled('quali_courses')) {
        //     $query->where(function ($q) use ($request) {
        //         foreach ($request->quali_courses as $quali_courses) {
        //             $q->orWhereRaw("FIND_IN_SET(?, qualification_course)", [$quali_courses]);
        //         }
        //     });
        // }
        
        

        if ($request->filled('experiences')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->experiences as $exp) {
                    $q->orWhereRaw("FIND_IN_SET(?, experience)", [$exp]);
                }
            });
        }
    });

    // Direct interview filters
    if ($request->filled('employers')) {
        $interviews->whereIn('employer', $request->employers);
    }

    if ($request->filled('stages')) {
        $interviews->whereIn('interview_stage', $request->stages);
    }
    
     if ($request->filled('date_from')) {
        $interviews->whereDate('interview_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $interviews->whereDate('interview_date', '<=', $request->date_to);
    }

    $interviews = $interviews->get();

    $employers = employer::where('status', 'Active')->orderBy('company_name', 'ASC')->get();
   // $depts = department::where('status', 'Active')->get();
   $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $depts = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $depts = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
    $job_roles = job_role_list::where('status', 'Open')->get();

    return view('admin.interviews.pending_interviews', compact(
        'interviews', 'employers', 'depts', 'job_roles'
    ));
}




    // public function shortlisted_interviews()
    // {
    //     $interviews = interview::where('status','Short Listed')->get();
    //     $employers = employer::where('status','Active')->orderBy('company_name','ASC')->get();
    //     return view('admin.interviews.shortlisted_interviews', compact('interviews','employers'));
    // }
    
   public function shortlisted_interviews(Request $request)
{
    $interviews = interview::with('jobRole')->where('status', 'Short Listed');

    $interviews->whereHas('jobRole', function ($query) use ($request) {
        if ($request->filled('departments')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->departments as $dept) {
                    $q->orWhereRaw("FIND_IN_SET(?, department)", [$dept]);
                }
            });
        }

        if ($request->filled('job_roles')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->job_roles as $role) {
                    $q->orWhereRaw("FIND_IN_SET(?, job_role)", [$role]);
                }
            });
        }

        if ($request->filled('genders')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genders as $gender) {
                    $q->orWhereRaw("FIND_IN_SET(?, gender)", [$gender]);
                }
            });
        }

        if ($request->filled('qualifications')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->qualifications as $qualification) {
                    $q->orWhereRaw("FIND_IN_SET(?, qualification)", [$qualification]);
                }
            });
        }

        if ($request->filled('experiences')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->experiences as $exp) {
                    $q->orWhereRaw("FIND_IN_SET(?, experience)", [$exp]);
                }
            });
        }
    });

    if ($request->filled('employers')) {
        $interviews->whereIn('employer', $request->employers);
    }
    if ($request->filled('stages')) {
        $interviews->whereIn('interview_stage', $request->stages);
    }
     if ($request->filled('date_from')) {
        $interviews->whereDate('interview_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $interviews->whereDate('interview_date', '<=', $request->date_to);
    }

    $interviews = $interviews->get();
    $employers = employer::where('status', 'Active')->orderBy('company_name', 'ASC')->get();
    //$depts = department::where('status', 'Active')->get();
    $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $depts = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $depts = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
    $job_roles = job_role_list::where('status', 'Open')->get();

    return view('admin.interviews.shortlisted_interviews', compact(
        'interviews', 'employers', 'depts', 'job_roles'
    ));
}


    // public function placed_interviews()
    // {
    //     $interviews = interview::where('status','Placed')->get();
    //     $employers = employer::where('status','Active')->orderBy('company_name','ASC')->get();
    //     return view('admin.interviews.placed_interviews', compact('interviews','employers'));
    // }
    
    public function placed_interviews(Request $request)
{
    $interviews = interview::with('jobRole')->where('status', 'Placed');

    $interviews->whereHas('jobRole', function ($query) use ($request) {
        if ($request->filled('departments')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->departments as $dept) {
                    $q->orWhereRaw("FIND_IN_SET(?, department)", [$dept]);
                }
            });
        }

        if ($request->filled('job_roles')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->job_roles as $role) {
                    $q->orWhereRaw("FIND_IN_SET(?, job_role)", [$role]);
                }
            });
        }

        if ($request->filled('genders')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genders as $gender) {
                    $q->orWhereRaw("FIND_IN_SET(?, gender)", [$gender]);
                }
            });
        }

        if ($request->filled('qualifications')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->qualifications as $qualification) {
                    $q->orWhereRaw("FIND_IN_SET(?, qualification)", [$qualification]);
                }
            });
        }

        if ($request->filled('experiences')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->experiences as $exp) {
                    $q->orWhereRaw("FIND_IN_SET(?, experience)", [$exp]);
                }
            });
        }
    });

    if ($request->filled('employers')) {
        $interviews->whereIn('employer', $request->employers);
    }
    if ($request->filled('stages')) {
        $interviews->whereIn('interview_stage', $request->stages);
    }
     if ($request->filled('date_from')) {
        $interviews->whereDate('interview_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $interviews->whereDate('interview_date', '<=', $request->date_to);
    }

    $interviews = $interviews->get();
    $employers = employer::where('status', 'Active')->orderBy('company_name', 'ASC')->get();
    //$depts = department::where('status', 'Active')->get();
    $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $depts = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $depts = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
    $job_roles = job_role_list::where('status', 'Open')->get();

    return view('admin.interviews.placed_interviews', compact(
        'interviews', 'employers', 'depts', 'job_roles'
    ));
}


    // public function rejected_interviews()
    // {
    //     $interviews = interview::where('status','Rejected')->get();
    //     $employers = employer::where('status','Active')->orderBy('company_name','ASC')->get();
    //     return view('admin.interviews.rejected_interviews', compact('interviews','employers'));
    // }

public function rejected_interviews(Request $request)
{
    $interviews = interview::with('jobRole')->where('status', 'Rejected');

    $interviews->whereHas('jobRole', function ($query) use ($request) {
        if ($request->filled('departments')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->departments as $dept) {
                    $q->orWhereRaw("FIND_IN_SET(?, department)", [$dept]);
                }
            });
        }

        if ($request->filled('job_roles')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->job_roles as $role) {
                    $q->orWhereRaw("FIND_IN_SET(?, job_role)", [$role]);
                }
            });
        }

        if ($request->filled('genders')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->genders as $gender) {
                    $q->orWhereRaw("FIND_IN_SET(?, gender)", [$gender]);
                }
            });
        }

        if ($request->filled('qualifications')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->qualifications as $qualification) {
                    $q->orWhereRaw("FIND_IN_SET(?, qualification)", [$qualification]);
                }
            });
        }

        if ($request->filled('experiences')) {
            $query->where(function ($q) use ($request) {
                foreach ($request->experiences as $exp) {
                    $q->orWhereRaw("FIND_IN_SET(?, experience)", [$exp]);
                }
            });
        }
    });

    if ($request->filled('employers')) {
        $interviews->whereIn('employer', $request->employers);
    }
    if ($request->filled('stages')) {
        $interviews->whereIn('interview_stage', $request->stages);
    }
     if ($request->filled('date_from')) {
        $interviews->whereDate('interview_date', '>=', $request->date_from);
    }

    if ($request->filled('date_to')) {
        $interviews->whereDate('interview_date', '<=', $request->date_to);
    }

    $interviews = $interviews->get();
    $employers = employer::where('status', 'Active')->orderBy('company_name', 'ASC')->get();
    //$depts = department::where('status', 'Active')->get();
    $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $depts = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $depts = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
    $job_roles = job_role_list::where('status', 'Open')->get();

    return view('admin.interviews.rejected_interviews', compact(
        'interviews', 'employers', 'depts', 'job_roles'
    ));
}



    public function bulkUpdateInterview(Request $request)
    {
        $ids = $request->ids;
        $attendance = $request->attendance;
        $status = $request->status;
    
        if (!$ids || count($ids) === 0) {
            return response()->json(['success' => false, 'message' => 'No rows selected']);
        }
    
        Interview::whereIn('id', $ids)->update([
            'attendance' => $attendance,
            'status' => $status,
        ]);
    
        return response()->json(['success' => true]);
    }



}
