@extends('layouts.Admin')

@section('content')

  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Open Job Roles</h6>

</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <h5 class="card-title mb-0">Open Job Roles
<button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" onclick="window.location.href='/admin/add-job-role'">Add New</button>
        </h5><br>

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
    <div class="col-md-2 mt-3">
            <label for="created_from">Created From</label>
            <input type="date" name="created_from" class="form-control" value="{{ request('created_from') }}">
        </div>

        <div class="col-md-2 mt-3">
            <label for="created_to">Created To</label>
            <input type="date" name="created_to" class="form-control" value="{{ request('created_to') }}">
        </div>

    

    <div class="col-md-2 align-self-end">
      <button type="submit" class="btn btn-primary w-100">Filter</button>
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
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    S.L
                  </label>
                </div>
              </th>
              <th scope="col">Company</th>
              <th scope="col">Mail ID</th>
              <th scope="col">Contact Num</th>
              <th scope="col">Location</th>
              <th scope="col">Job Title</th>
              <!-- <th scope="col">Job Role</th> -->
              <th scope="col">Vacancy Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

@foreach($roles as $u)
    <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$u->GetCom->company_name}}</td>
              <td>{{$u->email}}</td>
              <td>{{$u->contact_code}}{{$u->contact_num}}</td>
              <td>{{$u->location}}</td>
              <td>{{$u->title}}</td>
              <!-- <td></td> -->
              <td>{{$u->status}}</td>
              <td>
                <!-- <a href="javascript:void(0)" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a> -->
                <a href="/admin/edit-job/{{$u->id}}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                <!-- <a onclick="DeleteJob('{{$u->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                </a> -->
              </td>
            </tr>
@endforeach

            
          </tbody>
        </table>
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

    <script type="text/javascript">
      
     
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

    </script>