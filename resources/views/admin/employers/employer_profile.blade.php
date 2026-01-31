@extends('layouts.Admin')

@section('content')
    
    <div class="dashboard-main-body">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">View Profile</h6>
  <ul class="d-flex align-items-center gap-2">
    <li class="fw-medium">
      <a href="index.html" class="d-flex align-items-center gap-1 hover-text-primary">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li>-</li>
    <li class="fw-medium">View Profile</li>
  </ul>
</div>

        <div class="row gy-4">
            <div class="col-lg-4">
                <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                    <br><br><br><br><br>
                    <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                        <div class="text-center border border-top-0 border-start-0 border-end-0">
                            <img src="{{asset('/img/usr.jpg')}}" alt="" class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                            <h6 class="mb-0 mt-16">{{$employer->company_name}}</h6>
                            <span class="text-secondary-light mb-16">{{$employer->email}}</span>
                        </div>
                        <div class="mt-24">
                           
                            <div>Created by : {{ $employer->createdBy->name ?? " " }}</div>
                            <h6 class="text-xl mb-16">Personal Info</h6>
                            <ul>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Company</span>
                                    <span class="w-70 text-secondary-light fw-medium">:{{$employer->company_name}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Address</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$employer->address}}</span>
                                </li>
                                
                                
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="card h-100">
                    <div class="card-body p-24">
                        <ul class="nav border-gradient-tab nav-pills mb-20 d-inline-flex" id="pills-tab" role="tablist">
                        <!-- <li class="nav-item" role="presentation">
                              <button class="nav-link d-flex align-items-center px-24 active" id="pills-change-passwork-tab" data-bs-toggle="pill" data-bs-target="#pills-change-passwork" type="button" role="tab" aria-controls="pills-change-passwork" aria-selected="true" tabindex="-1">
                                Interviews 
                              </button>
                            </li> -->
                            <li class="nav-item" role="presentation">
                              <button class="nav-link d-flex align-items-center px-24 active" id="pills-edit-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-edit-profile" type="button" role="tab" aria-controls="pills-edit-profile" aria-selected="false">
                                Contact Information 
                              </button>
                            </li>
                           
                            <!-- <li class="nav-item" role="presentation">
                              <button class="nav-link d-flex align-items-center px-24" id="pills-notification-tab" data-bs-toggle="pill" data-bs-target="#pills-notification" type="button" role="tab" aria-controls="pills-notification" aria-selected="false" tabindex="-1">
                                Notification Settings
                              </button>
                            </li> -->
                        </ul>

                        <div class="tab-content" id="pills-tabContent">   
                            <div class="tab-pane fade show active" id="pills-edit-profile" role="tabpanel" aria-labelledby="pills-edit-profile-tab" tabindex="0">
<button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1">Add Contact</button><br><br>

                            <ul>
                                @foreach($employer_contact as $ec)
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light">Contact Person</span>
                                    <span class="w-70 text-secondary-light fw-medium">:{{$ec->contact_person}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Contact Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$ec->mobile_code}}{{$ec->mobile}}</span>
                                </li>
                                <li class="d-flex align-items-center gap-1 mb-12">
                                    <span class="w-30 text-md fw-semibold text-primary-light"> Alternate Number</span>
                                    <span class="w-70 text-secondary-light fw-medium">: {{$ec->alternate_mobile_code}}{{$ec->alternate_mobile}}</span>
                                </li>
                                <a onclick="EditContact('{{$ec->id}}','{{$ec->contact_person}}','{{$ec->mobile_code}}','{{$ec->mobile}}','{{$ec->alternate_mobile_code}}','{{$ec->alternate_mobile}}')" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                <a onclick="DeleteContact('{{$ec->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                </a><br><br>
                                <hr>
                                @endforeach
                                                       
                               </ul>

                            </div>

                      
                            <div class="tab-pane fade" id="pills-change-passwork" role="tabpanel" aria-labelledby="pills-change-passwork-tab" tabindex="0">
                           
                            <div class="card-header">
        <h5 class="card-title mb-0">Interview Details
