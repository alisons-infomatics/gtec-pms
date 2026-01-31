<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://cdn.jsdelivr.net/npm/selectize/dist/css/selectize.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="{{asset('/img/gtechficon.png')}}" sizes="16x16">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            background-color: #f9f9f9;
        }
        
        .invalid{border:1px solid red !important;}

        .profile-pic {
            display: block;
            margin: 0 auto 15px;
            border-radius: 50%;
        }

        .form-title {
            text-align: left;
            margin-bottom: 20px;
            font-weight: bold;
            padding-left: 20px;
            font-size: 30px;
        }

        .form-label {
            font-size: 18px;
            font-weight: 500;
            color: rgba(51, 51, 51, .7);
        }

        .form-control,
        .form-select {
            border: 1px solid rgba(51, 51, 51, .4);
            border-radius: 5px;
            padding: 11px 10px;
            font-size: 13px;
        }

        .select2-container--default .select2-selection--multiple {
            padding: 7px 10px;
            height: 47px;
            overflow-y: auto;
            overflow-x: hidden;
            font-size: 13px;
        }

        .select2-container .select2-search--inline .select2-search__field {
            height: 18px;
        }

        .select2-container--default .select2-selection--multiple .select2-selection__choice {
            margin: 3px 3px;
        }

        .student_register_form .col-blk {
            margin-bottom: 40px;
            padding-left: 20px;
            padding-right: 20px;
        }

        .doyouwanttoregister {
            padding: 20px 20px;
            background-color: rgba(238, 238, 238, 1);
            height: 160px;
            border-radius: 20px;
        }

        .doyouwanttoregister h4 {
            color: rgba(51, 51, 51, 1);
            font-size: 24px;
            font-weight: 500;
        }

        .btn-x {
            width: 100px;
            border: 0.5px solid rgba(0, 0, 0, .5);
            font-size: 18px;
            font-weight: 500;
            background-color: rgba(255, 255, 255, 1);
            border-radius: 0px;
            padding-top: 5px;
            padding-bottom: 5px;
        }

        .student_register_form h5 {
            font-size: 20px;
            font-weight: 600;
        }

        .student_register_form {
            padding: 20px 20px
        }

        .dashboard_header {
            padding-left: 30px;
            padding-right: 30px;
        }

        .dashboard_header img {
            width: 100px;
        }

        .form-control:focus {
            color: var(--bs-body-color);
            background-color: var(--bs-body-bg);
            border-color: 1px solid #2a7eca;
            outline: 0;
            box-shadow: none;
        }

        .selct-graduate-level {
            padding: 0px 15px;
        }

        .btn-x2 {
            width: 50%;
            border-radius: 20px;
            padding: 5px 24px;
            background-color: #2a7eca;
            color:#fff;
            font-size: 18px;
            font-weight: 500;
            border: none;

        }

        .doyouwanttoregister2 {
            font-size: 12px;
            padding: 20px 20px;
            background-color: rgba(238, 238, 238, 1);
            border-radius: 10px;
            font-weight: 400;
        }

        .doyouwanttoregister2 label {
            font-size: 12px;
            font-weight: 400;
        }

        .doyouwanttoregister2 h4 {
            font-size: 16px;
            font-weight: 600;
        }
        .red_star{color:red;font-size:16px;}        

        @media (max-width: 991.98px) {
            .student_register_form .col-blk {
                margin-bottom: 10px;
                padding-left: 10px;
                padding-right: 10px;
            }

            .form-label {
                font-size: 16px;
            }

            .doyouwanttoregister h4 {
                font-size: 20px;
            }

            .btn-x {
                font-size: 16px;
            }
        }

        @media (max-width: 767.98px) {
            .dashboard_header h1 {
                font-size: 24px;
            }

            .dashboard_header img {
                width: 75px;
            }

            .form-title {
                text-align: center;
                padding-left: 0px;
                padding-right: 0px;
                font-size: 20px;
            }

            .form-label {
                font-size: 14px;
            }

        }
    </style>
</head>

<body>


    <div class="container">

        <div class="d-flex align-items-center dashboard_header">
            <i class="me-3"><img src="{{asset('/img/gtechficon.png')}}" alt="logo"></i>
            <!--<h1>G - TECH</h1>-->
        </div>


        <div class="student_register_form">

