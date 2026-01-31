<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\IOFactory;

use App\Models\admin_detail;
use App\Models\student;
use App\Models\department;
use App\Models\course;
use App\Models\job_role;
use App\Models\interview;
use App\Models\employer;
use App\Models\job_role_list;
use DateTime,Auth,DB;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Exports\StudentsExport;
use Dompdf\Dompdf;
use App\Models\StudentInterviewStage;

class StudentController extends Controller
{


    public function updateStudentStatusBySheet(Request $request)
{
   
    if (!$request->hasFile('excel_file2') || !$request->file('excel_file2')->isValid()) {
        return response()->json(['success' => false, 'message' => 'Invalid file upload']);
    }

    $path = $request->file('excel_file2')->getRealPath();

    try {
        $spreadsheet = IOFactory::load($path);
        $sheet = $spreadsheet->getActiveSheet();
        $rows = $sheet->toArray();
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Excel read error: ' . $e->getMessage()]);
    }

    unset($rows[0]); 

    $updatedCount = 0;
    foreach ($rows as $row) {
        $gemsId = trim($row[2]);
        $status = trim($row[13]);
        //dd($gemsId);

        if (!$gemsId) {
            continue; 
        }

        $statusMap = [
                'live' => 'Live',
                'placed' => 'Placed',
                'no response' => 'No Response',
                'no need job' => 'No Need',
                'deleted' => 'Deleted'
            ];
            $normalizedStatus = $statusMap[strtolower($status)] ?? 'No Response';
            
        $student = student::where('reg_num', $gemsId)->first();


        if ($student) {
            $student->status = $normalizedStatus;
            $student->save();
            $updatedCount++;
        }
    }

    return response()->json(['success' => true, 'message' => "Updated $updatedCount student records"]);
}

