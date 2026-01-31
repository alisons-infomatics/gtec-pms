@extends('layouts.Admin')

@section('content')
  @php

$my_roles=DB::table('user_types')->where('id',auth()->guard('admin')->user()->user_type)->first();
$rulesArray = explode(',', $my_roles->rules);
@endphp
  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Employers</h6>
 
</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <h5 class="card-title mb-0">Employers
        @if(in_array('121', $rulesArray))
<button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1">Add New</button>
       @endif
        </h5>

<form method="GET" action="{{ url()->current() }}" class="mb-4">
  <div class="row g-3">
    <div class="col-md-3 mt-3">
      <label>Last Interview in</label>
      <select name="last_interview" class="form-select">
    <option value="">Choose</option>
    <option value="7" {{ request('last_interview') == '7' ? 'selected' : '' }}>7 Days</option>
    <option value="30" {{ request('last_interview') == '30' ? 'selected' : '' }}>30 Days</option>
    <option value="180" {{ request('last_interview') == '180' ? 'selected' : '' }}>6 Months</option>
    <option value="365" {{ request('last_interview') == '365' ? 'selected' : '' }}>1 Year</option>
</select>

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
              <th scope="col">Email</th>
              <th scope="col">Address</th>
              <th scope="col">Status</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>
              
            