@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

            <form id="studentForm"  method="POST" action="/student-register" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <h2 class="form-title text-left">Student’s Registration Form</h2>
                    <!-- Profile Photo-->
                   <!-- Profile Preview with Upload and Camera Options -->
                <div class="d-flex flex-column align-items-center mt-4 gap-2">
                    <img id="profilePreview" src="{{ asset('/img/camera_face.png') }}" class="rounded-circle border" style="width:100px;height:100px;object-fit:cover;">
                    
                    <div class="d-flex gap-2 mt-3">
                        <label for="profileUpload" class="btn btn-outline-primary btn-sm">
                            <i class="fa fa-image me-1"></i> Choose File
                        </label>
                        <label for="cameraInput" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-camera me-1"></i> Take Photo
                        </label>
                    </div>
                
                    <input type="file" id="profileUpload" name="photo" accept="image/*" class="d-none">
                    <input type="file" id="cameraInput" name="photo_camera" accept="image/*" capture="user" class="d-none">
                </div>


                    <!-- Basic Details -->
                    <div class="col-md-4 col-blk mt-3">
                        <label for="firstName" class="form-label">First name<span class="red_star">*</span></label>
                        <input type="text" class="form-control" id="fname" name="fname" required>
                    </div>
                    <div class="col-md-4 col-blk mt-3">
                        <label for="middleName" class="form-label">Middle name</label>
                        <input type="text" class="form-control" id="mname" name="mname">
                    </div>
                    <div class="col-md-4 col-blk mt-3">
                        <label for="lastName" class="form-label">Last name<span class="red_star">*</span></label>
                        <input type="text" class="form-control" id="lname" name="lname" required>
                    </div>


                    <!-- Registration & Phone -->
                    <div class="col-md-4 col-blk">
                        <label for="regNo" class="form-label">Reg. No<span class="red_star">*</span></label>
                        <input type="text" class="form-control" id="regnum"  name="regnum" required>
                    </div>

                    <div class="col-md-4 col-blk">
                        <label for="phoneNumber" class="form-label">Phone number<span class="red_star">*</span></label>
                        <div class="input-group gap-2">
                            <select class="form-select" id="mcode" name="mcode" style="max-width: 100px;">
                                <!-- <option value="+1">+1</option>
                                <option value="+44">+44</option> -->
                                <option value="+91" selected>+91</option>
                                <!-- <option value="+61">+61</option>
                                <option value="+971">+971</option> -->
                            </select>
                            <input type="tel" class="form-control" id="mobile" name="mobile" placeholder="Enter phone number"
                                required>
                        </div>
                    </div>


                    <div class="col-md-4 col-blk">
                        <label for="altPhone" class="form-label">Alternate (Parent’s) Phone number <span class="red_star">*</span></label>
                        <div class="input-group gap-2">
                            <select class="form-select" id="mcode1" name="mcode1" style="max-width: 100px;">
                                <!-- <option value="+1">+1</option>
                                <option value="+44">+44</option> -->
                                <option value="+91" selected>+91</option>
                                <!-- <option value="+61">+61</option>
                                <option value="+971">+971</option> -->
                            </select>
                            <input type="tel" class="form-control" id="mobile1" name="mobile1" placeholder="Enter phone number"
                                required>
                        </div>
                    </div>

                    <!-- Address & Location -->
                    <div class="col-md-4 col-blk">
                        <label for="address" class="form-label">Address<span class="red_star">*</span></label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>
                    <div class="col-md-4 col-blk">
                        <label for="place" class="form-label">Place<span class="red_star">*</span></label>
                        <input type="text" class="form-control" id="place" name="place" required>
                    </div>
                    <div class="col-md-4 col-blk">
                        <label for="gender" class="form-label">Gender<span class="red_star">*</span></label>
                        <select class="form-select" id="gender" name="gender" required>
                            <option selected disabled>Choose...</option>
                            <option>Male</option>
                            <option>Female</option>
                        </select>
                    </div>


                    <div class="col-md-4 col-blk">
                        <label for="dob" class="form-label">Date of birth<span class="red_star">*</span></label>
                        <input type="date" class="form-control" id="dob" name="dob" required onchange="calculateAge()" oninput="calculateAge()">
                    </div>
                    <div class="col-md-4 col-blk">
                        <label for="age" class="form-label">Age<span class="red_star">*</span></label>
                        <input type="number" class="form-control" id="age" name="age" required readonly>
                    </div>
                    <div class="col-md-4 col-blk">
                        <label for="gender" class="form-label">Marital Status<span class="red_star">*</span></label>
                        <select class="form-select" id="marital_status" name="marital_status" required>
                            <option selected disabled>Choose...</option>
                            <option>Unmarried</option>
                            <option>Married</option>
                        </select>
                    </div>

                    <!-- Email, Qualification & Marital Status -->
                    <div class="col-md-6 col-blk">
                        <label for="email" class="form-label">Email ID<span class="red_star">*</span></label>
                        <input type="email" class="form-control" id="email" name="email" >
                    </div>
                    <div class="col-md-6 col-blk">
                        <label for="qualification" class="form-label">Highest Qualification<span class="red_star">*</span></label>
                        <select class="form-select" id="quali" name="quali" required>
                            <option value="">Choose</option>
                            <option value="High School">High School</option>
                            <option value="Plus Two">Plus Two</option>
                            <option value="Bachelor's">Bachelor's</option>
                            <option value="Diploma">Diploma</option>
                            <option value="Master's">Master's</option>
                            <option value="PhD">PhD</option>
                        </select>
                    </div>
                    <div class="col-md-6" id="course-container" style="display: none;" >
                        <label class="form-label">Qualification Course <span class="red_star">*</span></label>
                        <select class="form-select" id="course" name="course" required>
                            <option value="">Choose</option>
                        </select>
                    </div>

                    <!-- Department & Course -->
                    <div class="col-md-6 col-blk">
                        <label for="department" class="form-label">Department<span class="red_star">*</span></label>
                        <select class="form-select" id="dept" name="dept" onchange="GetCrs(this.value)">
                            <option selected disabled>Select Department</option>
                            @foreach($dept as $d)
                    <option value="{{$d->id}}">{{$d->department}}</option>
                    @endforeach
                        </select>
                    </div>
                    <div class="col-md-6 col-blk">
                        <label for="courseDetails" class="form-label">Course Details<span class="red_star">*</span></label>
                        <select class="" id="crs" name="crs[]" multiple required>
                            
                        </select>
                    </div>

                    <!-- Experience & Preferred Job Role -->
                    <div class="col-md-6">
                <label class="form-label">Experience Level *</label>
                <select class="form-select" required id="exp" name="exp">
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
            
                <label class="form-label mt-3">Remarks </label>
                <textarea class="form-control" id="experience_remarks" name="experience_remarks" rows="3" placeholder="Any remarks..."></textarea>
            </div>
                    <div class="col-md-6 col-blk">
                        <label for="preferredJob" class="form-label">Preferred Job Role<span class="red_star">*</span></label>
                        <select name="job_roles[]" class="" id="job_roles" multiple required>
                            
                        </select>
                    </div>


                    <!-- Submit -->
                    <div class="col-12">
                        <div class="doyouwanttoregister2">
                            <h4>Delaration<span class="red_star">*</span></h4>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault" required>
                                <label class="form-check-label" for="flexCheckDefault">
                                    I acknowledge that failure to attend a scheduled interview, any misconduct towards
                                    placement cell staff or employers, or being continuously unreachable on the
                                    registered phone number will result in the termination of my placement registration
                                    without prior notice. I understand the importance of professional conduct and
                                    communication in the placement process.
                                    I hereby declare that the information provided in this form is true and accurate to
                                    the best of my knowledge and belief.
                                </label>
                                <label class="form-check-label mt-1" for="flexCheckDefault">
                                    ഷെഡ്യൂൾ ചെയ്ത ഒരു അഭിമുഖത്തിൽ പങ്കെടുക്കാതിരിക്കുക, പ്ലേസ്‌മെന്
                                    റ് സെൽ ജീവനക്കാരോടോ തൊഴിലുടമകളോടോ മോശമായി പെരുമാറുക, അല്ലെങ്കിൽ രജിസ്റ്റർ ചെയ്ത ഫോൺ നമ്പറിൽ തുടർച്ചയായി ബന്ധപ്പെടാൻ കഴിയാതിരിക്കുക എന്നിവ മുൻകൂർ അറിയിപ്പ് കൂടാതെ എന്റെ പ്ലേസ്‌മെന്റ് രജിസ്ട്രേഷൻ അവസാനിപ്പിക്കുന്നതിന് കാരണമാകുമെന്ന് ഞാൻ സമ്മതിക്കുന്നു. പ്ലേസ്‌മെന്റ് പ്രക്രിയയിൽ പ്രൊഫഷണൽ പെരുമാറ്റത്തിന്റെയും ആശയവിനിമയത്തിന്റെയും
                                    പ്രാധാന്യം ഞാൻ മനസ്സിലാക്കുന്നു. ഈ ഫോമിൽ നൽകിയിരിക്കുന്ന വിവരങ്ങൾ എന്റെ അറിവിലും വിശ്വാസത്തിലും സത്യവും കൃത്യവുമാണെന്ന് ഞാൻ ഇതിനാൽ പ്രഖ്യാപിക്കുന്നു.
                                </label>
                            </div>

                        </div>
                        <div class="d-flex justify-content-end gap-3 mt-3">
                            <button type="button" class="btn-x2 bg-transparent text-black">CANCEL</button>
                            <!-- <button class="btn btn-primary-600" type="button" onclick="AddStudent()" id="add-button">  <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>   Submit</button> -->

                            <button type="button" class="btn-x2" id="add-button" onclick="AddStudent()">SUBMIT</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@if(session('success'))