    public function bulkUploadStudents(Request $request)
{
    if (!$request->hasFile('excel_file') || !$request->file('excel_file')->isValid()) {
        return response()->json(['success' => false, 'message' => 'Invalid file upload']);
    }

    $path = $request->file('excel_file')->getRealPath();

    try {
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($path);
    } catch (\Exception $e) {
        return response()->json(['success' => false, 'message' => 'Excel read error: ' . $e->getMessage()]);
    }

    $sheet = $spreadsheet->getActiveSheet();
    $rows = $sheet->toArray();
    unset($rows[0]); // skip header

    $skipped = [];
    foreach ($rows as $index => $row) {
        try {
            // Extract + trim
            $date = trim($row[1]);
            $regNum = trim($row[2]);
            $name = trim($row[3]);
            $contact1 = trim($row[4]);
            $contact2 = trim($row[5]);
            $place = trim($row[6]);
            $qualification = trim($row[7]);
            $departmentName = strtoupper(trim($row[8]));
            $courseName = strtoupper(trim($row[9]));
            $gender = trim($row[10]);
            $preferredJob = trim($row[12]);
            $status = trim($row[13]);
            $reason1 = trim($row[13]);

            $interview1Status = trim($row[14]);
            $interviewDate1 = trim($row[15]);
            $interview1Reason = trim($row[16]);

            $interview2Status = trim($row[17]);
            $interviewDate2 = trim($row[18]);
            $interview2Reason = trim($row[19]);

            $interview3Status = trim($row[20]);
            $interviewDate3 = trim($row[21]);
            $interview3Reason = trim($row[22]);

            $interview4Status = trim($row[23]);
            $interviewDate4 = trim($row[24]);
            $interview4Reason = trim($row[25]);

            $interview5Status = trim($row[26]);
            $interviewDate5 = trim($row[27]);
            $interview5Reason = trim($row[28]);

            $placement = trim($row[29]);
            $placedDate = trim($row[30]);

            // Department + Course matching (fallback to text)
            $department = department::whereRaw('TRIM(UPPER(department)) = ?', [$departmentName])
                                     ->where('status', 'Active')
                                     ->first();
            $departmentIdOrName = $department ? $department->id : $departmentName;

            $course = course::whereRaw('TRIM(UPPER(course)) = ?', [$courseName])
                            ->where('status', 'Active');
            if ($department) {
                $course = $course->where('dept_id', $department->id);
            }
            $course = $course->first();
            $courseIdOrName = $course ? $course->id : $courseName;

            // Name parts
            $nameParts = explode(' ', $name);
            $firstName = $nameParts[0] ?? '';
            $middleName = $nameParts[1] ?? '';
            $lastName = $nameParts[2] ?? '';

            // Normalize status
            $statusMap = [
                'live' => 'Live',
                'placed' => 'Placed',
                'no response' => 'No Response',
                'no need job' => 'No Need',
                'deleted' => 'Deleted'
            ];
            $normalizedStatus = $statusMap[strtolower($status)] ?? 'No Response';

            // Safe date parsing
            $approveDate = $this->safeDate($date);

            // Insert student
            $student = student::create([
                'first_name' => $firstName,
                'middle_name' => $middleName,
                'last_name' => $lastName,
                'mobile_code' => 91,
                'mobile' => $contact1,
                'alternate_mobile_code' => 91,
                'alternate_mobile' => $contact2,
                'place' => $place,
                'gender' => $gender,
                'reg_num' => $regNum,
                'qualification' => $qualification,
                'dept' => is_numeric($departmentIdOrName) ? $departmentIdOrName : null,
                'dept_text' => !is_numeric($departmentIdOrName) ? $departmentIdOrName : null,
                'course' => is_numeric($courseIdOrName) ? $courseIdOrName : null,
                'course_text' => !is_numeric($courseIdOrName) ? $courseIdOrName : null,
                'remarks' => $preferredJob,
                'status' => $normalizedStatus,
                'approve_date' => $approveDate,
                'approved_by' => 1,
            ]);

            // Interview 1
            $interview = interview::create([
                'student_id' => $student->id,
                'interview_date' => $this->safeDate($interviewDate1),
                'interview_time' => null,
                'employer' => null,
                'job_role' => null,
                'remarks' => $interview1Reason,
                'attendance' => 'Not Attended',
                'status' => 'Pending',
                'interview_stage' => 1,
                'created_by' => 1
            ]);

            StudentInterviewStage::create([
                'student_id' => $student->id,
                'interview_id' => $interview->id,
                'stage' => 1,
                'status' => 'Pending',
                'remarks' => $interview1Reason,
                'updated_at' => $interview->interview_date ?? now(),
            ]);

            // Stages 2-5
            for ($i = 2; $i <= 5; $i++) {
                $statusVar = ${"interview{$i}Status"};
                $dateVar = ${"interviewDate{$i}"};
                $reason = ${"interview{$i}Reason"};

                if ($statusVar || $dateVar) {
                    StudentInterviewStage::create([
                        'student_id' => $student->id,
                        'interview_id' => $interview->id,
                        'stage' => $i,
                        'status' => $statusVar ?: 'Pending',
                        'remarks' => $reason ?? '',
                        'updated_at' => $this->safeDate($dateVar),
                    ]);
                }
            }

            // Placed stage
            if (strtolower($placement) === 'placed' && $placedDate) {
                StudentInterviewStage::create([
                    'student_id' => $student->id,
                    'interview_id' => $interview->id,
                    'stage' => 6,
                    'status' => 'Placed',
                    'remarks' => 'Placed via upload',
                    'updated_at' => $this->safeDate($placedDate),
                ]);
            }

        } catch (\Exception $e) {
            $skipped[] = "Row " . ($index + 1) . ": " . $e->getMessage();
            continue;
        }
    }

    return response()->json([
        'success' => true,
        'message' => 'Bulk upload completed',
        'processed' => count($rows) - count($skipped),
        'skipped' => $skipped
    ]);
}


/**
 * Helper to parse dates safely
 */
private function safeDate($dateStr)
{
    $dateStr = trim($dateStr);
    if (!$dateStr) return now();

    $parts = explode('/', $dateStr);
    if (count($parts) === 3) {
        $parts[0] = str_pad($parts[0], 2, '0', STR_PAD_LEFT);
        $parts[1] = str_pad($parts[1], 2, '0', STR_PAD_LEFT);
        if (strlen($parts[2]) < 4) {
            $parts[2] = str_pad($parts[2], 4, '20', STR_PAD_LEFT);
        }
        $dateStr = implode('/', $parts);
        try {
            return \Carbon\Carbon::createFromFormat('d/m/Y', $dateStr)->format('Y-m-d');
        } catch (\Exception $e) {
            return now();
        }
    }

    try {
        return \Carbon\Carbon::parse($dateStr)->format('Y-m-d');
    } catch (\Exception $e) {
        return now();
    }
}


    public function approval_pending_students()
    {
        //$students = student::where('status','Pending')->get();
        $admin = Auth::guard('admin')->user();

        $students = student::where('status', 'Pending');
        
        if ($admin->id != 1) {
            $userDeptIds = explode(',', $admin->department);
        
            $students->where(function ($query) use ($userDeptIds) {
                foreach ($userDeptIds as $deptId) {
                    $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
                }
            });
        }
        
        $students = $students->get();

        return view('admin.students.pending_students', compact('students'));
    }
    
