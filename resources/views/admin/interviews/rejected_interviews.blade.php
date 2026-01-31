@extends('layouts.Admin')

@section('content')

<style>
 
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
  <h6 class="fw-semibold mb-0">Rejected Interviews</h6>

</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <!--<h5 class="card-title mb-0">Rejected Interviews-->
        <!--</h5>-->
        
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

    <div class="col-md-3">
      <label>Job Role</label>
      
      <select name="job_roles[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach($job_roles as $j)
        <option value="{{ $j->id }}" {{ in_array($j->id, request()->job_roles ?? []) ? 'selected' : '' }}>
            {{ $j->title }}
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
      <label>Qualification</label>
      <select name="qualifications[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach(["Bachelor's", "Master's", "PhD", "High School", "Plus Two"] as $qualification)
        <option value="{{ $qualification }}" {{ in_array($qualification, request()->qualifications ?? []) ? 'selected' : '' }}>
            {{ $qualification }}
        </option>
    @endforeach
</select>

    </div>

    <div class="col-md-3">
      <label>Employer</label>
      <select name="employers[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach($employers as $e)
        <option value="{{ $e->id }}" {{ in_array($e->id, request()->employers ?? []) ? 'selected' : '' }}>
            {{ $e->company_name }}
        </option>
    @endforeach
</select>

    </div>

    <div class="col-md-3">
      <label>Experience</label>
      <select name="experiences[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach(['Experienced', 'Fresher'] as $exp)
        <option value="{{ $exp }}" {{ in_array($exp, request()->experiences ?? []) ? 'selected' : '' }}>
            {{ $exp }}
        </option>
    @endforeach
</select>

    </div>

    <div class="col-md-3">
      <label>Interview Stage</label>
      <select name="stages[]" class="select2" multiple>
    <option value="">Choose</option>
    @foreach([1 => 'Interview 1', 2 => 'Interview 2', 3 => 'Interview 3', 4 => 'Interview 4', 5 => 'Interview 5'] as $value => $label)
        <option value="{{ $value }}" {{ in_array($value, request()->stages ?? []) ? 'selected' : '' }}>
            {{ $label }}
        </option>
    @endforeach
</select>

    </div>
    <div class="col-md-3">
      <label>Interview Date From</label>
      <input type="date" name="date_from" class="form-control" value="{{ request('date_from') }}">
    </div>

    <div class="col-md-3">
      <label>Interview Date To</label>
      <input type="date" name="date_to" class="form-control" value="{{ request('date_to') }}">
    </div>

    <div class="col-md-2 align-self-end">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
    <div class="col-md-2 align-self-end">
  
  <button class="btn btn-primary" type="button" onclick="openBulkUpdateModal()">Update Selected</button>

    </div>
    <div class="col-md-2 align-self-end">
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportModal">
            Export
        </button>
    </div>
 
  <!--modal for export-->
    <div class="modal fade" id="exportModal" tabindex="-1" aria-labelledby="exportModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content p-3">
          <h5 class="modal-title mb-3" id="exportModalLabel">Export Students</h5>
          <div class="d-flex justify-content-around">
             <div class="modal-body text-center">
                <a href="{{ route('interview.students.export',array_merge(['type' => 'pdf','status'=> 'Rejected'], request()->all())) }}" class="btn btn-danger">Export as PDF</a>
                <a href="{{ route('interview.students.export', array_merge(['type' => 'excel','status'=> 'Rejected'], request()->all())) }}" class="btn btn-success">Export as Excel</a>
              </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</form>
      </div>

      <div class="card-body">
        <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
          <thead>
            <tr>
              <th scope="col">
                <div class="form-check style-check d-flex align-items-center">
                <input class="form-check-input" type="checkbox" id="selectAll">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    S.L
                  </label>
                </div>
              </th>
              <th scope="col">Reg.No</th>
              <th scope="col">Name</th>
              <th scope="col">Phone Number</th>
              <th scope="col">Date</th>
              <th scope="col">Stage</th>
              <th scope="col">Employer</th>
              <th scope="col">Job Role</th>
              <th scope="col">Attendance</th>
              <th scope="col">Status</th>
       
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