<script>
Swal.fire({
    text: "{{ session('success') }}",
    icon: 'success',
    toast: true,
    position: 'top-end',
    timer: 3000,
    showConfirmButton: false
});
</script>
@endif

    <!-- JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/selectize/dist/js/standalone/selectize.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            const courseOptions = {
            // "High School": ["Science", "Commerce", "Arts"],
            "Plus Two": ["Biology Science", "Computer Science", "Commerce", "Humanities"],
            "Bachelor's": ["BSc", "BCom", "BA", "BTech", "BCA","BBA","BBM","Bsc Digital Media", "Bsc Computer Science", , "BSC Maths"],
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
            //alert('here');
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
    
            $('#crs').selectize({
        create: false, // Disable custom entry
        placeholder: "Choose Courses",
        plugins: ['remove_button'],
        allowEmptyOption: false
    });
        $('#job_roles').selectize({
        create: false, // Disable custom entry
        placeholder: "Choose Job Roles",
        plugins: ['remove_button'],
        allowEmptyOption: false
    });
    
    
     
        });
    </script>
    <!-- JS to Handle Image Preview -->
    <script>
       function updateProfilePreview(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById('profilePreview').setAttribute('src', e.target.result);
        };
        reader.readAsDataURL(file);
    }
}

// Handle both upload and camera input
document.getElementById('profileUpload').addEventListener('change', updateProfilePreview);
document.getElementById('cameraInput').addEventListener('change', updateProfilePreview);

    </script>