    public function export(Request $request, $type)
    {
        //dd("here");
        $admin = Auth::guard('admin')->user();
        $students = student::whereIn('status', ['No Response','Live']);
    
        // Restrict departments for non-admins
        if ($admin->id != 1) {
            $userDeptIds = explode(',', $admin->department);
            $students->where(function ($query) use ($userDeptIds) {
                foreach ($userDeptIds as $deptId) {
                    $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
                }
            });
        }
    
        // CSV-based filters
        foreach (['departments' => 'dept', 'genders' => 'gender', 'qualifications' => 'qualification', 'courses' => 'course', 'quali_courses' => 'qualification_course'] as $input => $column) {
            if ($request->filled($input)) {
                $students->where(function ($q) use ($request, $input, $column) {
                    foreach ((array) $request->$input as $val) {
                        $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]);
                    }
                });
            }
        }
    
        // Job roles
        if ($request->filled('job_roles')) {
            $students->where(function ($q) use ($request) {
                foreach ((array) $request->job_roles as $val) {
                    $q->orWhere('job_role', $val)->orWhere('job_role', 'LIKE', "%$val%");
                }
            });
        }
    
        // Date filters
        if ($request->filled('created_from')) {
            $students->whereDate('approve_date', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $students->whereDate('approve_date', '<=', $request->created_to);
        }
    
        if ($request->filled('stages') && $request->stages !== null && $request->stages !== '') {
            $stage = $request->stages;
        
            $stageStudentIds = DB::table('interviews')
                ->where('interview_stage', $stage)
                ->pluck('student_id')
                ->unique()
                ->toArray();
        
            if (!empty($stageStudentIds)) {
                $students->whereIn('id', $stageStudentIds);
            } else {
                $students->whereRaw('0 = 1'); // No match
            }
        }
        
        if ($request->filled('exp')) {
        $now = date('Y-m-d');
        $expValues = $request->exp; // this is an array
        $expStudentIds = [];
    
        foreach ($expValues as $expValue) {
            if ($expValue === 'Overdue') {
                    $ids = DB::table('interviews')
                        ->whereDate('interview_date', '<', $now)
                        ->pluck('student_id')
                        ->toArray();
                } elseif (is_numeric($expValue)) {
                    $targetDate = date('Y-m-d', strtotime("+$expValue days"));
                    $ids = DB::table('interviews')
                        ->whereDate('interview_date', '=', $targetDate)
                        ->pluck('student_id')
                        ->toArray();
                } else {
                    $ids = [];
                }
        
                $expStudentIds = array_merge($expStudentIds, $ids);
            }
    
            $expStudentIds = array_unique($expStudentIds);
    
            if (!empty($expStudentIds)) {
                $students->whereIn('id', $expStudentIds);
            } else {
                $students->whereRaw('0 = 1'); 
            }
        }

        
        if($type == 'not_given')
        {
            $students = Student::whereDoesntHave('interviewStages')->get();
            
            return Excel::download(new StudentsExport($students), 'students.xlsx');
        }
        
        $students = $students->get();
    
        if ($type === 'excel') {
            return Excel::download(new StudentsExport($students), 'students.xlsx');
        } elseif ($type === 'pdf') {
            $dompdf = new Dompdf();
            $dompdf->loadHtml(view('students.export_pdf', compact('students'))->render());
            $dompdf->render();
            return response($dompdf->output(), 200)
                  ->header('Content-Type', 'application/pdf')
                  ->header('Content-Disposition', 'attachment; filename="students.pdf"');
        }
    
        return redirect()->back()->with('error', 'Invalid export type');
    }

    public function active_students()
    {
        $students = student::where('status','Active')->get();
        return view('admin.students.active_students', compact('students'));
    }
    public function blocked_students()
    {
        $students = student::where('status','Blocked')->get();
        return view('admin.students.blocked_students', compact('students'));
    }
    public function completed_students()
    {
        $students = student::where('status','Completed')->get();
        return view('admin.students.completed_students', compact('students'));
    }
    
    

//     public function live_students(Request $request)
// {
//     $students = student::where('status', 'Live');

//     // CSV-based filters
//     foreach (['departments' => 'dept', 'genders' => 'gender', 'qualifications' => 'qualification', 'courses' => 'course'] as $input => $column) {
//         if ($request->filled($input)) {
//             $students->where(function ($q) use ($request, $input, $column) {
//                 foreach ($request->$input as $val) {
//                     $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]);
//                 }
//             });
//         }
//     }

//     // Optional filter by job roles (if stored by job_role_id in students table)
//     if ($request->filled('job_roles')) {
//         $students->where(function ($q) use ($request) {
//             foreach ($request->job_roles as $val) {
//                 $q->orWhere('job_role', $val)->orWhere('job_role', 'LIKE', "%$val%");
//             }
//         });
//     }
    