<!-- <button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1">Add Interview</button> -->
        </h5>

      </div>
                            <div class="card-body mt-3">
        
      </div>
      </div>
  
                            </div>

                            <div class="tab-pane fade" id="pills-notification" role="tabpanel" aria-labelledby="pills-notification-tab" tabindex="0" hidden>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="companzNew" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Company News</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="companzNew">
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="pushNotifcation" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Push Notification</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="pushNotifcation" checked>
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="weeklyLetters" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Weekly News Letters</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="weeklyLetters" checked>
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="meetUp" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Meetups Near you</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="meetUp">
                                    </div>
                                </div>
                                <div class="form-switch switch-primary py-12 px-16 border radius-8 position-relative mb-16">
                                    <label for="orderNotification" class="position-absolute w-100 h-100 start-0 top-0"></label>
                                    <div class="d-flex align-items-center gap-3 justify-content-between">
                                        <span class="form-check-label line-height-1 fw-medium text-secondary-light">Orders Notifications</span>
                                        <input class="form-check-input" type="checkbox" role="switch" id="orderNotification" checked>
                                    </div>
                                </div>
                            </div>


                            

                        </div>
                        
                    </div>
                    
                </div>
                
            </div>
<br>
@isset($enquiries)
<div class="card basic-data-table mt-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Enquiry History
        </h5>
      </div>
      <div class="card-body">
        <table class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Employer</th>
                                        <th>Contact Person</th>
                                        <th>Contact Number</th>
                                        <th>Contact Date</th>
                                        <th>Status</th>
                                        <th>NXT Date</th>
                                        <th>Remarks</th>
                                        <th>Created By</th>
                                        <th>Created At</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($enquiries as $key => $enquiry)
                                        <tr>
                                            <td>{{ $key + 1 }}</td>
                                            <td>{{ $enquiry->employer_name }}</td>
                                            <td>{{ $enquiry->contact_person }}</td>
                                            <td>{{ $enquiry->contact_number }}</td>
                                            <td>{{ $enquiry->contact_date }}</td>
                                            <td>{{ $enquiry->status }}</td>
                                            <td>{{ $enquiry->follow_up_date ?? "N/A" }}</td>
                                            <td>{{ $enquiry->remarks }}</td>
                                            <td>{{ $enquiry->created_by_name }}</td>
                                            <td>{{ \Carbon\Carbon::parse($enquiry->created_at)->format('d-m-Y') }}</td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No enquiries found.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
      </div>
    </div>
    <br>
    @endisset()
    <div class="card basic-data-table mt-4">
      <div class="card-header">
        <h5 class="card-title mb-0">Interview Details
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
              <th scope="col">Title</th>
              <th scope="col">Role</th>
              <th scope="col">Vaccancies</th>
              <th scope="col">Contact Person</th>
              <th scope="col">Contact Number</th>
              <th scope="col">Date</th>
            </tr>
          </thead>
          <tbody>

@foreach($interview as $e)
            <tr>
              <td>
                <div class="form-check style-check d-flex align-items-center">
                  <!-- <input class="form-check-input" type="checkbox"> -->
                  <label class="form-check-label">
                    {{$loop->iteration}}
                  </label>
                </div>
              </td>
              <td>{{$e->GetRole->title}}</td>
              <td>{{$e->GetEmp->company_name}}</td>
              <td>{{$e->GetRole->vacancy}}</td>
              <td>{{$e->GetRole->contact_person}}</td>
              <td>{{$e->GetRole->contact_code}}{{$e->GetRole->contact_num}}</td>
              <td>{{date("d-m-Y", strtotime($e->interview_date))}}</td>
              
            </tr>
@endforeach

            
          </tbody>
        </table>
      </div>
    </div>
  </div>
            
        </div>

        

    </div>



    <div class="modal fade" id="modaldemo1" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-md modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Add Contact</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <div id="contactErrorMsg" class="text-danger" style="display: none;"></div>
                    <form>
                        <div class="row"> 
                        <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Contact Person</label>
                                <input type="text" class="form-control radius-8" placeholder="Contact Person" id="pname">
                            </div> 
                            
                            <div class="col-md-12 mb-20">
                            <label class="form-label">Phone Number </label>
                            <div class="form-mobile-field has-validation">
                              <select class="form-select" required id="mcode">
                                <option value="91">91</option>
                              </select>
                              <input type="number" id="mobile" class="form-control" required>
                            </div>
                          </div>
                               <div class="col-md-12 mb-20">
                                <label class="form-label">Alternate Phone Number</label>
                                <div class="form-mobile-field has-validation">
                                  <select class="form-select" required id="mcodea">
                                    <option value="91">91</option>
                                  </select>
                                  <input type="number" id="mobilea" class="form-control" required>
                                </div>
                              </div>                          
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="AddContact()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="add-button"> <i id="add-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Interview</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row"> 
                        
                        <input type="hidden" class="form-control radius-8" placeholder="Enter Interview Date" id="contact_id">
                                
                        <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Contact Person</label>
                                <input type="text" class="form-control radius-8" placeholder="Contact Person" id="pname1">
                            </div> 
                            
                            <div class="col-md-12 mb-20">
                            <label class="form-label">Phone Number </label>
                            <div class="form-mobile-field has-validation">
                              <select class="form-select" required id="mcode1">
                                <option value="91">91</option>
                              </select>
                              <input type="number" id="mobile1" class="form-control" required>
                            </div>
                          </div>
                               <div class="col-md-12 mb-20">
                                <label class="form-label">Alternate Phone Number</label>
                                <div class="form-mobile-field has-validation">
                                  <select class="form-select" required id="mcodea1">
                                    <option value="91">91</option>
                                  </select>
                                  <input type="number" id="mobilea1" class="form-control" required>
                                </div>
                              </div>  

                                                 
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="ContactEdit()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="edit-button"> <i id="edit-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete Contact</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="contact_id1">
                                
                            Do you want to delete this contact ?                        
                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="button" onclick="ContactDelete()" class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8" id="del-button"> <i id="del-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    @endsection


    <script type="text/javascript">


