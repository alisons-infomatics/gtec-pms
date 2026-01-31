@extends('layouts.Admin')

@section('content')

 @php

$my_roles=DB::table('user_types')->where('id',auth()->guard('admin')->user()->user_type)->first();
$rulesArray = explode(',', $my_roles->rules);
@endphp


  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Courses</h6>

</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <h5 class="card-title mb-0">Courses
        @if(in_array('151', $rulesArray))
<button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1">Add New</button>
       @endif
       <!--<form action="{{ url('/admin/bulkupload/add-course') }}" method="POST" enctype="multipart/form-data">-->
       <!--     @csrf-->
       <!--     <input class="radius-8 px-14 py-6 text-md" type="file" name="csv_file" style="float: right;color: black !important;" accept=".csv" required>-->
       <!--     <button class="btn btn-sm btn-success-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" type="submit">Upload Courses</button>-->
       <!-- </form>-->
        </h5>
        


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
              <th scope="col">Course</th>
              <th scope="col">Department</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

@foreach($courses as $c)
            <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$c->course}}</td>
              <td>{{$c->GetDept->department}}</td>
              <td>{{$c->status}}</td>
              <td>
                <!-- <a href="javascript:void(0)" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a> -->
                @if(in_array('152', $rulesArray))
                <a onclick="EditCourse('{{$c->id}}','{{$c->course}}','{{$c->dept_id}}','{{$c->status}}')" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                @endif
                @if(in_array('153', $rulesArray))
                <a onclick="DeleteCourse('{{$c->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
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

  <!-- Modal Start -->
     <div class="modal fade" id="modaldemo1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Department</label>
                                <select id="dept" class="form-control radius-8">
                                  <option value="">Choose</option>
                                  @foreach($departments as $d)
                                  <option value="{{$d->id}}">{{$d->department}}</option>
                                  @endforeach
                                </select>
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Course</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Course" id="course">
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="AddCourse()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="add-button"> <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Department</label>
                                <input type="hidden" class="form-control radius-8" id="course_id">
                                <select id="dept1" class="form-control radius-8">
                                  <option value="">Choose</option>
                                  @foreach($departments as $d)
                                  <option value="{{$d->id}}">{{$d->department}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Course</label>
                                <input type="hidden" class="form-control radius-8" id="dept_id">
                                <input type="text" class="form-control radius-8" placeholder="Enter Course" id="course1">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                <select id="status" class="form-control radius-8">
                                  <option value="Active">Active</option>
                                  <option value="Blocked">Blocked</option>
                                </select>
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="CourseEdit()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="edit-button"> <i id="edit-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Course</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="course_id1">
                                
                            Do you want to delete this course ?                        
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="CourseDelete()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="del-button"> <i id="del-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
      
      function AddCourse() {
            
            var dept = $('#dept option:selected').val();
            if (dept === '') 
            {
                $('#dept').focus();
                $('#dept').css({'border': '1px solid red'});
                return false;
            } else 
                $('#dept').css({'border': '1px solid #CCC'});

                var course = $('input#course').val();
            if (course === '') 
            {
                $('#course').focus();
                $('#course').css({'border': '1px solid red'});
                return false;
            } else 
                $('#course').css({'border': '1px solid #CCC'});

            $('#add-loader').show();
            $('#add-button').prop('disabled', true);

            var data = new FormData();
            data.append('dept', dept);
            data.append('course', course);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/add-course",
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

  function EditCourse(id,crs, dept, status) {
    $('#modaldemo2').modal('show');
    $('#course_id').val(id);
    $('#dept1').val(dept);
    $('#course1').val(crs);
    $('#status').val(status);
}

function CourseEdit() {
            
            var dept = $('#dept1 option:selected').val();
            if (dept === '') 
            {
                $('#dept1').focus();
                $('#dept1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#dept1').css({'border': '1px solid #CCC'});

        var course = $('input#course1').val();
            if (course === '') 
            {
                $('#course1').focus();
                $('#course1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#course1').css({'border': '1px solid #CCC'});



var course_id = $('input#course_id').val();
var status = $('#status option:selected').val();
            $('#edit-loader').show();
            $('#edit-button').prop('disabled', true);

            var data = new FormData();
            data.append('dept', dept);
            data.append('course', course);
            data.append('course_id', course_id);
            data.append('status', status);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/edit-course",
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

    </script>