//     if ($request->filled('created_from')) {
//         $students->whereDate('created_at', '>=', $request->created_from);
//     }

//     if ($request->filled('created_to')) {
//         $students->whereDate('created_at', '<=', $request->created_to);
//     }

//     $students = $students->get();

//     // Filter data for dropdowns
//     $admin = Auth::guard('admin')->user();
//         if ($admin->id == 1) {
//             $depts = department::where('status', 'Active')->get();
//         } else {
//             // Get comma-separated department IDs from user table
//             $deptIds = explode(',', $admin->department);
        
//             $depts = department::where('status', 'Active')
//                               ->whereIn('id', $deptIds)
//                               ->get();
//         }
        
//     $crs = course::where('status', 'Active')->get();
//     $employers = employer::where('status', 'Active')->get();
//     $job_roles = job_role_list::where('status', 'Open')->get();

//     return view('admin.students.live_students', compact('students', 'depts', 'employers', 'job_roles','crs'));
// }


// public function live_students(Request $request)
// {
//     $admin = Auth::guard('admin')->user();

//     $students = student::where('status', 'Live');

//     // Restrict departments for non-admins
//     if ($admin->id != 1) {
//         $userDeptIds = explode(',', $admin->department);

//         $students->where(function ($query) use ($userDeptIds) {
//             foreach ($userDeptIds as $deptId) {
//                 $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
//             }
//         });
//     }

//     // CSV-based filters
//     foreach (['departments' => 'dept', 'genders' => 'gender', 'qualifications' => 'qualification', 'courses' => 'course'] as $input => $column) {
//         if ($request->filled($input)) {
//             $students->where(function ($q) use ($request, $input, $column) {
//                 foreach ($request->$input as $val) {
//                     $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]);
//                 }
//             });
//         }
//     }

//     // Optional filter by job roles
//     if ($request->filled('job_roles')) {
//         $students->where(function ($q) use ($request) {
//             foreach ($request->job_roles as $val) {
//                 $q->orWhere('job_role', $val)->orWhere('job_role', 'LIKE', "%$val%");
//             }
//         });
//     }

//     // Date range filter
//     if ($request->filled('created_from')) {
//         $students->whereDate('created_at', '>=', $request->created_from);
//     }

//     if ($request->filled('created_to')) {
//         $students->whereDate('created_at', '<=', $request->created_to);
//     }

//     $students = $students->get();

//     // Filter dropdown data
//     if ($admin->id == 1) {
//         $depts = department::where('status', 'Active')->get();
//     } else {
//         $deptIds = explode(',', $admin->department);
//         $depts = department::where('status', 'Active')
//                           ->whereIn('id', $deptIds)
//                           ->get();
//     }

//     $crs = course::where('status', 'Active')->get();
//     $employers = employer::where('status', 'Active')->get();
//     $job_roles = job_role_list::where('status', 'Open')->get();

//     return view('admin.students.live_students', compact('students', 'depts', 'employers', 'job_roles', 'crs'));
// }


public function live_students(Request $request)
{
     //dd($request->all());
    $admin = Auth::guard('admin')->user();
    // $students = student::whereIn('status', ['No Response','Live']);
    $students = student::where('status', 'Live');
    // Restrict departments for non-admins
    if ($admin->id != 1) {
        $userDeptIds = explode(',', $admin->department);
        $students->where(function ($query) use ($userDeptIds) {
            foreach ($userDeptIds as $deptId) {
                $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
            }
        });
    }

    // CSV-based filters
    // foreach (['departments' => 'dept', 'genders' => 'gender', 'qualifications' => 'qualification', 'courses' => 'course', 'quali_courses' => 'qualification_course'] as $input => $column) {
    //     if ($request->filled($input)) {
    //         $students->where(function ($q) use ($request, $input, $column) {
    //             foreach ((array) $request->$input as $val) {
    //                 $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]);
    //             }
    //         });
    //     }
    // }
    
    foreach (['departments' => 'dept', 'genders' => 'gender', 'qualifications' => 'qualification', 'courses' => 'course', 'quali_courses' => 'qualification_course'] as $input => $column) {

        if ($request->filled($input)) {
    
            // Special handling for courses if exclude_courses is set
            if ($input === 'courses' && $request->boolean('exclude_courses')) {
                $students->where(function ($q) use ($request, $input, $column) {
                    foreach ((array) $request->$input as $val) {
                        $q->whereRaw("FIND_IN_SET(?, {$column}) = 0", [$val]); // exclude courses
                    }
                });
            } else {
                $students->where(function ($q) use ($request, $input, $column) {
                    foreach ((array) $request->$input as $val) {
                        $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]); // normal filter
                    }
                });
            }
    
        }
    }

    // // Job roles
    // if ($request->filled('job_roles')) {
    //     $students->where(function ($q) use ($request) {
    //         foreach ((array) $request->job_roles as $val) {
    //             $q->orWhere('job_role', $val)->orWhere('job_role', $val);
    //         }
    //     });
    // }
    
    // Job roles
    if ($request->filled('job_roles')) {
        $students->where(function ($q) use ($request) {
            foreach ((array) $request->job_roles as $val) {
                $q->orWhereRaw("FIND_IN_SET(?, job_role)", [$val]);
            }
        });
    }


    // Date filters
    if ($request->filled('created_from')) {
        $students->whereDate('approve_date', '>=', $request->created_from);
    }
    if ($request->filled('created_to')) {
        $students->whereDate('approve_date', '<=', $request->created_to);
    }

