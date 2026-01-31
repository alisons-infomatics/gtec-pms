@extends('layouts.Admin')

@section('content')
    
@php
    $photoPath = $student->photo != '' ? asset($student->photo) : asset('/img/usr.jpg');
@endphp
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">View Profile</h6>
  <ul class="d-flex align-items-center gap-2">
    <li class="fw-medium">
      <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li>-</li>
    <li class="fw-medium">View Profile</li>
  </ul>
</div>

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <br><br><br><br><br>
                    <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="@if($student->photo!='') {{asset($student->photo)}} @else /img/usr.jpg @endif" alt="" class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <a href="{{ $photoPath }}" download class="btn btn-sm btn-primary mt-2">
                                Download Photo
                            </a>
                            <h6 class="mb-0 mt-16">{{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}</h6>
                            <span class="text-secondary-light mb-16">{{$student->email}}</span>
                        </div>
                        <div>
                            <span class="mt-4">Approve Date : {{ $student->approve_date ?? ''}}</span>
                        </div>
                        <div class="mt-24">
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                 <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">G-TEC REG.NO</span>
                                    <span class="w-70 text-secondary-light fw-medium">: <b>{{$student->reg_num}}</b></span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Full Name</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->first_name}} {{$student->middle_name}} {{$student->last_name}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->email}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Phone Number 1</span>
                                    <span class="w-70 text-secondary-light fw-medium">: +{{$student->mobile_code}} {{$student->mobile}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Phone Number 2</span>
                                    <span class="w-70 text-secondary-light fw-medium">: +{{$student->alternate_mobile_code}} {{$student->alternate_mobile}}</span>
                                </li>
                               
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                              <button class="nav-link d-flex align-items-center px-24 active" id="pills-change-passwork-tab" data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab" aria-controls="pills-change-passwork" aria-selected="true" tabindex="-1">
                                Interviews 
                              </button>
                            </li>
                            <li class="nav-item" role="presentation">
                              <button class="nav-link d-flex align-items-center px-24" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="false">
                                Profile 
                              </button>
                            </li>
                           
                            <!-- <li class="nav-item" role="presentation">
                              <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab" aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Notification Settings
                              </button>
                            </li> -->
                        </ul>

                        <div class="tab-content" id="pills-tabContent">   
                            <div class="tab-pane fade" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
                                
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Register Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->reg_num}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Gender</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->gender}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Address</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->address}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Place</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->place}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> DOB</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->dob}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Age</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->age}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Marital Status</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->marital_status}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Qualification</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->qualification}} &nbsp {{ ($student->qualification_course && $student->qualification_course !== 'null') ? $student->qualification_course : '' }}
</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Department</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->GetDept->department ?? $student->dept_text }}</span>
                                </li>
                                <!--<li class="d-flex align-items-center gap-1 mb-12">-->
                                <!--    <span class="w-30 text-md fw-semibold text-primary-light"> Course</span>-->
                                <!--    <span class="w-70 text-secondary-light fw-medium">: {{$student->GetCrs->course ?? $student->course_text}}</span>-->
                                <!--</li>-->
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Course</span>
                                    <span class="w-70 text-secondary-light fw-medium">: 
                                        {{
                                            collect(explode(',', $student->course ?? ''))
                                                ->map(fn($id) => \App\Models\course::find($id)?->course)
                                                ->filter()
                                                ->implode(', ')
                                                ?: ($student->course_text ?? 'N/A')
                                        }}
                                    </span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Experience</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->experience}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Experienced in</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->experience_in ?? ''}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Remarks</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->remarks ?? ''}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Job Role</span>
                                    @php
        use App\Models\job_role;

        $jobRoleIds = explode(',', $student->job_role); // split ids
        $jobRoles = job_role::whereIn('id', $jobRoleIds)->pluck('job_role')->toArray(); // get names
        $jobRolesString = implode(', ', $jobRoles); // join names
    @endphp
                                    <span class="w-70 text-secondary-light fw-medium">: {{$jobRolesString}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Overall Performance Grade</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$student->behaviour_level}}</span>
                                </li>
                                <!--<li class="d-flex align-items-center gap-1 mb-12">-->
                                <!--    <span class="w-30 text-md fw-semibold text-primary-light"> Skill Level</span>-->
                                <!--    <span class="w-70 text-secondary-light fw-medium">: {{$student->skill_level}}</span>-->
                                <!--</li>-->
                                <!--<li class="d-flex align-items-center gap-1 mb-12">-->
                                <!--    <span class="w-30 text-md fw-semibold text-primary-light"> Language Level</span>-->
                                <!--    <span class="w-70 text-secondary-light fw-medium">: {{$student->lang_level}}</span>-->
                                <!--</li>-->
                                <!--<li class="d-flex align-items-center gap-1 mb-12">-->
                                <!--    <span class="w-30 text-md fw-semibold text-primary-light"> Status</span>-->
                                <!--    <span class="w-70 text-secondary-light fw-medium">: {{$student->status}}</span>-->
                                <!--</li>-->
                               
                                
                            </ul>




                            </div>

                            <div class="tab-pane fade show active" id="pills-change-passwork" role="tabpanel" aria-labelledby="pills-change-passwork-tab" tabindex="0">
                           
                            <div class="card-header">
        <h5 class="card-title mb-0">Interview Details
