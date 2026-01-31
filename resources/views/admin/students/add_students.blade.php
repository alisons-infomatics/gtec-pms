@extends('layouts.Admin')

@section('content') 
<style>
    .invalid{border:1px solid red !important;}
</style>
  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Student's Registration Form</h6>
  
</div>

<!--<form action="{{ route('admin.students.bulk_upload') }}" method="POST" enctype="multipart/form-data">-->
<!--    @csrf-->
<!--    <label>Select Excel File:</label>-->
<!--    <input type="file" name="excel_file2" accept=".xls,.xlsx" required>-->
<!--    <button type="submit">Upload Bulk Sheet</button>-->
<!--</form>-->
    
    <div class="row gy-4">
      <div class="col-lg-12">
        <div class="card">
          <!--<div class="card-header">-->
          <!--  <h5 class="card-title mb-0">Add Student</h5>-->
          <!--</div>-->
          <div class="card-body">
            <form class="row gy-3 needs-validation" novalidate>
              <div class="col-md-4">
                <label class="form-label">First Name *</label>
                <input type="text" id="fname" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Middle Name </label>
                <input class="form-control" type="text" id="mname" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Last Name *</label>
                <input type="text" id="lname" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Register Number *</label>
                <input type="text" id="regnum" class="form-control" required>
              </div>
              
              <div class="col-md-4">
                <label class="form-label">Photo *</label>
                <input type="file" id="photo" class="form-control" required>
              </div>
              
              <div class="col-md-4">
                <label class="form-label">Phone Number *</label>
                <div class="form-mobile-field has-validation">
                  <select class="form-select" required id="mcode">
                    <option value="91">91</option>
                  </select>
                  <input type="number" id="mobile" class="form-control" required>
                </div>
              </div>
               <div class="col-md-4">
                <label class="form-label">Alternate (Parent's) Phone Number *</label>
                <div class="form-mobile-field has-validation">
                  <select class="form-select" required id="mcode1">
                    <option value="91">91</option>
                  </select>
                  <input type="number" id="mobile1" class="form-control" required>
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Address *</label>
                <input class="form-control" type="text" id="address" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Place *</label>
                <input type="text" id="place" class="form-control" required>
              </div>
              <div class="col-md-4">
                <label class="form-label">Gender *</label>
                <select class="form-select" required id="gender">
                    <option value="">Choose</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                  </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Date Of Birth *</label>
                <input class="form-control" type="date" id="dob" required onchange="calculateAge()" oninput="calculateAge()">
              </div>
              <div class="col-md-4">
                <label class="form-label">Age *</label>
                <input type="number" id="age" class="form-control" required readonly>
              </div>
              <div class="col-md-4">
                <label class="form-label">Marital Status *</label>
                <select class="form-select" required id="marital_status">
                    <option value="">Choose</option>
                    <option value="Unmarried">Unmarried</option>
                    <option value="Married">Married</option>
                    <option value="Divorced">Divorced</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email </label>
                <input class="form-control" type="text" id="email" >
              </div>
              <div class="col-md-6">
                    <label class="form-label">Highest Qualification *</label>
                    <select class="form-select" id="quali" required>
                        <option value="">Choose</option>
                        <option value="High School">High School</option>
                        <option value="Plus Two">Plus Two</option>
                        <option value="Bachelor's">Bachelor's</option>
                        <option value="Diploma">Diploma</option>
                        <option value="Master's">Master's</option>
                        <option value="PhD">PhD</option>
                    </select>
                </div>
                
                <div class="col-md-6" id="course-container" style="display: none;">
                    <label class="form-label">Course *</label>
                    <select class="form-select" id="course" name="course" required>
                        <option value="">Choose</option>
                    </select>
                </div>

              <div class="col-md-6">
                <label class="form-label">Department *</label>
                <select class="form-select" required id="dept" onchange="GetCrs(this.value)">
                    <option value="">Choose</option>
                    @foreach($dept as $d)
                        <option value="{{$d->id}}">{{$d->department}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Course Details *</label>
                <select class="" required id="crs" multiple>
                    <option value="">Choose</option>
                    <!--@foreach($courses as $c)
                    <option value="{{$c->id}}">{{$c->course}}</option>
                    @endforeach -->
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Experience Level *</label>
                <select class="form-select" required id="exp" name="experience_level">
                    <option value="Fresher">Fresher</option>
                    <option value="Experienced">Experienced</option>
                </select>
            </div>
            
            <div id="experience_fields" class="col-md-6 mt-3" style="display: none;">
                <label class="form-label">Experienced In *</label>
                <select class="form-select" id="experience_area" name="experience_area">
                    <option value="">Select Area</option>
                    <option value="Same Field">Same Field</option>
                    <option value="Different Field">Different Field</option>
                </select>
            
                <label class="form-label mt-3">Remarks</label>
                <textarea class="form-control" id="experience_remarks" name="experience_remarks" rows="3" placeholder="Any remarks..."></textarea>
            </div>


              <div class="col-md-6">
                <label class="form-label">Preferred Job Roles *</label>
                <select class="" required id="job_roles" multiple>
                    <option value="">Choose</option>
                    <!-- @foreach($job_roles as $j)
                    <option value="{{$j->id}}">{{$j->job_role}}</option>
                    @endforeach -->
                  </select>
              </div>
              <h6 style="font-size: 17px !important;">Select Your Grade Level</h6>
              <div class="col-md-6">
                <label class="form-label">Overall Performance Grade *</label>
                <select class="form-select" required id="a1">
                    <option selected value="">Select</option>
                    <option value="A">A</option>
                    <option value="B">B</option>
                    <option value="C">C</option>
                  </select>
              </div>
              <!--<div class="col-md-6">-->
              <!--  <label class="form-label">Technical Skills *</label>-->
              <!--  <select class="form-select" required id="a2">-->
              <!--      <option selected value="">Select</option>-->
              <!--      <option value="A">A</option>-->
              <!--      <option value="B">B</option>-->
              <!--      <option value="C">C</option>-->
              <!--    </select>-->
              <!--</div>-->
              <!--<div class="col-md-6">-->
              <!--  <label class="form-label">Language Proficiency *</label>-->
              <!--  <select class="form-select" required id="a3">-->
              <!--      <option selected value="">Select</option>-->
              <!--      <option value="A">A</option>-->
              <!--      <option value="B">B</option>-->
              <!--      <option value="C">C</option>-->
              <!--    </select>-->
              <!--</div>-->
              
              <div class="col-12">
                <button class="btn btn-primary-600" type="button" onclick="AddStudent()" id="add-button">  <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>   Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

   @endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

   <script type="text/javascript">
     
     $(document).ready(function () {
    const courseOptions = {
        // "High School": ["Science", "Commerce", "Arts"],
        "Plus Two": ["Biology Science", "Computer Science", "Commerce", "Humanities"],
        "Bachelor's": ["BSc", "BCom", "BA","BTech", "BCA","BBA","BBM","Bsc Digital Media", "Bsc Computer Science", "BSC Maths"],
        "Diploma": ["Diploma in Civil", "Diploma in Mechanical", "Diploma in Electrical","Others"],
        "Master's": ["MSC", "MCOM", "MA", "MBA", "MCA","MTECH","OTHERS"],
        "PhD": ["PhD in Physics", "PhD in Management", "PhD in Literature"]
    };

    $('#quali').on('change', function () {
        
        const selected = $(this).val();
        const $course = $('#course');
        const $container = $('#course-container');

        $course.empty().append('<option selected disabled>Select Course</option>');

        if (courseOptions[selected]) {
            $container.show();
            courseOptions[selected].forEach(course => {
                $course.append(`<option value="${course}">${course}</option>`);
            });
            $course.prop('required', true);
        } else {
            $container.hide();
            $course.prop('required', false);
        }
    });
    
     document.getElementById('exp').addEventListener('change', function () {
        const isExperienced = this.value === 'Experienced';
        const experienceFields = document.getElementById('experience_fields');
        const experienceArea = document.getElementById('experience_area');
        const experienceRemarks = document.getElementById('experience_remarks');

        if (isExperienced) {
            experienceFields.style.display = 'block';
            experienceArea.setAttribute('required', 'required');
            //experienceRemarks.setAttribute('required', 'required');
        } else {
            experienceFields.style.display = 'none';
            experienceArea.removeAttribute('required');
            //experienceRemarks.removeAttribute('required');
        }
    });
}); 

function AddStudent() {
    // Confirm before proceeding
    Swal.fire({
       //title: 'Confirm Submission',
        text: "Are you sure you want to add this student?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, Submit'
    }).then((result) => {
        if (!result.isConfirmed) return;

        // Check terms checkbox
        
        var photo = $('#photo')[0].files[0];
            
            if (!photo) {
                
                $('#photo').focus().css({ 'border': '1px solid red' });
                $('#photo-error').text('Please upload a photo.').show();
                return false;
            } else {
                
                $('#photo-error').hide();
                $('#photo').css({ 'border': '1px solid #CCC' });
            }

        var fname = $('input#fname').val();
        if (fname === '') { $('#fname').focus().css({'border': '1px solid red'}); return false; } else $('#fname').css({'border': '1px solid #CCC'});
        var lname = $('input#lname').val();
        if (lname === '') { $('#lname').focus().css({'border': '1px solid red'}); return false; } else $('#lname').css({'border': '1px solid #CCC'});
        var mname = $('input#mname').val();
        var regnum = $('input#regnum').val();
        if (regnum === '') { $('#regnum').focus().css({'border': '1px solid red'}); return false; } else $('#regnum').css({'border': '1px solid #CCC'});
        var mcode = $('#mcode').val();
        var mcode1 = $('#mcode1').val();
        var mobile = $('input#mobile').val();
        if (mobile === '') { $('#mobile').focus().css({'border': '1px solid red'}); return false; } else $('#mobile').css({'border': '1px solid #CCC'});
        var mobile1 = $('input#mobile1').val();
        if (mobile1 === '') { $('#mobile1').focus().css({'border': '1px solid red'}); return false; } else $('#mobile').css({'border': '1px solid #CCC'});
        var address = $('input#address').val();
        if (address === '') { $('#address').focus().css({'border': '1px solid red'}); return false; } else $('#address').css({'border': '1px solid #CCC'});
        var place = $('input#place').val();
        if (place === '') { $('#place').focus().css({'border': '1px solid red'}); return false; } else $('#place').css({'border': '1px solid #CCC'});
        var gender = $('#gender').val();
        if (gender === '') { $('#gender').focus().css({'border': '1px solid red'}); return false; } else $('#gender').css({'border': '1px solid #CCC'});
        var dob = $('input#dob').val();
        if (dob === '') { $('#dob').focus().css({'border': '1px solid red'}); return false; } else $('#dob').css({'border': '1px solid #CCC'});
        var age = $('input#age').val();
        if (age === '') { $('#age').focus().css({'border': '1px solid red'}); return false; } else $('#age').css({'border': '1px solid #CCC'});
        var marital_status = $('#marital_status').val();
        if (marital_status === '') { $('#marital_status').focus().css({'border': '1px solid red'}); return false; } else $('#marital_status').css({'border': '1px solid #CCC'});
        var email = $('input#email').val();
        // if (email === '') { $('#email').focus().css({'border': '1px solid red'}); return false; } else $('#email').css({'border': '1px solid #CCC'});
        var quali = $('#quali').val();
        if (quali === '') { $('#quali').focus().css({'border': '1px solid red'}); return false; } else $('#quali').css({'border': '1px solid #CCC'});
        var course = $('#course').val();
        if (course === '') { $('#course').focus().css({'border': '1px solid red'}); return false; } else $('#course').css({'border': '1px solid #CCC'});
        
        var dept = $('#dept').val();
        if (dept === '') { $('#dept').focus().css({'border': '1px solid red'}); return false; } else $('#dept').css({'border': '1px solid #CCC'});
        var crs = $('#crs').val();
        if (crs === '') { $('#crs').focus().css({'border': '1px solid red'}); return false; } else $('#crs').css({'border': '1px solid #CCC'});
        var exp = $('#exp').val();
        if (exp === '') { $('#exp').focus().css({'border': '1px solid red'}); return false; } else $('#exp').css({'border': '1px solid #CCC'});
        var job_roles = $('#job_roles').val();
        if (job_roles === '') { $('#job_roles').focus().css({'border': '1px solid red'}); return false; } else $('#job_roles').css({'border': '1px solid #CCC'});
        
        var crs = $('#crs').val();
        if (!crs || crs.length === 0) {
            $('#crs').focus().css({'border': '1px solid red'});
            return false;
        } else {
            $('#crs').css({'border': '1px solid #CCC'});
        }
        
        var job_roles = $('#job_roles').val();
        if (!job_roles || job_roles.length === 0) {
            $('#job_roles').focus().css({'border': '1px solid red'});
            return false;
        } else {
            $('#job_roles').css({'border': '1px solid #CCC'});
        }


        var a1 = $('#a1').val();
        if(a1 === ''){ $('#a1').focus().css({'border': '1px solid red'}); return false; } else $('#a1').css({'border': '1px solid #CCC'});
        // var a2 = $('#a2').val();
        // if(a2 === ''){ $('#a2').focus().css({'border': '1px solid red'}); return false; } else $('#a2').css({'border': '1px solid #CCC'});
        // var a3 = $('#a3').val();
        // if(a3 === ''){ $('#a3').focus().css({'border': '1px solid red'}); return false; } else $('#a3').css({'border': '1px solid #CCC'});
        var experience_area = $('#experience_area').val();
        var experience_remarks = $('#experience_remarks').val();
        var a2 = " ";
        var a3 = " ";
        
        
        $('#add-loader').show();
        $('#add-button').prop('disabled', true);

        var data = new FormData();
        data.append('fname', fname);
        data.append('mname', mname);
        data.append('lname', lname);
        data.append('photo', photo);
        data.append('regnum', regnum);
        data.append('mcode', mcode);
        data.append('mobile', mobile);
        data.append('mcode1', mcode1);
        data.append('mobile1', mobile1);
        data.append('address', address);
        data.append('place', place);
        data.append('gender', gender);
        data.append('dob', dob);
        data.append('age', age);
        data.append('marital_status', marital_status);
        data.append('email', email);
        data.append('quali', quali);
        data.append('course', course);
        data.append('dept', dept);
        data.append('crs', crs);
        data.append('exp', exp);
        data.append('experience_area', experience_area);
        data.append('experience_remarks', experience_remarks);
        data.append('a1', a1);
        data.append('a2', a2);
        data.append('a3', a3);
        data.append('job_roles', job_roles);
        data.append('_token', '{{ csrf_token() }}');

        $.ajax({
            type: "POST",
            url: "/admin/student-add",
            data: data,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(data) {
                $('#add-loader').hide();
                $('#add-button').prop('disabled', false);

                if (data['success']) {
                    Swal.fire({
                        text: 'Student added successfully!',
                        icon: 'success',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                }

                if (data['err']) {
                    Swal.fire({
                        text: 'This registration number or email already exists.',
                        icon: 'error',
                        toast: true,
                        position: 'top-end',
                        timer: 3000,
                        showConfirmButton: false
                    });
                }
            },
            error: function () {
                $('#add-loader').hide();
                $('#add-button').prop('disabled', false);
                Swal.fire({
                    text: 'Something went wrong. Please try again.',
                    icon: 'error',
                    toast: true,
                    position: 'top-end',
                    timer: 3000,
                    showConfirmButton: false
                });
            }
        });
    });
}





      function GetCrs(val) {
    var deptId = val;

    // Get Selectize instances
    var crsSelectize = $('#crs')[0].selectize;
    var jobRolesSelectize = $('#job_roles')[0].selectize;

    // Clear existing options
    crsSelectize.clear();
    crsSelectize.clearOptions();
    jobRolesSelectize.clear();
    jobRolesSelectize.clearOptions();

    if (deptId) {
        $.ajax({
            url: "{{ route('getCoursesAndRoles') }}",
            type: "GET",
            data: { dept_id: deptId },
            success: function (response) {
                if (response.courses.length > 0) {
                    $.each(response.courses, function (key, value) {
                        crsSelectize.addOption({ value: value.id, text: value.course });
                    });
                }

                if (response.job_roles.length > 0) {
                    $.each(response.job_roles, function (key, value) {
                        jobRolesSelectize.addOption({ value: value.id, text: value.job_role });
                    });
                }

                // Refresh Selectize dropdowns
                crsSelectize.refreshOptions(false);
                jobRolesSelectize.refreshOptions(false);
            }
        });
    }
}



function calculateAge() {
    const dobInput = document.getElementById('dob');
    const ageInput = document.getElementById('age');

    const dob = new Date(dobInput.value);
    const today = new Date();

    if (dob instanceof Date && !isNaN(dob)) {
        let age = today.getFullYear() - dob.getFullYear();
        const m = today.getMonth() - dob.getMonth();

        if (m < 0 || (m === 0 && today.getDate() < dob.getDate())) {
            age--;
        }

        ageInput.value = age > 0 ? age : '0';
    } else {
        ageInput.value = '0';
    }
}
   </script>