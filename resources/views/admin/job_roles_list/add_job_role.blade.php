@extends('layouts.Admin')

@section('content')
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add Job Roles</h6>
  </div>

  <div class="row gy-4">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-header">
          <h5 class="card-title mb-0">Add Job Roles</h5>
        </div>
        <div class="card-body">
          <form class="row gy-3 needs-validation" id="jobForm" novalidate>
            <div class="col-md-4">
              <label class="form-label">Company *</label>
              <select id="company" class="form-control" required onchange="setCompanyDetails()">
    <option value="">Choose</option>
    @foreach($employers as $emp)
        <option 
            value="{{ $emp->id }}" 
            data-email="{{ $emp->email }}" 
            data-location="{{ $emp->address }}">
            {{ $emp->company_name }}
        </option>
    @endforeach
</select>

            </div>
            <div class="col-md-4">
              <label class="form-label">Email ID *</label>
              <input class="form-control" type="email" id="email" required>
            </div>
            <div class="col-md-4">
              <label class="form-label">Location *</label>
              <input type="text" id="loc" class="form-control" required>
            </div>

            <div id="roles-wrapper"></div>

            <div class="col-12">
              <button type="button" class="btn btn-sm btn-outline-primary" id="add-role-btn">+ Add Role</button>
            </div>

            <div class="col-12 mt-3">
              <button class="btn btn-primary" type="button" onclick="submitRoles()">Submit</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Hidden Template -->
<div id="role-template" style="display: none;">
  <div class="role-block border rounded p-3 mb-4 position-relative">
    <button type="button" class="btn btn-danger btn-sm position-absolute top-0 end-0 m-2 remove-role-btn">X</button>
    <div class="row g-3">
      <div class="col-md-4">
        <label class="form-label">Title *</label>
        <input type="text" name="title[]" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Contact Person *</label>
        <select name="cperson[]" class="form-control cperson" required>
  <option value="">Choose</option>
</select>

      </div>
      <div class="col-md-4">
        <label class="form-label">Contact Number *</label>
        <div class="d-flex gap-2">
          <select name="mcode[]" class="form-select" required>
            <option value="91">+91</option>
          </select>
          <input type="number" name="mobile[]" class="form-control contact-mobile" required>

        </div>
      </div>
      <div class="col-md-4">
        <label class="form-label">Gender *</label>
        <select name="gender[]" class="form-control" required>
          <option value="Male">Male</option>
          <option value="Female">Female</option>
          <option value="Any">Any</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Qualification *</label>
        <select name="quali[]" class="jquali" multiple required>
          <option value="High School">High School</option>
          <option value="Plus Two">Plus Two</option>
          <option value="Bachelor's">Bachelor's</option>
          <option value="Master's">Master's</option>
          <option value="PhD">PhD</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Experience *</label>
        <select name="jexp[]" class="jexp" multiple required>
          <option value="Fresher">Fresher</option>
          <option value="Experienced">Experienced</option>
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Department *</label>
        <select name="jdept[][]" class="jdept" multiple required>
          @foreach($dept as $d)
            <option value="{{$d->id}}">{{$d->department}}</option>
          @endforeach
        </select>
      </div>
      <div class="col-md-4">
        <label class="form-label">Preferred Job Roles *</label>
        <select name="job_roles[][]" class="job_roles" multiple required></select>
      </div>
      <div class="col-md-4">
        <label class="form-label">No. of Vacancies *</label>
        <input type="number" name="vaccancy[]" class="form-control" required>
      </div>
      <div class="col-md-4">
        <label class="form-label">Remarks</label>
        <input type="text" name="remarks[]" class="form-control">
      </div>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>