</body>

</html>

<script>
$(document).ready(function () {
    const $profileUpload = $('#profileUpload');
    const $cameraInput = $('#cameraInput');
    const $preview = $('#profilePreview');

    // Function to handle image preview
    function handleImage(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                $preview.attr('src', e.target.result);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // When choosing from file
    $profileUpload.on('change', function () {
        if (this.files.length > 0) {
            $cameraInput.val(''); // Clear camera input
            handleImage(this);
        }
    });

    // When taking a photo
    $cameraInput.on('change', function () {
        if (this.files.length > 0) {
            $profileUpload.val(''); // Clear file input
            handleImage(this);
        }
    });

    // Optional: validate before form submission
    $('#studentForm').on('submit', function () {
        if (!$profileUpload[0].files.length && !$cameraInput[0].files.length) {
            alert('Please upload a profile photo.');
            return false;
        }
        return true;
    });
});
</script>

<script type="text/javascript">
$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function AddStudent() {
    
    Swal.fire({
        title: 'Confirm Registration',
        text: "Do you want to submit your registration details?",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#aaa',
        confirmButtonText: 'Yes, Submit'
    }).then((result) => {
        if (result.isConfirmed) {
            
            if (!$('#flexCheckDefault').is(':checked')) {
    Swal.fire({
        text: 'Please agree to the terms before submitting.',
        icon: 'warning',
        toast: true,
        position: 'top-end',
        timer: 3000,
        showConfirmButton: false
    });
    return false;
}

            var fname = $('input#fname').val();
            if (fname === '') {
                $('#fname').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#fname').css({ 'border': '1px solid #CCC' });
            }

            var lname = $('input#lname').val();
            if (lname === '') {
                $('#lname').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#lname').css({ 'border': '1px solid #CCC' });
            }

            var mname = $('input#mname').val();
            var regnum = $('input#regnum').val();
            if (regnum === '') {
                $('#regnum').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#regnum').css({ 'border': '1px solid #CCC' });
            }

            var mcode = $('#mcode').val();
            var mcode1 = $('#mcode1').val();

            var mobile = $('input#mobile').val();
            if (mobile === '') {
                $('#mobile').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#mobile').css({ 'border': '1px solid #CCC' });
            }

            var mobile1 = $('input#mobile1').val();
            if (mobile1 === '') {
                $('#mobile1').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#mobile1').css({ 'border': '1px solid #CCC' });
            }
            
            var address = $('input#address').val();
            if (address === '') {
                $('#address').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#address').css({ 'border': '1px solid #CCC' });
            }

            var place = $('input#place').val();
            if (place === '') {
                $('#place').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#place').css({ 'border': '1px solid #CCC' });
            }

            var gender = $('#gender').val();
            if (gender === '') {
                $('#gender').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#gender').css({ 'border': '1px solid #CCC' });
            }

            var dob = $('input#dob').val();
            if (dob === '') {
                $('#dob').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#dob').css({ 'border': '1px solid #CCC' });
            }

            var age = $('input#age').val();
            if (age === '') {
                $('#age').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#age').css({ 'border': '1px solid #CCC' });
            }

            var marital_status = $('#marital_status').val();
            if (marital_status === '') {
                $('#marital_status').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#marital_status').css({ 'border': '1px solid #CCC' });
            }

            var email = $('input#email').val();
            // if (email === '') {
            //     $('#email').focus().css({ 'border': '1px solid red' });
            //     return false;
            // } else {
            //     $('#email').css({ 'border': '1px solid #CCC' });
            // }

            var quali = $('#quali').val();
            if (quali === '') {
                $('#quali').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#quali').css({ 'border': '1px solid #CCC' });
            }
            var course = $('#course').val();
            if (course === '') { $('#course').focus().css({'border': '1px solid red'}); return false; } 
            else $('#course').css({'border': '1px solid #CCC'});
        

            var dept = $('#dept').val();
            if (dept === '') {
                $('#dept').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#dept').css({ 'border': '1px solid #CCC' });
            }

            var crs = $('#crs').val();
            if (crs === '') {
                $('#crs').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#crs').css({ 'border': '1px solid #CCC' });
            }
            
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

            var exp = $('#exp').val();
            if (exp === '') {
                $('#exp').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#exp').css({ 'border': '1px solid #CCC' });
            }

            var job_roles = $('#job_roles').val();
            if (job_roles === '') {
                $('#job_roles').focus().css({ 'border': '1px solid red' });
                return false;
            } else {
                $('#job_roles').css({ 'border': '1px solid #CCC' });
            }
            
            let photo = $('#profileUpload')[0].files[0]; // file input
            if (!photo) {
                photo = $('#cameraInput')[0].files[0]; // camera input
            }
            
            var experience_area = $('#experience_area').val();
            var experience_remarks = $('#experience_remarks').val();
            
            if (!photo) {
            Swal.fire({
                text: 'Please upload or capture a photo before submitting.',
                icon: 'warning',
                toast: true,
                position: 'top-end',
                timer: 3000,
                showConfirmButton: false
            });
            return false;
        }
 // If everything is valid, submit form
            $('#add-loader').show();
            $('#add-button').prop('disabled', true);
            $('#studentForm')[0].submit();
        }
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