@foreach($interviews as $e)
            <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <input class="form-check-input row-checkbox" type="checkbox" value="{{$e->id}}">
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$e->GetStd->reg_num}}</td>
              <td>{{$e->GetStd->first_name}} {{$e->GetStd->middle_name}} {{$e->GetStd->last_name}}</td>
              <td>{{$e->GetStd->mobile_code}}{{$e->GetStd->mobile}}<br><small>{{$e->GetStd->alternate_mobile}}</small></td>
              <td>{{date("d-m-Y", strtotime($e->interview_date))}}<br> {{date("h:i a", strtotime($e->interview_time))}}</td>
              <td>Interview {{$e->interview_stage}}</td>
              <td>{{$e->GetEmp->company_name}}</td>
              <td>{{$e->GetRole->title}}</td>
              <td>{{$e->attendance}}</td>
              <td>{{$e->status}}</td>
              
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

        


      </div>
    </div>
  </div>

  <!-- Modal Start -->
     
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

                        <div class="col-12 mb-20" id="status-wrapper" style="display: none;">
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


    <div class="modal fade" id="bulkUpdateModal" tabindex="-1" aria-labelledby="bulkUpdateModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content radius-16 bg-base">
      <div class="modal-header py-16 px-24">
        <h1 class="modal-title fs-5" id="bulkUpdateModalLabel">Update Interviews</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-24">

        <div id="selectedRowsPreview" class="mb-3" style="max-height: 200px; overflow-y: auto;">
          <!-- Selected rows preview will be shown here -->
        </div>

        <div class="mb-3">
          <label class="form-label">Attendance</label>
          <select id="bulk_attendance" class="form-select" required>
            <option value="">Choose</option>
            <option value="Attended">Attended</option>
      <option value="Not Attended">Not Attended</option>
          </select>
        </div>

        <div class="mb-3" id="bulk_status_field" style="display: none;">
          <label class="form-label" >Status</label>
          <select id="bulk_status" class="form-select" required>
            <option value="">Choose</option>
            <option value="Pending">Pending</option>
      <option value="Short Listed">Short Listed</option>
      <option value="Placed">Placed</option>
      <option value="Rejected">Rejected</option>
          </select>
        </div>

        <input type="hidden" id="selected_ids_for_update">

        <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
          <button type="button" onclick="confirmBulkUpdate()" class="btn btn-primary border text-md px-48 py-12 radius-8" id="update-button">
            <i id="update-loader" class="fa fa-spinner fa-spin" style="display: none;"></i> Submit
          </button>
        </div>

      </div>
    </div>
  </div>
</div>


    
    <!-- Modal End -->

    @endsection

<script>
        window.addEventListener("load", function() {
            document.getElementById("loader").style.display = "none";
        });
    </script>
    
    <script type="text/javascript">
      
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


                    function openBulkUpdateModal() {
  var selectedIds = [];
  var selectedInfo = '';

  $('.row-checkbox:checked').each(function () {
    var row = $(this).closest('tr');
    var regNo = row.find('td').eq(1).text();
    var name = row.find('td').eq(2).text();
    var jobRole = row.find('td').eq(7).text();

    selectedIds.push($(this).val());
    selectedInfo += `<div class="border p-2 mb-2 rounded">
                      <strong>Reg.No:</strong> ${regNo}<br>
                      <strong>Name:</strong> ${name}<br>
                      <strong>Job Role:</strong> ${jobRole}
                    </div>`;
  });

  if (selectedIds.length === 0) {
    Swal.fire('No Selection', 'Please select at least one interview.', 'warning');
    return;
  }

  $('#selected_ids_for_update').val(selectedIds.join(','));
  $('#selectedRowsPreview').html(selectedInfo);
  $('#bulkUpdateModal').modal('show');
}

function confirmBulkUpdate() {
  var ids = $('#selected_ids_for_update').val().split(',');
  var attendance = $('#bulk_attendance').val();
  var status = $('#bulk_status').val();

  if (!attendance || !status) {
    Swal.fire('Required', 'Please select both Attendance and Status.', 'warning');
    return;
  }

  $('#update-loader').show();
  $('#update-button').prop('disabled', true);

  $.ajax({
    url: '{{ route("bulk.update.interview") }}',
    type: 'POST',
    data: {
      ids: ids,
      attendance: attendance,
      status: status,
      _token: '{{ csrf_token() }}'
    },
    success: function (response) {
      $('#update-loader').hide();
      $('#update-button').prop('disabled', false);
      $('#bulkUpdateModal').modal('hide');

      if (response.success) {
        Swal.fire('Updated!', 'Selected interviews updated.', 'success');
        setTimeout(() => {
          location.reload();
        }, 1500);
      } else {
        Swal.fire('Error!', 'Something went wrong.', 'error');
      }
    }
  });
}









    </script>