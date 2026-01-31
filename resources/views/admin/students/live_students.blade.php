@extends('layouts.Admin')

@section('content')
<style>
    table {
    table-layout: fixed;
    width: 100%;
}

.c_select {
    padding: 7px 10px;
    height: auto;
    font-size: 13px;
    border-radius: 0;
}

#loader {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: #fff; /* white background */
    display: flex;
    align-items: center;
    justify-content: center;
    z-index: 99999;
}

/* Spinner style */
.spinner {
    border: 6px solid #f3f3f3;
    border-top: 6px solid #3498db;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0%   { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<div id="loader">
    <div class="spinner"></div>
</div>


  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Live Students</h6>

</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <h5 class="card-title mb-0">Live Students
<!-- <button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" onclick="window.location.href='/admin/add-student'">Add New</button> -->
        </h5>

<br>

<form method="GET" action="{{ url()->current() }}" class="mb-4">
  <div class="row g-3">
    <div class="col-md-3">
      <label>Department</label>
      
      <select name="departments[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach($depts as $d)
        <option value="{{ $d->id }}" {{ in_array($d->id, request()->departments ?? []) ? 'selected' : '' }}>
            {{ $d->department }}
        </option>
    @endforeach
</select>

    </div> 
    
    <!--<div class="col-md-3">-->
    <!--  <label> Department Courses</label>-->
    <!--    <select name="courses[]" class="select2" multiple>-->
    <!--        <option value="">Choose</option>-->
    <!--        @foreach($crs as $cr)-->
    <!--            <option value="{{ $cr->id }}" {{ in_array($cr->id, request()->courses ?? []) ? 'selected' : '' }}>-->
    <!--                {{ $cr->course }}-->
    <!--            </option>-->
    <!--        @endforeach-->
    <!--    </select>-->
    <!--</div>-->
    <div class="col-md-3">
          <label> Department Courses</label>
          <input type="hidden" name="exclude_courses" value="0">
          <input type="checkbox" name="exclude_courses" id="exclude_courses" value="1" {{ old('exclude_courses', request()->exclude_courses) ? 'checked' : '' }} class="form-check-input">Exclude
        <select name="courses[]" class="select2" multiple>
            <option value="">Choose</option>
            @foreach($crs as $cr)
                <option value="{{ $cr->id }}" {{ in_array($cr->id, request()->courses ?? []) ? 'selected' : '' }}>
                    {{ $cr->course }}
                </option>
            @endforeach
        </select>
    </div>

    <div class="col-md-3">
      <label>Job Role</label>
      
      <select name="job_roles[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach($job_roles as $j)
        <option value="{{ $j->id }}" {{ in_array($j->id, request()->job_roles ?? []) ? 'selected' : '' }}>
            {{ $j->job_role }}
        </option>
    @endforeach
</select>

    </div>

    <div class="col-md-3">
      <label>Gender</label>
      
      <select name="genders[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach(['Male', 'Female', 'Any'] as $gender)
        <option value="{{ $gender }}" {{ in_array($gender, request()->genders ?? []) ? 'selected' : '' }}>
            {{ $gender }}
        </option>
    @endforeach
</select>

    </div>

  <div class="col-md-3">
    <label for="qualifications_select">Qualification</label>
    <select name="qualifications[]" id="qualifications_select" class="select2" multiple>
        <option value="High School">High School</option>
        <option value="Plus Two">Plus Two</option>
        <option value="Bachelor's">Bachelor's</option>
        <option value="Diploma">Diploma</option>
        <option value="Master's">Master's</option>
        <option value="PhD">PhD</option>
    </select>
</div>

<div class="col-md-3" id="courses_wrapper" style="display: none;">
    <label for="courses_select">Qualification Courses</label>
    <select name="quali_courses[]" id="courses_select"  multiple></select>
</div>


{{-- <div class="col-md-3">
      <label>Interview Order</label>
   <select name="stages" class="form-select c_select">
    <option value="" {{ request('stages') == '' ? 'selected' : '' }}>Choose</option>
    @foreach([1 => 'Interview 1', 2 => 'Interview 2', 3 => 'Interview 3', 4 => 'Interview 4', 5 => 'Interview 5'] as $value => $label)
        <option value="{{ $value }}" {{ request('stages') == $value ? 'selected' : '' }}>{{ $label }}</option>
    @endforeach
    </select>
</div> --}}

    
    {{-- <div class="col-md-3">
      <label>Interview not taken</label>
      <select name="exp[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach([
        45 => '1st Interview',
        30 => '2nd Interview',
        15 => '3rd Interview',
        '0' => 'Not provided any interview'
    ] as $value => $label)
        <option value="{{ $value }}" {{ request('exp') == $value ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>


    </div> --}}

    <div class="col-md-3">
        <label>Interview</label>
        <select name="interview_filter" class="select2">
            <option value="">Choose</option>
            @foreach([
                15 => '1st Interview given within 15 days',
                '15+' => '1st Interview given without timeline',
                30 => '2nd Interview given within 30 days',
                '30+' => '2nd Interview given without timeline',
                45 => '3rd Interview given within 45 days',
                '45+' => '3rd Interview given without timeline',
                'no_15' => 'No interview given within 15 days',
                'no_30' => 'No first or second interview given within 30 days',
                'no_45' => 'No first, second or third interview given within 45 days',
            ] as $value => $label)
                <option value="{{ $value }}" {{ request('interview_filter') == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    </div>

        <div class="col-md-2 mt-3">
            <label for="created_from ">Created From</label>
            <input type="date" name="created_from" class="form-control c_select" value="{{ request('created_from') }}">
        </div>

        <div class="col-md-2 mt-3">
            <label for="created_to">Created To</label>
            <input type="date" name="created_to" class="form-control c_select" value="{{ request('created_to') }}">
        </div>
        
        
        
    <div class="col-md-2 align-self-end">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
    <div class="col-md-2 align-self-end">
        <button type="button"
            class="btn btn-primary"
            onclick="openInterviewModal()">
            Create Interview
        </button>
    </div>
 
  <div class="col-md-3 align-self-end">
      <button type="button" class="btn btn-primary w-100" onclick="openStatusModal()">Bulk Status Update</button>
</div>


</form>
<div class="col-md-2 align-self-end">
    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
        Export
    </button>
</div>
  </div>
  <!--modal for export-->
<div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content p-3">
      <h5 class="modal-title mb-3" id="exportModalLabel">Export Students</h5>
      <div class="d-flex justify-content-around">
         <div class="modal-body text-center">
            <a href="{{ route('students.export',array_merge(['type' => 'pdf'], request()->all())) }}" class="btn btn-danger">Export as PDF</a>
            <a href="{{ route('students.export', array_merge(['type' => 'excel'], request()->all())) }}" class="btn btn-success">Export as Excel</a>
          </div>
      </div>
    </div>
  </div>
</div>

      </div>

      <div class="card-body">
        <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
          <thead>
            <tr>
               <!--<th>-->
               <!--   <input type="checkbox" id="select-all"> S.L-->
               <!-- </th>-->
               
                    <th>
                      <div class="form-check">
                        <input type="checkbox" class="form-check-input form-check-input me-3 mt-1" id="select-all">
                        <label class="form-check-label" for="select-all">S.L</label>
                      </div>
                    </th>

            <!--<th></th>-->
              <th>Name</th>
              <th>Department /<br> Course</th>
              <th>Contact Num</th>
              <th>Location</th>
              <th>REG.No</th>
              <th>Approved On</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
@php

$my_roles=DB::table('user_types')->where('id',auth()->guard('admin')->user()->user_type)->first();
$rulesArray = explode(',', $my_roles->rules);
@endphp
@foreach($students as $u)
    <tr>
        
           <td>
  <div class="form-check">
    <input type="checkbox"
           class="form-check-input student-checkbox me-3 mt-1"
           value="{{ $u->id }}"
           data-name="{{ $u->first_name }} {{ $u->middle_name }} {{ $u->last_name }}"
           data-contact="{{ $u->mobile_code }}{{ $u->mobile }}"
           id="student-{{ $u->id }}">
    <label class="form-check-label" for="student-{{ $u->id }}">
      {{ $loop->iteration }}
    </label>
  </div>
</td>

            <!--<td><img style="width : 50px;" src="@if($u->photo!='') {{asset($u->photo)}} @else /img/usr.jpg @endif" alt=""></td>-->
              <td><small>{{$u->first_name}} {{$u->middle_name}} {{$u->last_name}}</small></td>
              <td><small>{{$u->GetDept->department ?? $u->dept_text}} / <br> {{$u->GetCrs->course ?? ''}} </small></td>
              <td><small>{{$u->mobile_code}} {{$u->mobile}}</small><br><small>{{ !empty($u->alternate_mobile) ? $u->mobile_code . ' ' . $u->alternate_mobile : '' }}
                </small></td>
                <td><small>{{$u->place ?? " "}}</small></td>
              <td>{{$u->reg_num}}</td>
              <td>{{date("d-m-Y", strtotime($u->approve_date))}}</td>
              <td>
                   @if(in_array('112', $rulesArray))
              <a href="/admin/view-student/{{$u->id}}" target="_blank" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a>
                <a href="/admin/edit-student/{{$u->id}}" target="_blank" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                @endif
                 @if(in_array('113', $rulesArray))
                <a onclick="DeleteStudent('{{$u->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                </a>
                @endif
              </td>
            </tr>
@endforeach

            
          </tbody>
        </table>
      </div>
    </div>
  </div>
<div class="modal fade" id="modaldemo1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">
            <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Interview</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-24">
                <form id="interviewForm">
                    <input type="hidden" id="selected_students" name="selected_students">

                    <div class="mb-20">
                        <h6 class="text-primary mb-2">Selected Students</h6>
                        <div id="selected-student-list" class="list-group"
                             style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px;">
                            <!-- JS will populate -->
                        </div>
                    </div>

                    <div class="row">

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Date</label>
                            <input type="date" class="form-control radius-8" id="idate" name="interview_date" required>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Interview Time</label>
                            <input type="time" class="form-control radius-8" id="itime" name="interview_time" required>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Employer Name</label>
                            <select id="emp" name="employer_id" class="form-control radius-8" onchange="getJobRole(this.value)" required>
                                <option value="">Choose</option>
                                @foreach($employers as $e)
                                    <option value="{{ $e->id }}">{{ $e->company_name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Job Role</label>
                            <select id="job_role" name="job_role_id" class="form-control radius-8" required>
                                <option value="">Choose</option>
                            </select>
                        </div>

                        <div class="col-12 mb-20">
                            <label class="form-label fw-semibold text-primary-light text-sm mb-8">Remarks</label>
                            <input type="text" class="form-control radius-8" id="remarks" name="remarks" placeholder="Enter Remarks">
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                            <button type="button" onclick="AddInterview()" class="btn btn-primary" id="add-button">
    <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
    Submit
</button>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">
            <div class="modal-header py-16 px-24 border-bottom">
                <h5 class="modal-title" id="statusModalLabel">Bulk Status Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-24">
                <form id="statusForm">
                    <input type="hidden" id="status_selected_students" name="selected_students">

                    <div class="mb-3">
                        <h6 class="text-primary mb-2">Selected Students</h6>
                        <div id="status-student-list" class="list-group"
                             style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px;">
                            <!-- JS will populate -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Select Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Choose</option>
                            <option value="Live">Live</option>
                            <option value="No Need">No Need</option>
                            <option value="No Response">No Response</option>
                            @if(auth('admin')->check() && auth('admin')->user()->user_type == 1)
                                <option value="Self Placed">Self Placed</option>
                                <option value="Placed">Placed</option>
                            @endif
                            <option value="Blocked">Blocked</option>
                            <!-- Add more if needed -->
                        </select>
                    </div>
                    <div class="col-md-12" id="status_remarks_field" style="display: none;">
                        <label class="form-label">Blocked Status Note *</label>
                        <textarea class="form-control" id="status_remarks" name="status_remarks" rows="3" placeholder="Any remarks..."></textarea>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" onclick="updateStatus()" class="btn btn-primary">
                            <i id="status-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                            Update Status
                        </button>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="user_id1">
                                
                            Do you want to delete this student ?                        
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="UserDelete()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="del-button"> <i id="del-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal End -->
    
    @endsection
    
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        window.addEventListener("load", function() {
            document.getElementById("loader").style.display = "none";
        });
    </script>

    <script type="text/javascript">
    // Global memory for selected students
    const selectedStudentsMap = new Map(); // { id: { name, contact } }

    // Track selection changes
    document.addEventListener('change', function (e) {
        if (e.target.classList.contains('student-checkbox')) {
            const id = e.target.value;
            const name = e.target.getAttribute('data-name');
            const contact = e.target.getAttribute('data-contact');

            if (e.target.checked) {
                selectedStudentsMap.set(id, { name, contact });
            } else {
                selectedStudentsMap.delete(id);
            }
        }
    });

    // Re-check checkboxes on page change (use this if you're paginating manually or with DataTables)
    function restoreCheckboxState() {
        document.querySelectorAll('.student-checkbox').forEach(cb => {
            cb.checked = selectedStudentsMap.has(cb.value);
        });
    }
   
  

    $(document).ready(function () {
        $('#select-all').on('change', function() {
    const isChecked = this.checked;

    $('.student-checkbox').each(function() {
        $(this).prop('checked', isChecked);

        const id = this.value;
        const name = $(this).data('name');
        const contact = $(this).data('contact');

        if (isChecked) {
            selectedStudentsMap.set(id, { name, contact });
        } else {
            selectedStudentsMap.delete(id);
        }
    });
});

        
        $('#status').on('change', function () {
            
            const selected = $(this).val();
            
            if (selected === 'Blocked') {
                $('#status_remarks_field').show();
                $('#status_remarks').attr('required', 'required');
            } else {
                $('#status_remarks_field').hide();
                $('#status_remarks').removeAttr('required');
                $('#status_remarks').val(''); // Optional: clear the textarea
            }
        });

        // Optional: Run on page load if editing
        if ($('#status').val() === 'Blocked') {
            $('#status_remarks_field').show();
            $('#status_remarks').attr('required', 'required');
        }
    });


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
     
function DeleteStudent(id) {
    $('#modaldemo3').modal('show');
    $('#user_id1').val(id);
}


function UserDelete() {
            
var user_id = $('input#user_id1').val();
            $('#del-loader').show();
            $('#del-button').prop('disabled', true);

            var data = new FormData();
            data.append('user_id', user_id);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/delete-student",
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
        
// function openInterviewModal() {
//     let selected = [];
//     let studentListHTML = '';

//     document.querySelectorAll('.student-checkbox:checked').forEach(cb => {
//         selected.push(cb.value);
//         const name = cb.getAttribute('data-name');
//         const contact = cb.getAttribute('data-contact');

//         studentListHTML += `<div class="list-group-item d-flex justify-content-between">
//                                 <span>${name}</span>
//                                 <small class="text-muted">${contact}</small>
//                             </div>`;
//     });

//     if (selected.length === 0) {
//         alert("Please select at least one student.");
//       // const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modaldemo1'));
//         //modal.hide();
        
//         return;
//     }
    
//     $('#modaldemo1').modal('show');

//     document.getElementById('selected_students').value = selected.join(',');
//     document.getElementById('selected-student-list').innerHTML = studentListHTML;
// }

// // Optional: clear student list on modal close
// document.getElementById('modaldemo1').addEventListener('hidden.bs.modal', () => {
//     document.getElementById('selected-student-list').innerHTML = '';
//     document.getElementById('selected_students').value = '';
// });
function openInterviewModal() {
    if (selectedStudentsMap.size === 0) {
        alert("Please select at least one student.");
        return;
    }

    let selected = [];
    let studentListHTML = '';

    selectedStudentsMap.forEach((data, id) => {
        selected.push(id);
        studentListHTML += `<div class="list-group-item d-flex justify-content-between">
                                <span>${data.name}</span>
                                <small class="text-muted">${data.contact}</small>
                            </div>`;
    });

    $('#modaldemo1').modal('show');
    document.getElementById('selected_students').value = selected.join(',');
    document.getElementById('selected-student-list').innerHTML = studentListHTML;
}



function AddInterview() {
    // Clear previous messages (optional)
    $('#add-loader').show();
    $('#add-button').prop('disabled', true);

    // Collect values
    let student_ids = $('#selected_students').val().split(',');
    let idate = $('#idate').val();
    let itime = $('#itime').val();
    let emp = $('#emp').val();
    let job_role = $('#job_role').val();
    let remarks = $('#remarks').val();

    // Validate
    if (student_ids.length === 0 || !idate || !itime || !emp || !job_role) {
        alert("All fields are required!");
        $('#add-loader').hide();
        $('#add-button').prop('disabled', false);
        return;
    }

    // AJAX request
    $.ajax({
        url: "{{ url('/admin/add-interviews') }}",
        method: "POST",
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        contentType: "application/json",
        data: JSON.stringify({
            student_ids: student_ids,
            idate: idate,
            itime: itime,
            emp: emp,
            job_role: job_role,
            remarks: remarks
        }),
        success: function (res) {
            if (res.success) {
                
                        Swal.fire({
                            text: 'Interview added successfully!',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
                $('#modaldemo1').modal('hide');
                setTimeout(() => {
                    location.reload();
                }, 500);
            }
            else {
                alert("Something went wrong.");
            }
        },
        error: function (err) {
            console.error(err);
            alert("Server error. Please try again.");
        },
        complete: function () {
            $('#add-loader').hide();
            $('#add-button').prop('disabled', false);
        }
    });
}


function openStatusModal() {
    if (selectedStudentsMap.size === 0) {
        alert("Please select at least one student.");
        return;
    }

    let studentListHTML = '';
    let selected = [];

    selectedStudentsMap.forEach((data, id) => {
        selected.push(id);
        studentListHTML += `<div class="list-group-item d-flex justify-content-between">
                                <span>${data.name}</span>
                                <small class="text-muted">${data.contact}</small>
                            </div>`;
    });

    document.getElementById('status_selected_students').value = selected.join(',');
    document.getElementById('status-student-list').innerHTML = studentListHTML;

    $('#statusModal').modal('show');
}


function updateStatus() {
    const selectedStudents = document.getElementById('status_selected_students').value;
    // alert(selectedStudents);
    const status = document.getElementById('status').value;
    
    if (!status) {
        alert("Please select a status.");
        return;
    }

    document.getElementById('status-loader').style.display = 'inline-block';
    const status_remarks = document.getElementById('status_remarks').value;

    $.ajax({
        url: '/admin/bulk-update-student-status', // set your actual endpoint here
        method: 'POST',
        data: {
            selected_students: selectedStudents,
            status: status,
            status_remarks:status_remarks,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            document.getElementById('status-loader').style.display = 'none';
            $('#statusModal').modal('hide');
            Swal.fire({
                            text: 'Status updated successfully !',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
            location.reload();
        },
        error: function () {
            document.getElementById('status-loader').style.display = 'none';
            alert("Something went wrong.");
        }
    });
}


    </script>
    