$(document).ready(function () {
    addNewRoleBlock();
    $('#add-role-btn').on('click', function () {
        addNewRoleBlock();
    });

    function addNewRoleBlock() {
    const $newBlock = $($('#role-template').html());
    $('#roles-wrapper').append($newBlock);
    initializeSelectize($newBlock);

    $newBlock.find('.remove-role-btn').click(function () {
        $newBlock.remove();
    });

    const contactPersonSelect = $newBlock.find('.cperson');
    const contactMobileInput = $newBlock.find('.contact-mobile');

    // Populate contact person based on selected company
    const selectedEmployerId = $('#company').val();

    if (selectedEmployerId) {
        // fetch contact persons for selected employer
        $.ajax({
            url: '{{ route("getEmployerContacts") }}',
            data: { employer_id: selectedEmployerId },
            success: function (data) {
                contactPersonSelect.empty().append('<option value="">Choose</option>');
                data.forEach(function (contact) {
                    contactPersonSelect.append(
                        `<option value="${contact.contact_person}" data-mobile="${contact.mobile}">${contact.contact_person}</option>`
                    );
                });
            }
        });
    }

    // Auto-fill mobile number when contact person is selected
    contactPersonSelect.on('change', function () {
        const selectedMobile = $(this).find('option:selected').data('mobile') || '';
        contactMobileInput.val(selectedMobile);
    });
}


    function initializeSelectize(wrapper) {
        wrapper.find('.jquali').selectize({
            plugins: ['remove_button'],
            placeholder: 'Choose Qualification'
        });

        wrapper.find('.jexp').selectize({
            plugins: ['remove_button'],
            placeholder: 'Choose Experience'
        });

        wrapper.find('.job_roles').selectize({
            plugins: ['remove_button'],
            placeholder: 'Choose Job Roles'
        });

        wrapper.find('.jdept').selectize({
            plugins: ['remove_button'],
            placeholder: 'Choose Department',
            onChange: function (val) {
                const currentBlock = this.$input.closest('.role-block');
                const roleSelect = currentBlock.find('.job_roles').first();
                if (roleSelect.length > 0 && roleSelect[0].selectize) {
                    GetCrs(val, roleSelect[0]);
                }
            }
        });
        
        
        const companySelect = $('#company');
const contactPersonSelect = wrapper.find('.cperson');
const contactMobileInput = wrapper.find('.contact-mobile');

companySelect.on('change', function () {
    const employerId = $(this).val();
    if (!employerId) return;

    $.ajax({
        url: '{{ route("getEmployerContacts") }}',
        data: { employer_id: employerId },
        success: function (data) {
            contactPersonSelect.empty().append('<option value="">Choose</option>');
            data.forEach(function (contact) {
                contactPersonSelect.append(`<option value="${contact.contact_person}" data-mobile="${contact.mobile}">${contact.contact_person}</option>`);
            });
        }
    });
});

// Auto-fill mobile when contact person is selected
contactPersonSelect.on('change', function () {
    const selectedMobile = $(this).find('option:selected').data('mobile') || '';
    contactMobileInput.val(selectedMobile);
});

        
        
        
        
        
        
        
        
        
        
    }

    function GetCrs(deptIds, roleSelectElement) {
        if (!Array.isArray(deptIds)) {
            deptIds = [deptIds];
        }
        const jobRolesSelectize = roleSelectElement.selectize;
        jobRolesSelectize.clear();
        jobRolesSelectize.clearOptions();

        $.ajax({
            url: "{{ route('getCoursesAndRoles2') }}",
            type: "GET",
            data: { dept_id: deptIds },
            success: function (response) {
                if (response.job_roles?.length > 0) {
                    response.job_roles.forEach(function (role) {
                        jobRolesSelectize.addOption({
                            value: String(role.id),
                            text: role.job_role
                        });
                    });
                    jobRolesSelectize.refreshOptions(false);
                }
            },
            error: function () {
                alert("❌ Failed to load job roles");
            }
        });
    }

    // window.submitRoles = function () {
    //     const formData = new FormData();
        
    //     formData.append('company', $('#company').val());
    //     formData.append('email', $('#email').val());
    //     formData.append('loc', $('#loc').val());

    //     let totalRoles = $('.role-block').length;


    //     if (totalRoles === 1) {
    //         alert("Please add at least one job role before submitting!");
    //         return;
    //     }

    //     $('.role-block').each(function (index) {
    //         const block = $(this);
    //         formData.append(`title[${index}]`, block.find('[name="title[]"]').val());
    //         formData.append(`cperson[${index}]`, block.find('[name="cperson[]"]').val());
    //         formData.append(`mcode[${index}]`, block.find('[name="mcode[]"]').val());
    //         formData.append(`mobile[${index}]`, block.find('[name="mobile[]"]').val());
    //         formData.append(`gender[${index}]`, block.find('[name="gender[]"]').val());
    //         formData.append(`vaccancy[${index}]`, block.find('[name="vaccancy[]"]').val());
    //         formData.append(`remarks[${index}]`, block.find('[name="remarks[]"]').val());

    //         const quali = block.find('.jquali')[0]?.selectize?.getValue() || [];
    //         const jexp = block.find('.jexp')[0]?.selectize?.getValue() || [];
    //         const jdept = block.find('.jdept')[0]?.selectize?.getValue() || [];
    //         const jobRoles = block.find('.job_roles')[0]?.selectize?.getValue() || [];

    //         formData.append(`quali[${index}]`, JSON.stringify(quali));
    //         formData.append(`jexp[${index}]`, JSON.stringify(jexp));
    //         formData.append(`jdept[${index}]`, JSON.stringify(jdept));
    //         formData.append(`job_roles[${index}]`, JSON.stringify(jobRoles));
    //     });

    //     formData.append('_token', '{{ csrf_token() }}');
    //     formData.append('total', totalRoles);

    //     $.ajax({
    //         type: 'POST',
    //         url: '/admin/job-add',
    //         data: formData,
    //         processData: false,
    //         contentType: false,
    //         success: function (res) {

              
    //             if (res.success) {
    //                 Swal.fire({
    //                         text: 'Job roles added successfully!',
    //                         closeOnClickOutside: false,
    //                         position: 'top-end',
    //                         icon: 'success',
    //                         toast: true,
    //                         showConfirmButton: false,
    //                         timer: 2000
    //                     });
    //                 location.reload();
    //             }
    //             else {
    //                 Swal.fire({
    //                     text: 'Failed to add job roles!',
    //                     icon: 'error',
    //                     position: 'top-end',
    //                     toast: true,
    //                     showConfirmButton: false,
    //                     timer: 2000
    //                 });
    //             }
    //         }
    //     });
    // }

    window.submitRoles = function () {
    const formData = new FormData();
    
    formData.append('company', $('#company').val());
    formData.append('email', $('#email').val());
    formData.append('loc', $('#loc').val());

    let totalRoles = $('.role-block').length;

    if (totalRoles === 1) {
        alert("Please add at least one job role before submitting!");
        return;
    }

    // Check company, email, loc
    if (!$('#company').val() || !$('#email').val() || !$('#loc').val()) {
        alert("Please fill company, email and location before submitting!");
        return;
    }

    let errorFound = false;

    $('.role-block').each(function (index) {
        const block = $(this);

        const title = block.find('[name="title[]"]').val();
        const cperson = block.find('[name="cperson[]"]').val();
        const mcode = block.find('[name="mcode[]"]').val();
        const mobile = block.find('[name="mobile[]"]').val();
        const gender = block.find('[name="gender[]"]').val();
        const vaccancy = block.find('[name="vaccancy[]"]').val();
        const quali = block.find('.jquali')[0]?.selectize?.getValue() || [];
        const jexp = block.find('.jexp')[0]?.selectize?.getValue() || [];
        const jdept = block.find('.jdept')[0]?.selectize?.getValue() || [];
        const jobRoles = block.find('.job_roles')[0]?.selectize?.getValue() || [];

        // validate each field (except remarks)
        // if (!title || !cperson || !mcode || !mobile || !gender || !vaccancy 
        //     || quali.length === 0 
        //     || jexp.length === 0 
        //     || jdept.length === 0 
        //     || jobRoles.length === 0) {
        //     errorFound = true;
        //     return false;
        // }

        formData.append(`title[${index}]`, title);
        formData.append(`cperson[${index}]`, cperson);
        formData.append(`mcode[${index}]`, mcode);
        formData.append(`mobile[${index}]`, mobile);
        formData.append(`gender[${index}]`, gender);
        formData.append(`vaccancy[${index}]`, vaccancy);
        formData.append(`remarks[${index}]`, block.find('[name="remarks[]"]').val() || ''); // remarks optional
        formData.append(`quali[${index}]`, JSON.stringify(quali));
        formData.append(`jexp[${index}]`, JSON.stringify(jexp));
        formData.append(`jdept[${index}]`, JSON.stringify(jdept));
        formData.append(`job_roles[${index}]`, JSON.stringify(jobRoles));
    });

    if (errorFound) {
        Swal.fire({
            text: 'Please fill all required fields in all roles!',
            icon: 'warning',
            position: 'top-end',
            toast: true,
            showConfirmButton: false,
            timer: 2000
        });
        return;
    }

    formData.append('_token', '{{ csrf_token() }}');
    formData.append('total', totalRoles);

    $.ajax({
        type: 'POST',
        url: '/admin/job-add',
        data: formData,
        processData: false,
        contentType: false,
        success: function (res) {
            if (res.success) {
                Swal.fire({
                    text: 'Job roles added successfully!',
                    position: 'top-end',
                    icon: 'success',
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000
                });
                location.reload();
            } else {
                Swal.fire({
                    text: 'Failed to add job roles!',
                    icon: 'error',
                    position: 'top-end',
                    toast: true,
                    showConfirmButton: false,
                    timer: 2000
                });
            }
        }
    });
}



});


function setCompanyDetails() {
    const selectedOption = document.querySelector('#company option:checked');
    const email = selectedOption.getAttribute('data-email') || '';
    const location = selectedOption.getAttribute('data-location') || '';
    
    document.getElementById('email').value = email;
    document.getElementById('loc').value = location;
}


</script>
@endpush
