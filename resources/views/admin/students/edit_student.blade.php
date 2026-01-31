@extends('layouts.Admin')

@section('content') 

@php
    $photoPath = $student->photo != '' ? asset($student->photo) : asset('/img/usr.jpg');
@endphp
  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Edit Student</h6>
  
</div>
    
    <div class="row gy-4">
      <div class="col-lg-12">
        <div class="card">
          <div class="card-header">
            <h5 class="card-title mb-0">Edit Student</h5>
          </div>
          <div class="card-body">
              <div class="col-12">
                  <img src="@if($student->photo!='') {{asset($student->photo)}} @else /img/usr.jpg @endif" alt="" class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
              </div>
            <form class="row gy-3 needs-validation" novalidate>
              <div class="col-md-4">
                <label class="form-label">First Name *</label>
                <input type="text" id="fname" class="form-control" required value="{{$student->first_name}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Middle Name </label>
                <input class="form-control" type="text" id="mname" required value="{{$student->middle_name}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Last Name *</label>
                <input type="text" id="lname" class="form-control" required value="{{$student->last_name}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Register Number *</label>
                <input type="text" id="regnum" class="form-control" required value="{{$student->reg_num}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Photo *</label>
                <input type="file" id="photo" class="form-control">
              </div>
              <div class="col-md-4">
                <label class="form-label">Phone Number *</label>
                <div class="form-mobile-field has-validation">
                  <select class="form-select" required id="mcode">
                    <option value="91">91</option>
                  </select>
                  <input type="number" id="mobile" class="form-control" required value="{{$student->mobile}}">
                </div>
              </div>
               <div class="col-md-4">
                <label class="form-label">Alternate (Parent's) Phone Number</label>
                <div class="form-mobile-field has-validation">
                  <select class="form-select" required id="mcode1">
                    <option value="91">91</option>
                  </select>
                  <input type="number" id="mobile1" class="form-control" required value="{{$student->alternate_mobile}}">
                </div>
              </div>

              <div class="col-md-4">
                <label class="form-label">Address *</label>
                <input class="form-control" type="text" id="address" required value="{{$student->address}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Place *</label>
                <input type="text" id="place" class="form-control" required value="{{$student->place}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Gender *</label>
                <select class="form-select" required id="gender">
                    <option value="Male" @if($student->gender=='Male') selected @endif>Male</option>
                    <option value="Female" @if($student->gender=='Female') selected @endif>Female</option>
                  </select>
              </div>
              <div class="col-md-4">
                <label class="form-label">Date Of Birth *</label>
                <input class="form-control" type="date" id="dob" required value="{{$student->dob}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Age *</label>
                <input type="number" id="age" class="form-control" required value="{{$student->age}}">
              </div>
              <div class="col-md-4">
                <label class="form-label">Marital Status *</label>
                <select class="form-select" required id="marital_status">
                    <option value="Unmarried" @if($student->marital_status=='Unmarried') selected @endif>Unmarried</option>
                    <option value="Married" @if($student->marital_status=='Married') selected @endif>Married</option>
                    <option value="Divorced" @if($student->marital_status=='Divorced') selected @endif>Divorced</option>
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Email *</label>
                <input class="form-control" type="text" id="email"  value="{{$student->email}}">
              </div>
              <div class="col-md-6">
                <label class="form-label">Highest Qualification *</label>
                <select class="form-select" id="quali" required>
                            <option selected disabled>Select</option>
                            <option @if($student->qualification=="High School") selected @endif>High School</option>
                             <option @if($student->qualification=="Plus Two") selected @endif>Plus Two</option>
                            <option @if($student->qualification=="Bachelor's") selected @endif>Bachelor's</option>
                            <option @if($student->qualification=="Diploma") selected @endif>Diploma</option>
                            <option @if($student->qualification=="Master's") selected @endif>Master's</option>
                            <option @if($student->qualification=="PhD") selected @endif>PhD</option>
                        </select>
              </div>
                <div class="col-md-6" id="course-container" style="display: none;">
                    <label class="form-label">Course *</label>
                    <select class="form-select" id="course" name="qualification_course" required>
                        <option disabled selected>Select Course</option>
                        <!-- Options will be loaded by JavaScript -->
                    </select>
                </div>
              <div class="col-md-6">
                <label class="form-label">Department *</label>
                <select class="form-select" required id="dept" onchange="GetCrs(this.value)">
                    <option value="">Choose</option>
                    @foreach($dept as $d)
                    <option value="{{$d->id}}" @if($student->dept==$d->id) selected @endif>{{$d->department}}</option>
                    @endforeach
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Course Details *</label>
                <select class="" required id="crs" multiple>
                    <option value="">Choose</option>
                    
                  </select>
              </div>
              <div class="col-md-6">
                <label class="form-label">Experience Level *</label>
                <select class="form-select" required id="exp"  name="experience_level">
                    <option value="Fresher" @if($student->experience=='Fresher') selected @endif>Fresher</option>
                    <option value="Experienced" @if($student->experience=='Experienced') selected @endif>Experienced</option>
                  </select>
              </div>
                @php
                    $fixedOptions = ['Same Field', 'Different Field'];
                    $currentValue = old('experience_in', $student->experience_in ?? '');
                @endphp
              <div id="experience_fields" class="col-md-6 mt-3" style="display: none;">
                <label class="form-label">Experienced In *</label>
                <select class="form-select" id="experience_area" name="experience_area">
                    <option value="">Select Area</option>
                    @if($currentValue && !in_array($currentValue, $fixedOptions))
                        <option value="{{ $currentValue }}" selected>{{ $currentValue }}</option>
                    @endif
                    @foreach($fixedOptions as $area)
                        <option value="{{ $area }}" {{ $currentValue == $area ? 'selected' : '' }}>
                            {{ $area }}
                        </option>
                    @endforeach
                    <!--@foreach([ 'Same Field', 'Different Field'] as $area)-->
                    <!--    <option value="{{ $area }}" {{ old('experience_in', $student->experience_in ?? '') == $area ? 'selected' : '' }}>{{ $area }}</option>-->
                    <!--@endforeach-->
                </select>
            
                <label class="form-label mt-3">Remarks *</label>
                <textarea class="form-control" id="experience_remarks" name="experience_remarks" rows="3" placeholder="Any remarks...">{{ old('remarks', $student->remarks ?? '') }}</textarea>
            </div>
              <div class="col-md-6">
                <label class="form-label">Preferred Job Roles *</label>
                <select class="" required id="job_roles" multiple>
                    <option value="">Choose</option>
                    
                  </select>
              </div>

              <div class="col-md-6">
                <label class="form-label">Status *</label>
                <select class="form-select" required id="status">
                    <option value="Live" @if($student->status=='Live') selected @endif>Live</option>
                    <option value="No Need" @if($student->status=='No Need') selected @endif>No Need</option>
                    <option value="No Response" @if($student->status=='No Response') selected @endif>No Response</option>
                    @if(auth('admin')->check() && auth('admin')->user()->user_type == 1)
                        <option value="Self Placed" @if($student->status == 'Self Placed') selected @endif>Self Placed</option>
                        <option value="Placed" @if($student->status == 'Placed') selected @endif>Placed</option>
                    @endif
                    <option value="Blocked" @if($student->status=='Blocked') selected @endif>Blocked</option>
                  </select>
              </div>
              
              <div class="col-md-6" id="status_remarks_field" >
                    <label class="form-label">Status Note </label>
                    <textarea class="form-control" id="status_remarks" name="status_remarks" rows="3" placeholder="Any remarks...">{{ old('status_remarks', $student->status_remarks ?? '') }}</textarea>
                </div>


              <h6 style="font-size: 17px !important;">Select Grade Level</h6>
              <div class="col-md-6">
                <label class="form-label">Overall Performance Grade *</label>
                <select class="form-select" required id="a1">
                    <option selected disabled>Select</option>
                    <option value="A" @if($student->behaviour_level=='A') selected @endif>A</option>
                    <option value="B" @if($student->behaviour_level=='B') selected @endif>B</option>
                    <option value="C" @if($student->behaviour_level=='C') selected @endif>C</option>
                  </select>
              </div>
              <!--<div class="col-md-6">-->
              <!--  <label class="form-label">Technical Skills *</label>-->
              <!--  <select class="form-select" required id="a2">-->
              <!--      <option selected disabled>Select</option>-->
              <!--      <option value="A" @if($student->skill_level=='A') selected @endif>A</option>-->
              <!--      <option value="B" @if($student->skill_level=='B') selected @endif>B</option>-->
              <!--      <option value="C" @if($student->skill_level=='C') selected @endif>C</option>-->
              <!--    </select>-->
              <!--</div>-->
              <!--<div class="col-md-6">-->
              <!--  <label class="form-label">Language Proficiency *</label>-->
              <!--  <select class="form-select" required id="a3">-->
              <!--      <option selected disabled>Select</option>-->
              <!--      <option value="A" @if($student->lang_level=='A') selected @endif>A</option>-->
              <!--      <option value="B" @if($student->lang_level=='B') selected @endif>B</option>-->
              <!--      <option value="C" @if($student->lang_level=='C') selected @endif>C</option>-->
              <!--    </select>-->
              <!--</div>-->
              
              <div class="col-12">
                <button class="btn btn-primary-600" type="button" onclick="EditStudent()" id="add-button">  <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>   Submit</button>
              </div>
            </form>
          </div>
        </div>
      </div>

    </div>
  </div>

   @endsection

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>

$(document).ready(function () {
    const courseOptions = {
        // "High School": ["Science", "Commerce", "Arts"],
        "Plus Two": ["Biology Science", "Computer Science", "Commerce", "Humanities"],
        "Bachelor's": ["BSc Physics", "BSc Chemistry", "BCom", "BA", "BTech", "BCA","Bsc Digital Media", "Bsc Computer Science","BBA", , "BSC Maths"],
        "Diploma": ["Diploma in Civil", "Diploma in Mechanical", "Diploma in Electrical"],
        "Master's": ["MSc Physics", "MSc CS", "MCom", "MA", "MBA", "MCA"],
        "PhD": ["PhD in Physics", "PhD in Management", "PhD in Literature"]
    };

    const selectedQualification = $('#quali').val();
    const selectedCourse = @json($student->qualification_course);

    function loadCourses(qualification, preselect = null) {
        const $course = $('#course');
        const $container = $('#course-container');
        $course.empty().append('<option disabled selected>Select Course</option>');

        if (courseOptions[qualification]) {
            $container.show();
            courseOptions[qualification].forEach(course => {
                const isSelected = course === preselect ? 'selected' : '';
                $course.append(`<option value="${course}" ${isSelected}>${course}</option>`);
            });
            $course.prop('required', true);
        } else {
            $container.hide();
            $course.prop('required', false);
        }
    }

    // Load on page load (for edit)
    if (selectedQualification) {
        loadCourses(selectedQualification, selectedCourse);
    }

    // Load on qualification change
    $('#quali').on('change', function () {
        const selected = $(this).val();
        loadCourses(selected);
    });
    
    // $('#status').on('change', function () {
    //     const selected = $(this).val();
    //     const status_remarks_field = document.getElementById('status_remarks_field');
    //     const status_remarks = document.getElementById('status_remarks');
        
    //     if(selected == 'Blocked'){
    //         //alert("status blocked");
    //         status_remarks_field.style.display = 'block';
    //         status_remarks.setAttribute('required', 'required');
    //     }else{
    //         status_remarks_field.style.display = 'none';
    //     }
    // });
    
     $('#exp').on('change', function () {
         //alert("here");
         toggleExperienceFields();
    });
    toggleExperienceFields();
     function toggleExperienceFields() {
        const expValue = document.getElementById('exp').value;
        //alert(expValue);
        const experienceFields = document.getElementById('experience_fields');
        const experienceIn = document.getElementById('experience_in');
        const remarks = document.getElementById('remarks');

        if (expValue === 'Experienced') {
            experienceFields.style.display = 'block';
            experienceIn.setAttribute('required', 'required');
           // remarks.setAttribute('required', 'required');
        } else {
            experienceFields.style.display = 'none';
            experienceIn.removeAttribute('required');
           // remarks.removeAttribute('required');
           experienceIn.value = '';
            remarks.value = '';
        }
    }
    
});
</script>

   <script type="text/javascript">


    window.onload = function () {
    var selectedDept = "{{ $student->dept ?? '' }}"; 
    var selectedCourses = @json($selectedCourses ?? []); 
    var selectedJobRoles = @json($selectedJobRoles ?? []); 

    if (selectedDept) {
        GetCrs(selectedDept, selectedCourses, selectedJobRoles);
    }
};

function GetCrs(val, selectedCourses = [], selectedJobRoles = []) {
    var deptId = val;

    var crsSelectize = $('#crs')[0].selectize;
    var jobRolesSelectize = $('#job_roles')[0].selectize;

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
                $.each(response.courses, function (key, value) {
                    crsSelectize.addOption({ value: value.id, text: value.course });
                });

                $.each(response.job_roles, function (key, value) {
                    jobRolesSelectize.addOption({ value: value.id, text: value.job_role });
                });

                crsSelectize.refreshOptions(false);
                jobRolesSelectize.refreshOptions(false);

                // Ensure preselected values are set after options are loaded
                setTimeout(() => {
                    crsSelectize.setValue(selectedCourses);
                    jobRolesSelectize.setValue(selectedJobRoles);
                }, 500);
            }
        });
    }
}



     
function EditStudent() {
            
            var fname = $('input#fname').val();
            if (fname === '') 
            {
                $('#fname').focus();
                $('#fname').css({'border': '1px solid red'});
                return false;
            } else 
                $('#fname').css({'border': '1px solid #CCC'});

                var lname = $('input#lname').val();
            if (lname === '') 
            {
                $('#lname').focus();
                $('#lname').css({'border': '1px solid red'});
                return false;
            } else 
                $('#lname').css({'border': '1px solid #CCC'});
                
                var mname = $('input#mname').val();
            // if (mname === '') 
            // {
            //     $('#mname').focus();
            //     $('#mname').css({'border': '1px solid red'});
            //     return false;
            // } else 
            //     $('#mname').css({'border': '1px solid #CCC'}); 

                var regnum = $('input#regnum').val();
            if (regnum === '') 
            {
                $('#regnum').focus();
                $('#regnum').css({'border': '1px solid red'});
                return false;
            } else 
                $('#regnum').css({'border': '1px solid #CCC'}); 

                var mcode = $('#mcode option:selected').val();
                var mcode1 = $('#mcode1 option:selected').val();

                var mobile = $('input#mobile').val();
            if (mobile === '') 
            {
                $('#mobile').focus();
                $('#mobile').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobile').css({'border': '1px solid #CCC'}); 

                var mobile1 = $('input#mobile1').val();
            // if (mobile1 === '') 
            // {
            //     $('#mobile1').focus();
            //     $('#mobile1').css({'border': '1px solid red'});
            //     return false;
            // } else 
            //     $('#mobile1').css({'border': '1px solid #CCC'}); 

                var address = $('input#address').val();
            if (address === '') 
            {
                $('#address').focus();
                $('#address').css({'border': '1px solid red'});
                return false;
            } else 
                $('#address').css({'border': '1px solid #CCC'}); 

                var place = $('input#place').val();
            if (place === '') 
            {
                $('#place').focus();
                $('#place').css({'border': '1px solid red'});
                return false;
            } else 
                $('#place').css({'border': '1px solid #CCC'}); 

                 var gender = $('#gender option:selected').val();
            if (gender === '') 
            {
                $('#gender').focus();
                $('#gender').css({'border': '1px solid red'});
                return false;
            } else 
                $('#gender').css({'border': '1px solid #CCC'}); 

                 var dob = $('input#dob').val();
            if (dob === '') 
            {
                $('#dob').focus();
                $('#dob').css({'border': '1px solid red'});
                return false;
            } else 
                $('#dob').css({'border': '1px solid #CCC'}); 
                var age = $('input#age').val();
            if (age === '') 
            {
                $('#age').focus();
                $('#age').css({'border': '1px solid red'});
                return false;
            } else 
                $('#age').css({'border': '1px solid #CCC'}); 

                var marital_status = $('#marital_status option:selected').val();
            if (marital_status === '') 
            {
                $('#marital_status').focus();
                $('#marital_status').css({'border': '1px solid red'});
                return false;
            } else 
                $('#marital_status').css({'border': '1px solid #CCC'}); 


                var email = $('input#email').val();
            // if (email === '') 
            // {
            //     $('#email').focus();
            //     $('#email').css({'border': '1px solid red'});
            //     return false;
            // } else 
            //     $('#email').css({'border': '1px solid #CCC'});

                 var quali = $('#quali option:selected').val();
            if (quali === '') 
            {
                $('#quali').focus();
                $('#quali').css({'border': '1px solid red'});
                return false;
            } else 
                $('#quali').css({'border': '1px solid #CCC'}); 
                var course = $('#course option:selected').val();

            var dept = $('#dept option:selected').val();
            if (dept === '') 
            {
                $('#dept').focus();
                $('#dept').css({'border': '1px solid red'});
                return false;
            } else 
                $('#dept').css({'border': '1px solid #CCC'}); 

                var crs = $('#crs').val();
            if (crs === '') 
            {
                $('#crs').focus();
                $('#crs').css({'border': '1px solid red'});
                return false;
            } else 
                $('#crs').css({'border': '1px solid #CCC'}); 

                var exp = $('#exp option:selected').val();
            if (exp === '') 
            {
                $('#exp').focus();
                $('#exp').css({'border': '1px solid red'});
                return false;
            } else 
                $('#exp').css({'border': '1px solid #CCC'}); 

                var job_roles = $('#job_roles').val();
            if (job_roles === '') 
            {
                $('#job_roles').focus();
                $('#job_roles').css({'border': '1px solid red'});
                return false;
            } else 
                $('#job_roles').css({'border': '1px solid #CCC'}); 

                var status = $('#status option:selected').val();
                    var a1 = $('#a1').val();
                    if(a1 === ''){ $('#a1').focus().css({'border': '1px solid red'}); return false; } else $('#a1').css({'border': '1px solid #CCC'});
                    var a2 = $('#a2').val();
                    if(a2 === ''){ $('#a2').focus().css({'border': '1px solid red'}); return false; } else $('#a2').css({'border': '1px solid #CCC'});
                    var a3 = $('#a3').val();
                    if(a3 === ''){ $('#a3').focus().css({'border': '1px solid red'}); return false; } else $('#a3').css({'border': '1px solid #CCC'});
                var photo = $('#photo')[0].files[0];
                
                var experience_area = $('#experience_area').val();
                var experience_remarks = $('#experience_remarks').val();
                var status_remarks = $('#status_remarks').val();
                
                
            $('#add-loader').show();
            $('#add-button').prop('disabled', true);

            var data = new FormData();
            data.append('fname', fname);
            data.append('mname', mname);
            data.append('lname', lname);
            data.append('regnum', regnum);
            data.append('photo', photo);
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
            data.append('experience_area', experience_area);
            data.append('experience_remarks', experience_remarks);
            data.append('course', course);
            data.append('dept', dept);
            data.append('crs', crs);
            data.append('exp', exp);
            data.append('job_roles', job_roles);
            data.append('status', status);
             data.append('status_remarks', status_remarks);
            data.append('a1', a1);
            data.append('a2', a2);
            data.append('a3', a3);
            data.append('student_id', '{{$student->id}}');
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/student-edit",
                data: data,
                dataType: "json",
                contentType: false,
                processData: false,
                success: function(data) {
                    $('#add-loader').hide();
                    $('#add-button').prop('disabled', false);

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
                            text: 'Username already exists',
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