if ($request->filled('stages') && $request->stages !== null && $request->stages !== '') {
    $stage = $request->stages;

    $stageStudentIds = DB::table('interviews')
        ->where('interview_stage', $stage)
        ->pluck('student_id')
        ->unique()
        ->toArray();

    if (!empty($stageStudentIds)) {
        $students->whereIn('id', $stageStudentIds);
    } else {
        $students->whereRaw('0 = 1'); // No match
    }
}

// if ($request->filled('exp')) {
//     //dd($request->exp);
//     $now = date('Y-m-d');
//     $expValue = $request->exp;
//     $expStudentIds = [];

//     if ($expValue === 'Overdue') {
//         $expStudentIds = DB::table('interviews')
//             ->whereDate('interview_date', '<', $now)
//             ->pluck('student_id')
//             ->unique()
//             ->toArray();
//             dd($expStudentIds->get());
//     } elseif (is_numeric($expValue)) {
//         $targetDate = date('Y-m-d', strtotime("+$expValue days"));
//         $expStudentIds = DB::table('interviews')
//             ->whereDate('interview_date', '=', $targetDate)
//             ->pluck('student_id')
//             ->unique()
//             ->toArray();
//     }

//     if (!empty($expStudentIds)) {
//         $students->whereIn('id', $expStudentIds);
//     } else {
//         $students->whereRaw('0 = 1'); // no match
//     }
// }

