<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AdminController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\JobRoleController;
use App\Http\Controllers\UserTypeController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\InterviewController;

use App\Http\Controllers\EmployerEnquiryController;

use App\Http\Middleware\AdminLoginCheck;
use App\Http\Middleware\PreventBack;

Route::get('/admin/upload-job-roles', [JobRoleController::class, 'uploadJobRoles']);


Route::get('/', [AdminController::class, 'sign_in'])->name('sign_in');
Route::post('/login', [AdminController::class, 'do_sign_in'])->name('do_sign_in');
Route::get('/register', [AdminController::class, 'register']);
Route::post('/student-register', [AdminController::class, 'student_register']);

Route::get('/reset-password', [AdminController::class, 'reset_password']);
//Route::get('/forgot-password', [AdminController::class, 'forgot_password']);
Route::post('/AdminMailChk' , [AdminController::class, 'admin_mail_chk']);
Route::get('/admin-password-reset/{tk}/{em}', [AdminController::class, 'admin_password_reset']);
Route::post('/adminpsw-reset' , [AdminController::class, 'adminpsw_reset']);

Route::middleware([AdminLoginCheck::class,PreventBack::class])->group(function () {
    
Route::get('/students/export/{type}', [StudentController::class, 'export'])->name('students.export')
                                        ->withoutMiddleware([\App\Http\Middleware\PreventBack::class]);

Route::get('interview/students/export/{type}/{status}', [InterviewController::class, 'export'])->name('interview.students.export')
                                        ->withoutMiddleware([\App\Http\Middleware\PreventBack::class]);
                                        
Route::get('/admin/dashboard',[AdminController::class, 'dashboard']);
Route::get('/admin/logout' , [AdminController::class, 'logout']);

Route::get('/admin/get-counsiler-departments/{counsilerId}', [AdminController::class, 'getCounsilerDepartments']);
Route::get('/counsiler/report', [AdminController::class, 'counsilerReport'])->name('counsiler.report');


Route::get('/admin/departments',[DepartmentController::class, 'departments']);
Route::post('/admin/add-department',[DepartmentController::class, 'add_department']);
Route::post('/admin/edit-department',[DepartmentController::class, 'edit_department']);
Route::post('/admin/delete-department',[DepartmentController::class, 'delete_department']);

Route::get('/admin/courses',[CourseController::class, 'courses']);
Route::post('/admin/add-course',[CourseController::class, 'add_course']);
Route::post('/admin/bulkupload/add-course',[CourseController::class, 'bulkUploadCourses']);
Route::post('/admin/edit-course',[CourseController::class, 'edit_course']);
Route::post('/admin/delete-course',[CourseController::class, 'delete_course']);

Route::get('/admin/job-roles',[JobRoleController::class, 'job_roles']);
Route::post('/admin/add-job_role',[JobRoleController::class, 'add_job_role']);
Route::post('/admin/edit-job_role',[JobRoleController::class, 'edit_job_role']);
Route::post('/admin/delete-job_role',[JobRoleController::class, 'delete_job_role']);

Route::get('/admin/user-types',[UserTypeController::class, 'user_types']);
Route::post('/admin/add-user_type',[UserTypeController::class, 'add_user_type']);
Route::post('/admin/edit-user_type',[UserTypeController::class, 'edit_user_type']);
Route::post('/admin/delete-user_type',[UserTypeController::class, 'delete_user_type']);

Route::get('/admin/users',[UserTypeController::class, 'users']);
Route::post('/admin/add-user',[UserTypeController::class, 'add_user']);
Route::post('/admin/edit-user',[UserTypeController::class, 'edit_user']);
Route::post('/admin/delete-user',[UserTypeController::class, 'delete_user']);

Route::get('/admin/rules/{uid}',[UserTypeController::class, 'rules']);
Route::post('/admin/set-rules',[UserTypeController::class, 'set_rules']);

Route::get('/admin/approval-pending-students',[StudentController::class, 'approval_pending_students']);

Route::get('/admin/active-students',[StudentController::class, 'active_students']);
Route::get('/admin/blocked-students',[StudentController::class, 'blocked_students']);
Route::get('/admin/completed-students',[StudentController::class, 'completed_students']);

Route::get('/admin/live-students',[StudentController::class, 'live_students']);
Route::get('/admin/no-need-students',[StudentController::class, 'no_need_students']);
Route::get('/admin/no-response-students',[StudentController::class, 'no_response_students']);
Route::get('/admin/self-placed-students',[StudentController::class, 'self_placed_students']);
Route::get('/admin/placed-students',[StudentController::class, 'placed_students']);
Route::get('/admin/interview-not-given',[StudentController::class, 'interview_not_given']);


Route::get('/admin/add-student',[StudentController::class, 'add_student']);
Route::post('/admin/student-add',[StudentController::class, 'student_add']);
Route::get('/admin/edit-student/{sid}',[StudentController::class, 'edit_student']);
Route::post('/admin/student-edit',[StudentController::class, 'student_edit']);
Route::post('/admin/delete-student',[StudentController::class, 'delete_student']);
Route::get('/admin/view-student/{sid}',[StudentController::class, 'view_student']);
Route::post('/admin/bulk-update-student-status',[StudentController::class, 'bulkUpdateStatus']);
//bulk upload
// Route::post('/admin/students/bulk-upload', [StudentController::class, 'bulkUploadStudents'])->name('admin.students.bulk_upload');
Route::post('/admin/students/bulk-upload', [StudentController::class, 'updateStudentStatusBySheet'])->name('admin.students.bulk_upload');


Route::post('/admin/add-interview',[InterviewController::class, 'add_interview']);
Route::post('/admin/edit-interview',[InterviewController::class, 'edit_interview']);
Route::post('/admin/delete-interview',[InterviewController::class, 'delete_interview']);
Route::get('/admin/get-job-roles', [InterviewController::class, 'getJobRolesByEmployer'])->name('getJobRolesByEmployer');

Route::get('/admin/pending-interviews',[InterviewController::class, 'pending_interviews']);
Route::get('/admin/shortlisted-interviews',[InterviewController::class, 'shortlisted_interviews']);
Route::get('/admin/placed-interviews',[InterviewController::class, 'placed_interviews']);
Route::get('/admin/rejected-interviews',[InterviewController::class, 'rejected_interviews']);
Route::post('/admin/interview-bulk-edit',[InterviewController::class, 'bulkUpdateInterview']);
Route::post('/admin/interview/bulk-update', [InterviewController::class, 'bulkUpdateInterview'])->name('bulk.update.interview');

Route::post('/admin/add-interviews', [InterviewController::class, 'add_interviews']);


//employer enquiry 17/06/2025
Route::get('/admin/list-employer-enquiry',[EmployerEnquiryController::class, 'index']);
Route::get('/admin/create-employer-enquiry',[EmployerEnquiryController::class, 'index']);
Route::post('/admin/add-employer-enquiry',[EmployerEnquiryController::class, 'add_employer_enquiry']);

Route::get('/admin/employers',[EmployerController::class, 'employers']);
Route::post('/admin/add-employer',[EmployerController::class, 'add_employer']);
Route::post('/admin/edit-employer',[EmployerController::class, 'edit_employer']);
Route::post('/admin/delete-employer',[EmployerController::class, 'delete_employer']);
Route::get('/admin/employer-profile/{eid}',[EmployerController::class, 'employer_profile']);
Route::post('/admin/add-contact',[EmployerController::class, 'add_contact']);
Route::post('/admin/edit-contact',[EmployerController::class, 'edit_contact']);
Route::post('/admin/delete-contact',[EmployerController::class, 'delete_contact']);


Route::get('/admin/add-job-role',[JobController::class, 'add_job_role']);
Route::get('/admin/job-roles-list',[JobController::class, 'job_roles_list']);
Route::get('/admin/closed-job-roles-list',[JobController::class, 'closed_job_roles_list']);
Route::post('/admin/job-add',[JobController::class, 'job_add']);

Route::get('/admin/edit-job/{jid}',[JobController::class, 'edit_job']);
Route::post('/admin/job-edit',[JobController::class, 'job_edit']);
Route::get('/admin/get-employer-contacts', [JobController::class, 'getEmployerContacts'])->name('getEmployerContacts');



});

Route::get('/get-courses-and-roles',[StudentController::class, 'getCoursesAndRoles'])->name('getCoursesAndRoles');
Route::get('/get-courses-and-roles1',[StudentController::class, 'getCoursesAndRoles1'])->name('getCoursesAndRoles1');
Route::get('/get-courses-and-roles2',[StudentController::class, 'getCoursesAndRoles2'])->name('getCoursesAndRoles2');