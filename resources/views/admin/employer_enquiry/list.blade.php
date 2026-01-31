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
        <h5 class="card-title ">Employers</h5>
        <div class="row">
                
                    <div class="col-md-8">
                        <form method="GET" action="{{ url('/admin/list-employer-enquiry') }}">
                            <div class="row">
                                <div class="col-md-4">
                                    <select name="filterStatus" class="form-control radius-8" onchange="this.form.submit()">
                                        <option value="">Status Filter</option>
                                        <option value="Follow-up Needed" {{ request('filterStatus') == 'Follow-up Needed' ? 'selected' : '' }}>Follow-up Needed</option>
                                        <option value="No Vacancy" {{ request('filterStatus') == 'No Vacancy' ? 'selected' : '' }}>No Vacancy</option>
                                        <option value="On Hold" {{ request('filterStatus') == 'On Hold' ? 'selected' : '' }}>On Hold</option>
                                        <option value="Not Interested" {{ request('filterStatus') == 'Not Interested' ? 'selected' : '' }}>Not Interested</option>
                                        <option value="Closed" {{ request('filterStatus') == 'Closed' ? 'selected' : '' }}>Closed</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-3">
                                    <input type="date" name="from_date" value="{{ request('from_date') }}" class="form-control radius-8" onchange="this.form.submit()">
                                </div>
                        
                                <div class="col-md-3">
                                    <input type="date" name="to_date" value="{{ request('to_date') }}" class="form-control radius-8" onchange="this.form.submit()">
                                </div>
                                <div class="col-md-2">
                                    <button type="submit" name="export" value="1" class="btn btn-success radius-8 w-100">
                                        Export
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>
                    

                @if(in_array('121', $rulesArray))
                <div class="col-md-4">
                    <!--<label class="d-block">&nbsp;</label>-->
                    <button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo1"><small>Add New Employer</small></button>
                    <button type="button" class="btn me-3 btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" data-bs-effect="effect-super-scaled" data-bs-toggle="modal" href="#modaldemo04"><small>Add Employer Enquiry</small></button>
                </div>
                @endif
        </div>

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
              <th scope="col">Contact</th>
              <th scope="col">Follow Up Date</th>
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
              <td>
                    @if($e->contacts->isNotEmpty())
                        <ul class="mb-0">
                            @foreach ($e->contacts as $contact)
                                <li>
                                    {{ $contact->contact_person }} 
                                    ({{ $contact->mobile }})
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <em>No contacts</em>
                    @endif
              </td>
              <td>
                @if(optional($e->latest_enquiry)?->follow_up_date)
                    {{ \Carbon\Carbon::parse($e->latest_enquiry->follow_up_date)->format('Y-m-d') }}
                @else
                    
                @endif
              </td>
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
     <div class="modal fade" id="modaldemo04" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl modal-dialog modal-dialog-centered">
            <div class="modal-content radius-16 bg-base">
                <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Employer Enquiry Form</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form action="/admin/add-employer-enquiry" method="POST">
                        @csrf
                        <div class="row">   
                            
                            <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Employer *</label>
                                <select name="company" id="company" class="form-control" required onchange="setCompanyDetails()">
                                    <option value="">Choose</option>
                                    @foreach($employers as $emp)
                                        <option 
                                            value="{{ $emp->id }}" 
                                            data-email="{{ $emp->email }}" 
                                            data-location="{{ $emp->address }}"
                                            data-status="{{ $emp->status }}">
                                            {{ $emp->company_name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div> 
                            <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                <input class="form-control" type="email" name="email" id="email" required>
                            </div> 
                            <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Location</label>
                                <input type="text" name="loc" id="loc" class="form-control" required>
                            </div>
                            <h6 style="font-size:18px !important">Contact Informations</h6>  

                            <div class="col-md-4">
                                <label class="form-label">Contact Person *</label>
                                <select name="name" class="form-control cperson" required>
                                  <option value="">Choose</option>
                                </select>
                        
                             </div>
                            <div class="col-md-4">
                                <label class="form-label">Contact Number *</label>
                                <div class="d-flex gap-2">
                                  <select name="mcode" class="form-select" required>
                                    <option value="91">+91</option>
                                  </select>
                                  <input type="number" name="mobile" class="form-control contact-mobile" required>
                        
                                </div>
                             </div>
                            <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Date You contacted *</label>
                                <input type="date" class="form-control radius-8" name="date" id="date" required>
                            </div> 
                            
                            

                            <div class="col-6 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                <select name="status" id="status" class="form-control radius-8" required onChange="statusChange()">
                                  <option value="Active">Opportunity Available</option>
                                  <option value="Follow-up Needed">Follow-up Needed</option>
                                  <option value="No Vacancy">No Vacancy</option>
                                  <option value="On Hold">On Hold</option>
                                  <option value="Not Interested">Not Interested</option>
                                  <option value="Closed">Closed</option>
                                </select>
                            </div>  
                            
                            <div id="nextContactDiv" class="col-6 mt-2" style="display: none;">
                                <label class="form-label">Next Contact Date *</label>
                                <input type="date" name="next_contact_date" class="form-control radius-8">
                            </div>
                            
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Remarks</label>
                                <textarea  class="form-control radius-8" name="remarks" id="remarks"></textarea>
                            </div> 

                            <div class="d-flex align-items-center justify-content-center gap-3 mt-24">
                                
                                <button type="submit"  class="btn btn-primary border border-primary-600 text-md px-48 py-12 radius-8"> 
                                    Submit
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
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
                            <h6 style="font-size:18px !important">Contact Informations</h6>  

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

                              <div class="col-4 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Contact Person</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Name" id="name11">
                            </div> 
                            <div class="col-md-4">
                            <label class="form-label">Phone Number </label>
                            <div class="form-mobile-field has-validation">
                              <select class="form-select" required id="mcode11">
                                <option value="91">91</option>
                              </select>
                              <input type="number" id="mobile11" class="form-control" required>
                            </div>
                          </div>
                               <div class="col-md-4">
                                <label class="form-label">Alternate Phone Number</label>
                                <div class="form-mobile-field has-validation">
                                  <select class="form-select" required id="mcodea11">
                                    <option value="91">91</option>
                                  </select>
                                  <input type="number" id="mobilea11" class="form-control" required>
                                </div>
                              </div> 

                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                <select id="status1" class="form-control radius-8" onChange="statusChange1()">
                                  <option value="Active">Opportunity Available</option>
                                  <option value="Follow-up Needed">Follow-up Needed</option>
                                  <option value="No Vacancy">No Vacancy</option>
                                  <option value="On Hold">On Hold</option>
                                  <option value="Not Interested">Not Interested</option>
                                  <option value="Closed">Closed</option>
                                </select>
                            </div>     
                            <!--<div id="nextContactDiv1" class="col-6 mt-2" style="display: none;">-->
                            <!--    <label class="form-label">Next Contact Date *</label>-->
                            <!--    <input type="date" name="next_contact_date1" id="next_contact_date1" class="form-control radius-8">-->
                            <!--</div>-->
                            <!--<div class="col-6 mb-20">-->
                            <!--    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Remarks</label>-->
                            <!--    <textarea  class="form-control radius-8" name="remarks1" id="remarks1"></textarea>-->
                            <!--</div> -->

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
                                <input type="hidden" class="form-control radius-8" id="emp_id2">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Company Name</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Company Name" id="cname2">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Email</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Email" id="email2">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Address</label>
                                <input type="text" class="form-control radius-8" placeholder="Enter Address" id="address2">
                            </div> 
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Status</label>
                                <select id="status2" class="form-control radius-8">
                                  <option value="Active">Opportunity Available</option>
                                  <option value="Follow-up Needed">Follow-up Needed</option>
                                  <option value="No Vacancy">No Vacancy</option>
                                  <option value="On Hold">On Hold</option>
                                  <option value="Not Interested">Not Interested</option>
                                  <option value="Closed">Closed</option>
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
    function filterStatus(){
        alert("here");
    }
    function statusChange1(){
         var status1 = $('#status1').val();
         
         if (status1 === "Follow-up Needed" || status1 === "On Hold") {
                $('#nextContactDiv1').show();
            } else {
                $('#nextContactDiv1').hide();
            }
    }
    
    function statusChange(){
         var status = $('#status').val();
         
         if (status === "Follow-up Needed" || status === "On Hold") {
                $('#nextContactDiv').show();
            } else {
                $('#nextContactDiv').hide();
            }
    }
      
      function AddEmp() {
            

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

            var name = $('input#name1').val();
            if (name === '') 
            {
                $('#name1').focus();
                $('#name1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#name1').css({'border': '1px solid #CCC'});

                var mcode = $('#mcode1 option:selected').val();  

            var mobile = $('input#mobile1').val();
            if (mobile === '') 
            {
                $('#mobile1').focus();
                $('#mobile1').css({'border': '1px solid red'});
                return false;
            } else 
                $('#mobile1').css({'border': '1px solid #CCC'});

                var mcodea = $('#mcodea1 option:selected').val();
                var mobilea = $('input#mobilea1').val();

                var name1 = $('input#name11').val();
                var mcode1 = $('#mcode11 option:selected').val();
                var mobile1 = $('input#mobile11').val();
                var mcodea1 = $('#mcodea11 option:selected').val();
                var mobilea1 = $('input#mobilea11').val();
                var status = $('#status1').val();
                var next_contact_date = $('#next_contact_date1').val();
                var remarks = $('#remarks1').val();
                
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
            data.append('status', status);
            data.append('next_contact_date', next_contact_date);
            data.append('remarks', remarks);
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
                            text: data.message || 'Given filed already exists!',
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
    $('#emp_id2').val(id);
    $('#cname2').val(cname);
    $('#email2').val(email);
    $('#address2').val(address);
    $('#status2').val(status);
}

function setCompanyDetails() {
    const selectedOption = document.querySelector('#company option:checked');
    const email = selectedOption.getAttribute('data-email') || '';
    const location = selectedOption.getAttribute('data-location') || '';
    const status = selectedOption.getAttribute('data-status') || '';
    
    document.getElementById('email').value = email;
    document.getElementById('loc').value = location;
    document.getElementById('status').value = status;
    
    if (status === "Follow-up Needed" || status === "On Hold") {
                $('#nextContactDiv').show();
            } else {
                $('#nextContactDiv').hide();
            }
    
    const contactPersonSelect = $('.cperson');
    const contactMobileInput = $('.contact-mobile');
    
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
     contactPersonSelect.on('change', function () {
        const selectedMobile = $(this).find('option:selected').data('mobile') || '';
        contactMobileInput.val(selectedMobile);
    });
}

function EmpEdit() {
            
            var cname = $('input#cname2').val();
            if (cname === '') 
            {
                $('#cname2').focus();
                $('#cname2').css({'border': '1px solid red'});
                return false;
            } else 
                $('#cname2').css({'border': '1px solid #CCC'});
                var email = $('input#email2').val();
            if (email === '') 
            {
                $('#email2').focus();
                $('#email2').css({'border': '1px solid red'});
                return false;
            } else 
                $('#email2').css({'border': '1px solid #CCC'});

                var address = $('input#address2').val();
            if (address === '') 
            {
                $('#address2').focus();
                $('#address2').css({'border': '1px solid red'});
                return false;
            } else 
                $('#address2').css({'border': '1px solid #CCC'});

            var emp_id = $('input#emp_id2').val();
            var status = $('#status2 option:selected').val();

            

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
                            text: data.message || 'Given filed already exists!',
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