@foreach($employers as $e)
            <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$e->company_name}}</td>
              <td>{{$e->email}}</td>
              <td>{{$e->address}}</td>
              <td>{{$e->status}}</td>
              <td>
                  @if(in_array('122', $rulesArray))
                 <a href="/admin/employer-profile/{{$e->id}}" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a>
                <a onclick="EditEmp('{{$e->id}}','{{$e->company_name}}','{{$e->email}}','{{$e->address}}','{{$e->status}}')" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                @endif
                @if(in_array('123', $rulesArray))
                <a onclick="DeleteEmp('{{$e->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
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
        <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Employer Registration Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Company Name</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Company Name" id="cname">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Email" id="email">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Address</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Address" id="address">
                            </div>
                            <h6 style="font-size:18px !important">Contact Informations</h6>  

                                <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Contact Person</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Name" id="name">
                            </div> 
                            <div class="col-md-4">
                            <label class="form-label">Phone Number </label>
                            <div class="form-mobile-field has-validation">
                              <select class="form-select" required id="mcode">
                                <option value="91">91</option>
                              </select>
                              <input type="number" id="mobile" class="form-control" required>
                            </div>
                          </div>
                               <div class="col-md-4">
                                <label class="form-label">Alternate Phone Number</label>
                                <div class="form-mobile-field has-validation">
                                  <select class="form-select" required id="mcodea">
                                    <option value="91">91</option>
                                  </select>
                                  <input type="number" id="mobilea" class="form-control" required>
                                </div>
                              </div> 

                              <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Contact Person</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Name" id="name1">
                            </div> 
                            <div class="col-md-4">
                            <label class="form-label">Phone Number </label>
                            <div class="form-mobile-field has-validation">
                              <select class="form-select" required id="mcode1">
                                <option value="91">91</option>
                              </select>
                              <input type="number" id="mobile1" class="form-control" required>
                            </div>
                          </div>
                               <div class="col-md-4">
                                <label class="form-label">Alternate Phone Number</label>
                                <div class="form-mobile-field has-validation">
                                  <select class="form-select" required id="mcodea1">
                                    <option value="91">91</option>
                                  </select>
                                  <input type="number" id="mobilea1" class="form-control" required>
                                </div>
                              </div> 




                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="AddEmp()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="add-button"> <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Employer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                            <div class="col-12 mb-20">
                                <input type="hidden" class="form-control radius-8" id="emp_id">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Company Name</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Company Name" id="cname1">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Email" id="email1">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Address</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Address" id="address1">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                <select id="status" class="form-control radius-8">
                                  <option value="Active">Active</option>
                                  <option value="Blocked">Blocked</option>
                                </select>
                            </div>                           
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="EmpEdit()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="edit-button"> <i id="edit-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Employer</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="emp_id1">
                                
                            Do you want to delete this employer ?                        
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="EmpDelete()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="del-button"> <i id="del-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
      
      function AddEmp() {
            

                var cname = $('input#cname').val();
            if (cname === '') 
            {
                $('#cname').focus();
                $('#cname').css({'border': '1px solid red'});
                return false;
            } else 
                $('#cname').css({'border': '1px solid #CCC'});
                var email = $('input#email').val();
            if (email === '') 
            {
                $('#email').focus();
                $('#email').css({'border': '1px solid red'});
                return false;
            } else 
                $('#email').css({'border': '1px solid #CCC'});

                var address = $('input#address').val();
            if (address === '') 
            {
                $('#address').focus();
                $('#address').css({'border': '1px solid red'});
                return false;
            } else 
                $('#address').css({'border': '1px solid #CCC'});

            var name = $('input#name').val();
            if (name === '') 
            {
                $('#name').focus();
                $('#name').css({'border': '1px solid red'});
                return false;
            } else 
                $('#name').css({'border': '1px solid #CCC'});

                var mcode = $('#mcode option:selected').val();  

            var mobile = $('input#mobile').val();
            if (mobile === '') 
            {
                $('#mobile').focus();
                $('#mobile').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobile').css({'border': '1px solid #CCC'});

                var mcodea = $('#mcodea option:selected').val();
                var mobilea = $('input#mobilea').val();

                var name1 = $('input#name1').val();
                var mcode1 = $('#mcode1 option:selected').val();
                var mobile1 = $('input#mobile1').val();
                var mcodea1 = $('#mcodea1 option:selected').val();
                var mobilea1 = $('input#mobilea1').val();


            $('#add-loader').show();
            $('#add-button').prop('disabled', true);

            var data = new FormData();
            data.append('cname', cname);
            data.append('email', email);
            data.append('address', address);
            data.append('name', name);
            data.append('name1', name1);
            data.append('mcode', mcode);
            data.append('mcode1', mcode1);
            data.append('mcodea', mcodea);
            data.append('mcodea1', mcodea1);
            data.append('mobile', mobile);
            data.append('mobile1', mobile1);
            data.append('mobilea', mobilea);
            data.append('mobilea1', mobilea1);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/add-employer",
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
                            text: 'Company name already exists',
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

  function EditEmp(id,cname, email,address, status) {
    $('#modaldemo2').modal('show');
    $('#emp_id').val(id);
    $('#cname1').val(cname);
    $('#email1').val(email);
    $('#address1').val(address);
    $('#status').val(status);
}

function EmpEdit() {
            
            var cname = $('input#cname1').val();
            if (cname === '') 
            {
                $('#cname1').focus();
                $('#cname1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#cname1').css({'border': '1px solid #CCC'});
                var email = $('input#email1').val();
            if (email === '') 
            {
                $('#email1').focus();
                $('#email1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#email1').css({'border': '1px solid #CCC'});

                var address = $('input#address1').val();
            if (address === '') 
            {
                $('#address1').focus();
                $('#address1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#address1').css({'border': '1px solid #CCC'});

            var emp_id = $('input#emp_id').val();
            var status = $('#status option:selected').val();

            

            $('#edit-loader').show();
            $('#edit-button').prop('disabled', true);

            var data = new FormData();
            data.append('cname', cname);
            data.append('email', email);
            data.append('address', address);
            data.append('emp_id', emp_id);
            data.append('status', status);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/edit-employer",
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
                            text: 'Company name already exists',
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


function DeleteEmp(id) {
    $('#modaldemo3').modal('show');
    $('#emp_id1').val(id);
}


function EmpDelete() {
            
var emp_id = $('input#emp_id1').val();
            $('#del-loader').show();
            $('#del-button').prop('disabled', true);

            var data = new FormData();
            data.append('emp_id', emp_id);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/delete-employer",
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
                            text: 'Deletion failed',
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