/*
// if ($request->filled('exp')) {
//     $now = date('Y-m-d');
//     $expValues = $request->exp; // this is an array
//     $expStudentIds = [];

//     foreach ($expValues as $expValue) {
//         if ($expValue === 'Overdue') {
//             $ids = DB::table('interviews')
//                 ->where('attendance', 'Not Attended')
//                 ->whereDate('interview_date', '<', $now)
//                 ->pluck('student_id')
//                 ->toArray();
//         } elseif (is_numeric($expValue)) {
//             $targetDate = date('Y-m-d', strtotime("+$expValue days"));
//             $ids = DB::table('interviews')
//                 ->where('attendance', 'Not Attended')
//                 ->whereDate('interview_date', '<=', $targetDate)
//                 ->pluck('student_id')
//                 ->toArray();
//         } else {
//             $ids = [];
//         }

//         $expStudentIds = array_merge($expStudentIds, $ids);
//     }

//     $expStudentIds = array_unique($expStudentIds);

//     if (!empty($expStudentIds)) {
//         $students->whereIn('id', $expStudentIds);
//     } else {
//         $students->whereRaw('0 = 1'); 
//     }
// }
*/


    $students->where(function($query) use($request){
        if($request->interview_filter)
        {
            if (is_numeric($request->interview_filter)) {
                // $query->where(DB::raw("DATE_ADD(approve_date, INTERVAL {$request->interview_filter} DAY)"), );

                if($request->interview_filter == 15)
                {
                    $query->has('interviews', '>=', 1)
                    ->whereDate('approve_date', '<', now()->subDays(15));
                }
                elseif($request->interview_filter == 30)
                {
                    $query->has('interviews', '>=', 2)
                    ->whereDate('approve_date', '<', now()->subDays(30));
                }
                elseif($request->interview_filter == 45)
                {
                    $query->has('interviews', '>=', 3)
                    ->whereDate('approve_date', '<', now()->subDays(45));
                }
            }
            else
            {
                if($request->interview_filter == '15+')
                {
                    $query->has('interviews', '>=', 1);
                }
                elseif($request->interview_filter == '30+')
                {
                    $query->has('interviews', '>=', 2);
                }
                elseif($request->interview_filter == '45+')
                {
                    $query->has('interviews', '>=', 3);
                }
                elseif($request->interview_filter == 'no_15')
                {
                    $query->has('interviews', '<', 1)
                    ->whereDate('approve_date', '<', now()->subDays(15));
                }
                elseif($request->interview_filter == 'no_30')
                {
                    $query->has('interviews', '<', 2)
                    ->whereDate('approve_date', '<', now()->subDays(30));
                }
                elseif($request->interview_filter == 'no_45')
                {
                    $query->has('interviews', '<', 3)
                    ->whereDate('approve_date', '<', now()->subDays(45));
                }
                else {
                    $query->doesntHave('interviews');
                }
            }
        }
    });


    $students = $students->orderBy('created_at', 'desc')->get();

    // Dropdown data
    $depts = $admin->id == 1
        ? department::where('status', 'Active')->get()
        : department::where('status', 'Active')->whereIn('id', explode(',', $admin->department))->get();

    $crs = course::where('status', 'Active')->get();
    $employers = employer::where('status', 'Active')->get();
    // $job_roles = job_role_list::where('status', 'Open')->get();
    $job_roles = job_role::where('status', 'Active')->get();
    

    return view('admin.students.live_students', compact('students', 'depts', 'employers', 'job_roles', 'crs'));
}



    
    
    
     public function no_need_students()
    {
       // $students = student::where('status','No Need')->get();
        $admin = Auth::guard('admin')->user();

$students = student::where('status', 'No Need');

if ($admin->id != 1) {
    // User-specific department filter
    $userDeptIds = explode(',', $admin->department);

    $students->where(function ($query) use ($userDeptIds) {
        foreach ($userDeptIds as $deptId) {
            $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
        }
    });
}

$students = $students->orderBy('created_at', 'desc')->get();

        return view('admin.students.no_need_students', compact('students'));
    }
     public function no_response_students()
    {
        //$students = student::where('status','No Response')->get();
        $admin = Auth::guard('admin')->user();

        $students = student::where('status', 'No Response');
        
        if ($admin->id != 1) {
            $userDeptIds = explode(',', $admin->department);
        
            $students->where(function ($query) use ($userDeptIds) {
                foreach ($userDeptIds as $deptId) {
                    $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
                }
            });
        }
        
        $students = $students->orderBy('created_at', 'desc')->get();
        return view('admin.students.no_response_students', compact('students'));
    }
     public function self_placed_students()
    {
        //$students = student::where('status','Self Placed')->get();
        $admin = Auth::guard('admin')->user();

        $students = student::where('status', 'Self Placed');
        
        if ($admin->id != 1) {
            $userDeptIds = explode(',', $admin->department);
        
            $students->where(function ($query) use ($userDeptIds) {
                foreach ($userDeptIds as $deptId) {
                    $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
                }
            });
        }
        
        $students = $students->orderBy('created_at', 'desc')->get();
        return view('admin.students.self_placed_students', compact('students'));
    }
     public function placed_students()
    {
       // $students = student::where('status','Placed')->get();
       $admin = Auth::guard('admin')->user();

        $students = student::where('status', 'Placed');
        
        if ($admin->id != 1) {
            $userDeptIds = explode(',', $admin->department);
        
            $students->where(function ($query) use ($userDeptIds) {
                foreach ($userDeptIds as $deptId) {
                    $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
                }
            });
        }
        
        $students = $students->orderBy('created_at', 'desc')->get();
        return view('admin.students.placed_students', compact('students'));
    }

