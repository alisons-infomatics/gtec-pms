@extends('layouts.Admin')

@section('content')
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Edit Job Role</h6>
  </div>

  <div class="row gy-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Edit Job Role</h5>
        </div>

        <div class="card-body">
          <form class="row gy-3 needs-validation" novalidate>
            <div class="col-md-4">
              <label class="form-label">Company *</label>
              <select id="company" class="form-control" required>
                <option value="">Choose</option>
                @foreach($employers as $emp)
                <option value="{{ $emp->id }}" @if($emp->id == $job->company_id) selected @endif>{{ $emp->company_name }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Email ID *</label>
              <input type="email" id="email" class="form-control" required value="{{ $job->email }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Location *</label>
              <input type="text" id="loc" class="form-control" required value="{{ $job->location }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Title *</label>
              <input type="text" id="title" class="form-control" required value="{{ $job->title }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Contact Person *</label>
              <input type="text" id="cperson" class="form-control" required value="{{ $job->contact_person }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Contact Number *</label>
              <div class="d-flex gap-2">
                <select id="mcode" class="form-select" required>
                  <option value="91" selected>+91</option>
                </select>
                <input type="number" id="mobile" class="form-control" required value="{{ $job->contact_num }}">
              </div>
            </div>

            <div class="col-md-4">
              <label class="form-label">Gender *</label>
              <select id="gender" class="form-select" required>
                <option value="Male" @if($job->gender=='Male') selected @endif>Male</option>
                <option value="Female" @if($job->gender=='Female') selected @endif>Female</option>
                <option value="Any" @if($job->gender=='Any') selected @endif>Any</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Qualification *</label>
              @php $qualifications = explode(',', $job->qualification); @endphp
              <select id="jquali" multiple required>
                <option value="High School" @if(in_array('High School', $qualifications)) selected @endif>High School</option>
                <option value="Bachelor's" @if(in_array("Bachelor's", $qualifications)) selected @endif>Bachelor's</option>
                <option value="Master's" @if(in_array("Master's", $qualifications)) selected @endif>Master's</option>
                <option value="PhD" @if(in_array("PhD", $qualifications)) selected @endif>PhD</option>
              </select>
            </div>

            <div class="col-md-4">
              <label class="form-label">Experience *</label>
              @php $exps = explode(',', $job->experience); @endphp
              <select id="jexp" multiple required>
                <option value="Fresher" @if(in_array('Fresher', $exps)) selected @endif>Fresher</option>
                <option value="Experienced" @if(in_array('Experienced', $exps)) selected @endif>Experienced</option>
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Department *</label>
              <select id="jdept" multiple required>
                @foreach($dept as $d)
                  <option value="{{ $d->id }}" @if(!empty($job) && in_array($d->id, is_array($job->department) ? $job->department : explode(',', $job->department))) selected @endif>{{ $d->department }}</option>
                @endforeach
              </select>
            </div>

            <div class="col-md-6">
              <label class="form-label">Preferred Job Roles *</label>
              <select id="job_roles" multiple required></select>
            </div>

            <div class="col-md-6">
              <label class="form-label">No.Of Vacancies *</label>
              <input type="number" id="vaccancy" class="form-control" required value="{{ $job->vacancy }}">
            </div>

            <div class="col-md-6">
              <label class="form-label">Remarks</label>
              <input type="text" id="remarks" class="form-control" value="{{ $job->remarks }}">
            </div>

            <div class="col-md-4">
              <label class="form-label">Status *</label>
              <select id="status" class="form-select" required>
                <option value="Open" @if($job->status=='Open') selected @endif>Open</option>
                <option value="Closed" @if($job->status=='Closed') selected @endif>Closed</option>
              </select>
            </div>

            <div class="col-12">
              <button class="btn btn-primary-600" type="button" onclick="EditRole()" id="add-button">
                <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i> Submit
              </button>
            </div>

          </form>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script type="text/javascript">

// Your Same EditRole() function without any change
function EditRole() {
    var company = $('#company').val();
    var email = $('#email').val();
    var loc = $('#loc').val();
    var title = $('#title').val();
    var cperson = $('#cperson').val();
    var mcode = $('#mcode').val();
    var mobile = $('#mobile').val();
    var gender = $('#gender').val();
    var quali = $('#jquali').val();
    var jexp = $('#jexp').val();
    var jdept = $('#jdept').val();
    var job_roles = $('#job_roles').val();
    var vaccancy = $('#vaccancy').val();
    var remarks = $('#remarks').val();
    var status = $('#status').val();

    $('#add-loader').show();
    $('#add-button').prop('disabled', true);

    var data = new FormData();
    data.append('company', company);
    data.append('email', email);
    data.append('loc', loc);
    data.append('title', title);
    data.append('cperson', cperson);
    data.append('mcode', mcode);
    data.append('mobile', mobile);
    data.append('gender', gender);
    data.append('quali', quali);
    data.append('jexp', jexp);
    data.append('jdept', jdept);
    data.append('job_roles', job_roles);
    data.append('vaccancy', vaccancy);
    data.append('remarks', remarks);
    data.append('status', status);
    data.append('job_id', '{{ $job->id }}');
    data.append('_token', '{{ csrf_token() }}');

    $.ajax({
        type: 'POST',
        url: '/admin/job-edit',
        data: data,
        dataType: 'json',
        contentType: false,
        processData: false,
        success: function(response) {
            $('#add-loader').hide();
            $('#add-button').prop('disabled', false);

            if (response.success) {
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
            } else {
                Swal.fire({
                            text: 'Something went wrong',
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

// Selectize part
$(document).ready(function () {
    $('#jquali').selectize({
        plugins: ['remove_button'],
        placeholder: 'Choose Qualification'
    });

    $('#jexp').selectize({
        plugins: ['remove_button'],
        placeholder: 'Choose Experience'
    });

    $('#jdept').selectize({
        plugins: ['remove_button'],
        placeholder: 'Choose Department',
        onChange: function () {
            let deptIds = this.getValue();
            GetCrs(deptIds);
        }
    });

    $('#job_roles').selectize({
        plugins: ['remove_button'],
        placeholder: 'Choose Job Roles'
    });

    // Pre-load Job Roles
    setTimeout(function () {
        let selectedDepts = $('#jdept')[0].selectize.getValue();
        let selectedJobRoles = @json($selectedJobRoles ?? []);

        GetCrs(selectedDepts, selectedJobRoles);
    }, 400);
});

// Get Courses & Roles
function GetCrs(deptIds, selectedJobRoles = []) {
    if (!Array.isArray(deptIds)) {
        deptIds = deptIds.split(','); // 👉 split string into array
    }

    let jobRolesSelectize = $('#job_roles')[0].selectize;
    jobRolesSelectize.clear();
    jobRolesSelectize.clearOptions();

    

    if (deptIds.length > 0) {
        $.ajax({
            url: "{{ route('getCoursesAndRoles2') }}",
            type: "GET",
            data: { dept_id: deptIds },
            traditional: false,  // Important: send as array not string
            success: function (response) {
                if (response.job_roles?.length) {
                    response.job_roles.forEach(function (role) {
                        jobRolesSelectize.addOption({
                            value: role.id.toString(),
                            text: role.job_role
                        });
                    });

                    jobRolesSelectize.refreshOptions(false);

                    if (selectedJobRoles.length) {
                        jobRolesSelectize.setValue(selectedJobRoles.map(String));
                        jobRolesSelectize.refreshItems();
                    }
                }
            },
            error: function () {
                alert("❌ Failed to fetch job roles!");
            }
        });
    }
}


</script>
@endpush