function AddContact() {
            
            var pname = $('input#pname').val();
            if (pname === '') 
            {
                $('#pname').focus();
                $('#pname').css({'border': '1px solid red'});
                return false;
            } else 
                $('#pname').css({'border': '1px solid #CCC'});

                var mcode = $('#mcode option:selected').val();
            if (mcode === '') 
            {
                $('#mcode').focus();
                $('#mcode').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mcode').css({'border': '1px solid #CCC'});

                var mobile = $('input#mobile').val();
            if (mobile === '') 
            {
                $('#mobile').focus();
                $('#mobile').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobile').css({'border': '1px solid #CCC'});

                var mcodea = $('#mcodea option:selected').val();
            if (mcodea === '') 
            {
                $('#mcodea').focus();
                $('#mcodea').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mcodea').css({'border': '1px solid #CCC'});

                var mobilea = $('input#mobilea').val();
            if (mobilea === '') 
            {
                $('#mobilea').focus();
                $('#mobilea').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobilea').css({'border': '1px solid #CCC'});

            $('#add-loader').show();
            $('#add-button').prop('disabled', true);

            var data = new FormData();
            data.append('pname', pname);
            data.append('mcode', mcode);
            data.append('mobile', mobile);
            data.append('mcodea', mcodea);
            data.append('mobilea', mobilea);
            data.append('emp_id', '{{$employer->id}}');
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/add-contact",
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
                            text: data.message || 'Contact already exists!',
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

        function EditContact(id, name, m1, m2, m3, m4) {
          
    $('#modaldemo2').modal('show');
    $('#contact_id').val(id);
    $('#pname1').val(name);
    $('#mcode1').val(m1);
    $('#mobile1').val(m2);
    $('#mcodea1').val(m3);
    $('#mobilea1').val(m4);
}


function ContactEdit() {
            
    var pname = $('input#pname1').val();
            if (pname === '') 
            {
                $('#pname1').focus();
                $('#pname1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#pname1').css({'border': '1px solid #CCC'});

                var mcode = $('#mcode1 option:selected').val();
            if (mcode === '') 
            {
                $('#mcode1').focus();
                $('#mcode1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mcode1').css({'border': '1px solid #CCC'});

                var mobile = $('input#mobile1').val();
            if (mobile === '') 
            {
                $('#mobile1').focus();
                $('#mobile1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobile1').css({'border': '1px solid #CCC'});

                var mcodea = $('#mcodea1 option:selected').val();
            if (mcodea === '') 
            {
                $('#mcodea1').focus();
                $('#mcodea1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mcodea1').css({'border': '1px solid #CCC'});

                var mobilea = $('input#mobilea1').val();
            if (mobilea === '') 
            {
                $('#mobilea1').focus();
                $('#mobilea1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobilea1').css({'border': '1px solid #CCC'});
                var contact_id = $('input#contact_id').val();

            $('#edit-loader').show();
            $('#edit-button').prop('disabled', true);

            var data = new FormData();
            data.append('pname', pname);
            data.append('mcode', mcode);
            data.append('mobile', mobile);
            data.append('mcodea', mcodea);
            data.append('mobilea', mobilea);
            data.append('contact_id', contact_id);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/edit-contact",
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


function DeleteContact(id) {
    $('#modaldemo3').modal('show');
    $('#contact_id1').val(id);
}


function ContactDelete() {
            
var contact_id = $('input#contact_id1').val();
            $('#del-loader').show();
            $('#del-button').prop('disabled', true);

            var data = new FormData();
            data.append('contact_id', contact_id);
            data.append('_token', '{{ csrf_token() }}');

            $.ajax({
                type: "POST",
                url: "/admin/delete-contact",
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

    </script>