<button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1">Add Interview</button>
        </h5>

      </div>
                            <div class="card-body mt-3">
        <table class="table bordered-table mb-0" id="dataTable1" data-page-length='10'>
          <thead>
            <tr>
              <th scope="col">
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    S.L
                  </label>
                </div>
              </th>
              <th scope="col">Title</th>
              <th scope="col">Date</th>
              <th scope="col">Employer</th>
              <th scope="col">Status</th>
              <th scope="col">Remarks</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>



@foreach($interview as $e)
 
            <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$e->GetRole->title ?? ''}} </td>
              <td>{{date("d-m-Y", strtotime($e->interview_date))}}<br> {{date("h:i a", strtotime($e->interview_time))}}</td>
              <td>{{$e->GetEmp->company_name ?? ''}}</td>
              <td>{{$e->status}}</td>
              <td>{{$e->remarks}}</td>
              <td>
                <!-- <a href="javascript:void(0)" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a> -->
                <a onclick="EditInterview('{{$e->id}}','{{$e->interview_date}}','{{$e->interview_time}}','{{$e->employer}}','{{$e->job_role}}','{{$e->attendance}}','{{$e->status}}','{{$e->remarks}}','{{$e->interview_stage}}')" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                <a onclick="DeleteInterview('{{$e->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                </a>
              </td>
            </tr>
            
@endforeach


            
          </tbody>
        </table>
        @isset($interviewStageHistory)
        @foreach ($interviewStageHistory as $stage)
    <p>
        Interview: {{ $stage->stage }} <br>
        Status: {{ $stage->status }} <br>
        Remarks: {{ $stage->remarks }} <br>
        Updated At: {{ $stage->updated_at }} <br>
        Interview Date: {{ $stage->interview->interview_date ?? 'N/A' }}
    </p>