public function add_student()
    {
        //$dept = department::where('status','!=','Deleted')->get();
        $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $dept = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $dept = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
        $courses = course::where('status','!=','Deleted')->get();
        $job_roles = job_role::where('status','!=','Deleted')->get();
        return view('admin.students.add_students', compact('dept','courses','job_roles'));
    }

    public function student_add(Request $req)
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
            'photo'=>$new_name,
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
            'course'=>$req->crs,
            'experience'=>$req->exp,
            'experience_in'=>$req->experience_area,
            'remarks'=>$req->experience_remarks,
            'job_role'=>$req->job_roles,
            'behaviour_level'=>$req->a1,
            'skill_level'=>$req->a2,
            'lang_level'=>$req->a3,
            'status'=>'Live', 
            'approve_date'=> date('Y-m-d'),
            'approved_by' => $admin->id,

        ]);

        $data['success']='Success';
        echo json_encode($data);
       
    }

    public function edit_student($sid)
    {
        //$dept = department::where('status','!=','Deleted')->get();
        $admin = Auth::guard('admin')->user();
        if ($admin->id == 1) {
            $dept = department::where('status', 'Active')->get();
        } else {
            // Get comma-separated department IDs from user table
            $deptIds = explode(',', $admin->department);
        
            $dept = department::where('status', 'Active')
                               ->whereIn('id', $deptIds)
                               ->get();
        }
        $courses = course::where('status','!=','Deleted')->get();
        $job_roles = job_role::where('status','!=','Deleted')->get();
        $student = student::where('id',$sid)->first();
        $selectedDeptId = $student->dept;
        $selectedCourses = explode(',', $student->course); // Convert comma-separated string to array
        $selectedJobRoles = explode(',', $student->job_role); 
        return view('admin.students.edit_student', compact('dept','courses','job_roles','student','selectedDeptId','selectedCourses','selectedJobRoles'));
    }

    public function student_edit(Request $req)
    {
        //dd($req->all());
        $admin = Auth::guard('admin')->user();
        $std_det=student::select('id','photo','approve_date')->where('id',$req->student_id)->first();
        //dd($std_det);
        $photo = $req->file('photo');
            if ($photo == '') {
                $new_name = $std_det->photo;
            } else {
                $image = $req->file('photo');
                $new_name = "uploads/students/" . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/students'), $new_name);
            }
            if($req->exp != "Experienced"){
                $req->experience_area = "";
                $req->experience_remarks = "";
            }
            //  if($req->status != "Blocked"){
            //     $req->status_remarks = "";
            // }
            
            if($req->status == "Live" && $std_det->approve_date == null ){
                $approve_date = date('Y-m-d');
            }else{
                $approve_date = $std_det->approve_date;
            }
            

     student::where('id',$req->student_id)->update([

            'first_name'=>$req->fname,
            'middle_name'=>$req->mname,
            'last_name'=>$req->lname,
            'mobile_code'=>$req->mcode,
            'mobile'=>$req->mobile,
            'alternate_mobile_code'=>$req->mcode1,
            'alternate_mobile'=>$req->mobile1,
            'reg_num'=>$req->regnum,
            'photo'=>$new_name,
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
            'course'=>$req->crs,
            'experience'=>$req->exp,
            'experience_in'=>$req->experience_area,
            'remarks'=>$req->experience_remarks,
            'job_role'=>$req->job_roles,
            'status'=>$req->status,
            'status_remarks'=>$req->status_remarks,
            'behaviour_level'=>$req->a1,
            'skill_level'=>$req->a2,
            'lang_level'=>$req->a3,
            'approve_date'=> $approve_date,
            'approved_by' => $admin->id,

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
        $courses = course::where('dept_id', $deptId)->where('status','Active')->get();
        $job_roles = job_role::where('dept_id', $deptId)->get();
    
        return response()->json([
            'courses' => $courses,
            'job_roles' => $job_roles,
        ]);
    }

    public function getCoursesAndRoles1(Request $request)
    {
        $deptIds = is_array($request->dept_id) ? $request->dept_id : explode(',', $request->dept_id);
    
        $job_roles = job_role::whereIn('dept_id', $deptIds)->get();
    
        return response()->json([
            'job_roles' => $job_roles,
        ]);
    }

    public function getCoursesAndRoles2(Request $request)
    {
        $deptIds = is_array($request->dept_id)
            ? $request->dept_id
            : explode(',', $request->dept_id);  // handles both cases safely
    
        $courses = course::whereIn('dept_id', $deptIds)->get();
        $job_roles = job_role::whereIn('dept_id', $deptIds)->get();
    
        return response()->json([
            'courses' => $courses,
            'job_roles' => $job_roles,
        ]);
    }


    public function view_student($sid)
    {
       
        $student = student::where('id',$sid)->first();
        $interview = interview::where('student_id',$sid)->where('status','!=','Deleted')->latest()->get();
        
        $interviewStageHistory = \App\Models\StudentInterviewStage::where('student_id', $sid)
            ->with('interview') 
            ->orderBy('stage')
            ->get();
            
        $employers = employer::where('status','Active')->orderBy('company_name','ASC')->get();
        return view('admin.students.student_profile', compact('student','interview','employers','interviewStageHistory'));
    }



    public function bulkUpdateStatus(Request $request)
    {
        $ids = explode(',', $request->selected_students);
        $status = $request->status;
        $remarks = "";
        if($request->status == "Blocked"){
            $remarks = $request->status_remarks;
        }
    
        if (empty($ids) || !$status) {
            return response()->json(['error' => 'Invalid request'], 400);
        }
    
        student::whereIn('id', $ids)->update(['status' => $status,'status_remarks' => $remarks]);
    
        return response()->json(['success' => true]);
    }
   

    // public function interview_not_given()
    // {
    //     $admin = Auth::guard('admin')->user();

    //     $students = Student::whereDoesntHave('interviewStages')->whereNotIn('status',['Deleted','No Need','Self Placed']);
        
    //     if ($admin->id != 1) {
    //         $userDeptIds = explode(',', $admin->department);
        
    //         $students->where(function ($query) use ($userDeptIds) {
    //             foreach ($userDeptIds as $deptId) {
    //                 $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
    //             }
    //         });
    //     }
        
    //     $students = $students->get();
    //     return view('admin.students.interview_not_given', compact('students'));
    // }
    
    public function interview_not_given(Request $request)
    {
        
        $admin = Auth::guard('admin')->user();

        $students = Student::whereDoesntHave('interviewStages')->whereNotIn('status',['Deleted','No Need','Self Placed']);
        
        if ($admin->id != 1) {
            $userDeptIds = explode(',', $admin->department);
        
            $students->where(function ($query) use ($userDeptIds) {
                foreach ($userDeptIds as $deptId) {
                    $query->orWhereRaw("FIND_IN_SET(?, dept)", [$deptId]);
                }
            });
        }
        
        foreach (['departments' => 'dept', 'genders' => 'gender', 'qualifications' => 'qualification', 'courses' => 'course', 'quali_courses' => 'qualification_course'] as $input => $column) {

        if ($request->filled($input)) {
    
            // Special handling for courses if exclude_courses is set
            if ($input === 'courses' && $request->boolean('exclude_courses')) {
                $students->where(function ($q) use ($request, $input, $column) {
                    foreach ((array) $request->$input as $val) {
                        $q->whereRaw("FIND_IN_SET(?, {$column}) = 0", [$val]); // exclude courses
                    }
                });
            } else {
                $students->where(function ($q) use ($request, $input, $column) {
                    foreach ((array) $request->$input as $val) {
                        $q->orWhereRaw("FIND_IN_SET(?, {$column})", [$val]); // normal filter
                    }
                });
            }
    
        }
    }


    // Job roles
    if ($request->filled('job_roles')) {
        $students->where(function ($q) use ($request) {
            foreach ((array) $request->job_roles as $val) {
                $q->orWhere('job_role', $val)->orWhere('job_role', 'LIKE', "%$val%");
            }
        });
    }

    // Date filters
    if ($request->filled('created_from')) {
        $students->whereDate('approve_date', '>=', $request->created_from);
    }
    if ($request->filled('created_to')) {
        $students->whereDate('approve_date', '<=', $request->created_to);
    }

    if ($request->filled('stages') && $request->stages !== null && $request->stages !== '') {
        $stage = $request->stages;
    
        $stageStudentIds = DB::table('interviews')
            ->where('interview_stage', $stage)
            ->pluck('student_id')
            ->unique()
            ->toArray();
    
        if (!empty($stageStudentIds)) {
            $students->whereIn('id', $stageStudentIds);
        } else {
            $students->whereRaw('0 = 1'); // No match
        }
    }
    
    if ($request->filled('exp')) {
        $now = date('Y-m-d');
        
        $expValues = $request->exp; // this is an array
        $expStudentIds = [];
    
        foreach ($expValues as $expValue) {
            if ($expValue === 'Overdue') {
                $ids = DB::table('interviews')
                    ->where('attendance', 'Not Attended')
                    ->whereDate('interview_date', '<', $now)
                    ->pluck('student_id')
                    ->toArray();
            } elseif (is_numeric($expValue)) {
                $targetDate = date('Y-m-d', strtotime("+$expValue days"));
                $ids = DB::table('interviews')
                    ->where('attendance', 'Not Attended')
                    ->whereDate('interview_date', '<=', $targetDate)
                    ->pluck('student_id')
                    ->toArray();
            } else {
                $ids = [];
            }
    
            $expStudentIds = array_merge($expStudentIds, $ids);
        }
    
        $expStudentIds = array_unique($expStudentIds);
    
        if (!empty($expStudentIds)) {
            $students->whereIn('id', $expStudentIds);
        } else {
            $students->whereRaw('0 = 1'); 
        }
    }


        
        $students = $students->get();
        
         $depts = $admin->id == 1
        ? department::where('status', 'Active')->get()
        : department::where('status', 'Active')->whereIn('id', explode(',', $admin->department))->get();

        $crs = course::where('status', 'Active')->get();
        $employers = employer::where('status', 'Active')->get();
        $job_roles = job_role::where('status', 'Active')->get();
        
        return view('admin.students.interview_not_given', compact('students', 'depts', 'employers', 'job_roles', 'crs'));
    }


}

