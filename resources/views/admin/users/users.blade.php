@extends('layouts.Admin')

@section('content')

  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Users</h6>

</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <h5 class="card-title mb-0">Users
<button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1">Add New</button>
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
              <th scope="col">Name</th>
              <th scope="col">User Type</th>
              <th scope="col">Username</th>
              <th scope="col">Departments</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

@foreach($users as $u)
@php
$usr_dep = explode(',', $u->department);
$dept_names = [];

foreach ($usr_dep as $ud) {
    $dept_det = DB::table('departments')->where('id', $ud)->first();
    if ($dept_det) {
        $dept_names[] = $dept_det->department;
    }
}

$department_list = implode(', ', $dept_names);
$department_list = str_replace(',', ',<br>', $department_list);

@endphp
            <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$u->name}}</td>
              <td>{{$u->GetType->user_type}}</td>
              <td>{{$u->username}}</td>
         <td style="">
    {!! $department_list !!}
</td>


              <td>{{$u->status}}</td>
              <td>
                <!-- <a href="javascript:void(0)" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a> -->
                <a onclick="EditUser('{{$u->id}}','{{$u->name}}','{{$u->user_type}}','{{$u->username}}','{{$u->department}}','{{$u->status}}')" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                <a onclick="DeleteUser('{{$u->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
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
     <div class="modal fade" id="modaldemo1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Name</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Name" id="name">
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">User Type</label>
                                <select id="type" class="form-control radius-8">
                                  <option value="">Choose</option>
                                  @foreach($types as $t)
                                  <option value="{{$t->id}}">{{$t->user_type}}</option>
                                  @endforeach
                                </select>
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Departments</label>
                                <select id="deptselect" class=" radius-8" multiple>
                                  <option value="">Choose</option>
                                  @foreach($dept as $d)
                                  <option value="{{$d->id}}">{{$d->department}}</option>
                                  @endforeach
                                </select>
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Username</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Username" id="username">
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Password</label>
                                <input type="password" class="form-control radius-8" placeholder="Enter Password" id="password">
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="AddUser()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="add-button"> <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">
                        <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Name</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Name" id="name1">
                            </div>   
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">User Type</label>
                                <input type="hidden" class="form-control radius-8" id="user_id">
                                <select id="type1" class="form-control radius-8">
                                  <option value="">Choose</option>
                                  @foreach($types as $t)
                                  <option value="{{$t->id}}">{{$t->user_type}}</option>
                                  @endforeach
                                </select>
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Departments</label>
                                <select id="dept1" class="radius-8" multiple>
                                  <option value="">Choose</option>
                                  @foreach($dept as $d)
                                  <option value="{{$d->id}}">{{$d->department}}</option>
                                  @endforeach
                                </select>
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Username</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Username" id="username1">
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Password</label>
                                <input type="password" class="form-control radius-8" placeholder="Enter Password" id="password1">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                <select id="status" class="form-control radius-8">
                                  <option value="Active">Active</option>
                                  <option value="Blocked">Blocked</option>
                                </select>
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="UserEdit()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="edit-button"> <i id="edit-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete User</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="user_id1">
                                
                            Do you want to delete this user ?                        
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
      
      function AddUser() {
            
            var name = $('input#name').val();
            if (name === '') 
            {
                $('#name').focus();
                $('#name').css({'border': '1px solid red'});
                return false;
            } else 
                $('#name').css({'border': '1px solid #CCC'});

                var type = $('#type option:selected').val();
            if (type === '') 
            {
                $('#type').focus();
                $('#type').css({'border': '1px solid red'});
                return false;
            } else 
                $('#type').css({'border': '1px solid #CCC'});

            var dept = $('#deptselect').val();

            if (dept === '') 
            {
                $('#deptselect').focus();
                $('#deptselect').css({'border': '1px solid red'});
                return false;
            } else 
                $('#deptselect').css({'border': '1px solid #CCC'});

            var username = $('input#username').val();
            if (username === '') 
            {
                $('#username').focus();
                $('#username').css({'border': '1px solid red'});
                return false;
            } else 
                $('#username').css({'border': '1px solid #CCC'});

            var password = $('input#password').val();
            if (password === '') 
            {
                $('#password').focus();
                $('#password').css({'border': '1px solid red'});
                return false;
            } else 
                $('#password').css({'border': '1px solid #CCC'});

            $('#add-loader').show();
            $('#add-button').prop('disabled', true);

            var data = new FormData();
            data.append('dept', dept);
            data.append('name', name);
            data.append('type', type);
            data.append('username', username);
            data.append('password', password);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/add-user",
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

function EditUser(id,name, type, uname, dept, status) {
    $('#modaldemo2').modal('show');
    $('#user_id').val(id);
    $('#name1').val(name);
    $('#type1').val(type);
    $('#username1').val(uname);
    $('#password1').val('');
    $('#status').val(status);

    // Ensure `dept` is not null before splitting
    let deptArray = dept ? dept.split(',') : [];

    // Set values in Selectize
    let selectize = $('#dept1')[0].selectize;
    if (selectize) {
        selectize.clear(); // Clear previous selections
        selectize.setValue(deptArray); // Set new values
    }
}




function UserEdit() {
            
    var name = $('input#name1').val();
            if (name === '') 
            {
                $('#name1').focus();
                $('#name1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#name1').css({'border': '1px solid #CCC'});

                var type = $('#type option:selected').val();
        var type = $('#type1 option:selected').val();
            if (type === '') 
            {
                $('#type1').focus();
                $('#type1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#type1').css({'border': '1px solid #CCC'});

         var dept = $('#dept1').val();

            if (dept === '') 
            {
                $('#dept1').focus();
                $('#dept1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#dept1').css({'border': '1px solid #CCC'});

            var username = $('input#username1').val();
            if (username === '') 
            {
                $('#username1').focus();
                $('#username1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#username1').css({'border': '1px solid #CCC'});

var password = $('input#password1').val();
var user_id = $('input#user_id').val();
var status = $('#status option:selected').val();
            $('#edit-loader').show();
            $('#edit-button').prop('disabled', true);

            var data = new FormData();
            data.append('dept', dept);
            data.append('name', name);
            data.append('username', username);
            data.append('password', password);
            data.append('type', type);
            data.append('user_id', user_id);
            data.append('status', status);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/edit-user",
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


function DeleteUser(id) {
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
                url: "/admin/delete-user",
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