@endforeach
@endisset
      </div>
      </div>
  
                            </div>

                            <div class="tab-pane fade" id="pills-notification" role="tabpanel" aria-labelledby="pills-notification-tab" tabindex="0">
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="companzNew" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Company News</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="companzNew">
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="pushNotifcation" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Push Notification</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="pushNotifcation" checked>
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="weeklyLetters" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Weekly News Letters</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="weeklyLetters" checked>
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="meetUp" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Meetups Near you</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="meetUp">
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="orderNotification" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Orders Notifications</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="orderNotification" checked>
                                    </div>
                                </div>
                            </div>


                            

                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
            
        </div>
    </div>


    <div class="modal fade" id="modaldemo1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Interview</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row"> 
                        <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Date</label>
                                <input type="date" class="form-control radius-8" placeholder="Enter Interview Date" id="idate">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Time</label>
                                <input type="time" class="form-control radius-8" placeholder="Enter Interview Time" id="itime">
                            </div>   
                            <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Employer Name</label>
                            <select id="emp" class="form-control radius-8" onchange="getJobRole(this.value)">
                                <option value="">Choose</option>
                                @foreach($employers as $e)
                                    <option value="{{ $e->id }}">{{ $e->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Job Role</label>
                            <select id="job_role" class="form-control radius-8">
                                <option value="">Choose</option>
                            </select>
                        </div>
 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Remarks</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Remarks" id="remarks">
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="AddInterview()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="add-button"> <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modaldemo2" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Interview</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row"> 
                        <div class="col-12 mb-20">
                        <input type="hidden" class="form-control radius-8" placeholder="Enter Interview Date" id="interview_id">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Date</label>
                                <input type="date" class="form-control radius-8" placeholder="Enter Interview Date" id="idate1">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Time</label>
                                <input type="time" class="form-control radius-8" placeholder="Enter Interview Time" id="itime1">
                            </div>   
                            <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Employer Name</label>
                            <select id="emp1" class="form-control radius-8" onchange="getJobRole1(this.value)">
                                <option value="">Choose</option>
                                @foreach($employers as $e)
                                    <option value="{{ $e->id }}">{{ $e->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Job Role</label>
                            <select id="job_role1" class="form-control radius-8">
                                <option value="">Choose</option>
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Stage</label>
                            <select id="stage" class="form-control radius-8">
                                
                                <option value="1">Interview 1</option>
                                <option value="2">Interview 2</option>
                                <option value="3">Interview 3</option>
                                <option value="4">Interview 4</option>
                                <option value="5">Interview 5</option>
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Attendance</label>
                            <select id="attendance" class="form-control radius-8">
                                
                                <option value="Attended">Attended</option>
                                <option value="Not Attended">Not Attended</option>
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                            <select id="status" class="form-control radius-8">
                               
                                <option value="Pending">Pending</option>
                                <option value="Rejected">Rejected</option>
                                <option value="Short Listed">Short Listed</option>
                                <option value="Placed">Placed</option>
                            </select>
                        </div>
 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Remarks</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Remarks" id="remarks1">
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="InterviewEdit()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="edit-button"> <i id="edit-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modaldemo3" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Interview</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="interview_id1">
                                
                            Do you want to delete this interview ?                        
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="InterviewDelete()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="del-button"> <i id="del-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    
    @endsection


    <script type="text/javascript">

function getJobRole(empId) {
    if (!empId) {
        $('#job_role').html('<option value="">Choose</option>');
        return;
    }

    $.ajax({
        url: "{{ route('getJobRolesByEmployer') }}",  // 👈 your route to fetch job roles
        type: "GET",
        data: { employer_id: empId },
        success: function (response) {
            let jobRoleSelect = $('#job_role');
            jobRoleSelect.empty();
            jobRoleSelect.append('<option value="">Choose</option>');

            if (response.job_roles?.length) {
                response.job_roles.forEach(function (role) {
                    jobRoleSelect.append('<option value="' + role.id + '">' + role.title + '</option>');
                });
            }
        },
        error: function () {
            alert("❌ Failed to fetch job roles!");
        }
    });
}

function getJobRole1(empId, selectedJobRole = null) {
    if (!empId) {
        $('#job_role1').html('<option value="">Choose</option>');
        return;
    }

    $.ajax({
        url: "{{ route('getJobRolesByEmployer') }}",
        type: "GET",
        data: { employer_id: empId },
        success: function (response) {
            let jobRoleSelect = $('#job_role1');
            jobRoleSelect.empty();
            jobRoleSelect.append('<option value="">Choose</option>');

            if (response.job_roles?.length) {
                response.job_roles.forEach(function (role) {
                    jobRoleSelect.append('<option value="' + role.id + '">' + role.title + '</option>');
                });

                if (selectedJobRole) {
                    // 🚀 Set the selected job role after options loaded
                    jobRoleSelect.val(selectedJobRole);
                }
            }
        },
        error: function () {
            alert("❌ Failed to fetch job roles!");
        }
    });
}

      
      function AddInterview() {
            
            var idate = $('input#idate').val();
            if (idate === '') 
            {
                $('#idate').focus();
                $('#idate').css({'border': '1px solid red'});
                return false;
            } else 
                $('#idate').css({'border': '1px solid #CCC'});

                var itime = $('input#itime').val();
            if (itime === '') 
            {
                $('#itime').focus();
                $('#itime').css({'border': '1px solid red'});
                return false;
            } else 
                $('#itime').css({'border': '1px solid #CCC'});

                var emp = $('#emp option:selected').val();
            if (emp === '') 
            {
                $('#emp').focus();
                $('#emp').css({'border': '1px solid red'});
                return false;
            } else 
                $('#emp').css({'border': '1px solid #CCC'}); 
                
                var job_role = $('#job_role option:selected').val();
            if (job_role === '') 
            {
                $('#job_role').focus();
                $('#job_role').css({'border': '1px solid red'});
                return false;
            } else 
                $('#job_role').css({'border': '1px solid #CCC'}); 
                var remarks = $('input#remarks').val();

            $('#add-loader').show();
            $('#add-button').prop('disabled', true);

            var data = new FormData();
            data.append('idate', idate);
            data.append('itime', itime);
            data.append('emp', emp);
            data.append('remarks', remarks);
            data.append('job_role', job_role);
            data.append('student_id', '{{$student->id}}');
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/add-interview",
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#add-loader').hide();
                    $('#add-button').prop('disabled', false);

                    if (data['success']) {
                        Swal.fire({
                            text: 'Added successfully!',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                        window.location.reload();
                       
                    }
                    
                    
                    if (data['err']) {
                        Swal.fire({
                            text: 'Course already exists',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'error',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            });
        }

        function EditInterview(id, dt, tm, emp, job, att, status, rmk,stg) {
          
    $('#modaldemo2').modal('show');
    getJobRole1(emp, job);
    $('#interview_id').val(id);
    $('#idate1').val(dt);
    $('#itime1').val(tm);
    $('#emp1').val(emp);

    // 🚀 Set the selected job_role (normal select)
    $('#job_role1').val(job);

    

    $('#attendance').val(att);
    $('#status').val(status);
    $('#remarks1').val(rmk);
    $('#stage').val(stg);
}


function InterviewEdit() {
            
  var idate = $('input#idate1').val();
            if (idate === '') 
            {
                $('#idate1').focus();
                $('#idate1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#idate1').css({'border': '1px solid #CCC'});

                var itime = $('input#itime1').val();
            if (itime === '') 
            {
                $('#itime1').focus();
                $('#itime1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#itime1').css({'border': '1px solid #CCC'});

                var emp = $('#emp1 option:selected').val();
            if (emp === '') 
            {
                $('#emp1').focus();
                $('#emp1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#emp1').css({'border': '1px solid #CCC'}); 
                
                var job_role = $('#job_role1 option:selected').val();
            if (job_role === '') 
            {
                $('#job_role1').focus();
                $('#job_role1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#job_role1').css({'border': '1px solid #CCC'}); 
                var remarks = $('input#remarks1').val();
                var attendance = $('#attendance option:selected').val();
                var status = $('#status option:selected').val();
                var interview_id = $('input#interview_id').val();
                var stage = $('#stage option:selected').val();

            $('#edit-loader').show();
            $('#edit-button').prop('disabled', true);

            var data = new FormData();
            data.append('idate', idate);
            data.append('itime', itime);
            data.append('emp', emp);
            data.append('remarks', remarks);
            data.append('job_role', job_role);
            data.append('attendance', attendance);
            data.append('status', status);
            data.append('interview_id', interview_id);
            data.append('stage', stage);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/edit-interview",
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#edit-loader').hide();
                    $('#edit-button').prop('disabled', false);

                    if (data['success']) {
                        Swal.fire({
                            text: 'Updated successfully!',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                       window.location.reload();
                    }
                    
                    
                    if (data['err']) {
                        Swal.fire({
                            text: 'Course already exists',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'error',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            });
        }


function DeleteCourse(id) {
    $('#modaldemo3').modal('show');
    $('#course_id1').val(id);
}


function CourseDelete() {
            
var course_id = $('input#course_id1').val();
            $('#del-loader').show();
            $('#del-button').prop('disabled', true);

            var data = new FormData();
            data.append('course_id', course_id);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/delete-course",
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#del-loader').hide();
                    $('#del-button').prop('disabled', false);

                    if (data['success']) {
                        Swal.fire({
                            text: 'Deleted successfully!',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                       window.location.reload();
                    }
                    
                    
                    if (data['err']) {
                        Swal.fire({
                            text: 'Deletion failed !',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'error',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                    }
                }
            });
        }

        function DeleteInterview(id) {
    $('#modaldemo3').modal('show');
    $('#interview_id1').val(id);
}


                  function InterviewDelete() {
            
            var interview_id = $('input#interview_id1').val();
                        $('#del-loader').show();
                        $('#del-button').prop('disabled', true);
            
                        var data = new FormData();
                        data.append('interview_id', interview_id);
                        data.append('_token', '{{ csrf_token() }}');
            
                        $.ajax({
                            type: "POST",
                            url: "/admin/delete-interview",
                            data: data,
                            dataType: "json",
                            contentType: false,
                            processData: false,
                            success: function(data) {
                                $('#del-loader').hide();
                                $('#del-button').prop('disabled', false);
            
                                if (data['success']) {
                                    Swal.fire({
                                        text: 'Deleted successfully!',
                                        closeOnClickOutside: false,
                                        position: 'top-end',
                                        icon: 'success',
                                        toast: true,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                    window.location.reload();
                                   
                                }
                                
                                
                                if (data['err']) {
                                    Swal.fire({
                                        text: 'Deletion failed !',
                                        closeOnClickOutside: false,
                                        position: 'top-end',
                                        icon: 'error',
                                        toast: true,
                                        showConfirmButton: false,
                                        timer: 2000
                                    });
                                }
                            }
                        });
                    }

    </script>
