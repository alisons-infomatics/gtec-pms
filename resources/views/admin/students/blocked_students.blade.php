@extends('layouts.Admin')

@section('content')

  <div class="dashboard-main-body">

    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Blocked Students</h6>

</div>
    
    <div class="card basic-data-table">
      <div class="card-header">
        <h5 class="card-title mb-0">Blocked Students
<!-- <button type="button" class="btn btn-primary-100 radius-8 px-14 py-6 text-md" style="float: right;color: black !important;" onclick="window.location.href='/admin/add-student'">Add New</button> -->
        </h5><br>
<div class="col-md-2 align-self-end">
      <button type="button" class="btn btn-primary w-100" onclick="openStatusModal()">Bulk Status Update</button>
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
              <th scope="col">Name</th>
              <th scope="col">Department</th>
              <th scope="col">Contact Num</th>
              <th scope="col">REG.No</th>
              <th scope="col">Created On</th>
              <th scope="col">Action</th>
            </tr>
          </thead>
          <tbody>

@foreach($students as $u)
    <tr>
               <td>
  <div class="form-check">
    <input type="checkbox"
           class="form-check-input student-checkbox"
           value="{{ $u->id }}"
           data-name="{{ $u->first_name }} {{ $u->middle_name }} {{ $u->last_name }}"
           data-contact="{{ $u->mobile_code }}{{ $u->mobile }}"
           id="student-{{ $u->id }}">
    <label class="form-check-label" for="student-{{ $u->id }}">
      {{ $loop->iteration }}
    </label>
  </div>
</td>
              <td>{{$u->first_name}} {{$u->middle_name}} {{$u->last_name}}</td>
              <td>{{$u->GetDept->department ?? $u->dept_text}}</td>
              <td>{{$u->mobile_code}}{{$u->mobile}}</td>
               <td>{{$u->reg_num}}</td>
              <td>{{date("d-m-Y", strtotime($u->created_at))}}</td>
              <td>
                <!-- <a href="javascript:void(0)" class="w-32-px h-32-px bg-primary-light text-primary-600 rounded-circle d-inline-flex align-items-center justify-content-center">
                  <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                </a> -->
                <a href="/admin/edit-student/{{$u->id}}" class="w-32-px h-32-px bg-success-focus text-success-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
                  <iconify-icon icon="lucide:edit"></iconify-icon>
                </a>
                <a onclick="DeleteStudent('{{$u->id}}')" class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center" style="cursor: pointer;">
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

<div class="modal fade" id="statusModal" tabindex="-1" aria-labelledby="statusModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content radius-16 bg-base">
            <div class="modal-header py-16 px-24 border-bottom">
                <h5 class="modal-title" id="statusModalLabel">Bulk Status Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-24">
                <form id="statusForm">
                    <input type="hidden" id="status_selected_students" name="selected_students">

                    <div class="mb-3">
                        <h6 class="text-primary mb-2">Selected Students</h6>
                        <div id="status-student-list" class="list-group"
                             style="max-height: 200px; overflow-y: auto; border: 1px solid #ddd; border-radius: 8px; padding: 5px;">
                            <!-- JS will populate -->
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Select Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="">Choose</option>
                            <option value="Live">Live</option>
                            <option value="No Need">No Need</option>
                            <option value="No Response">No Response</option>
                            @if(auth('admin')->check() && auth('admin')->user()->user_type == 1)
                                <option value="Self Placed">Self Placed</option>
                                <option value="Placed">Placed</option>
                            @endif
                            <option value="Blocked">Blocked</option>
                            <!-- Add more if needed -->
                        </select>
                    </div>

                    <div class="text-center mt-4">
                        <button type="button" onclick="updateStatus()" class="btn btn-primary">
                            <i id="status-loader" class="fa fa-spinner fa-spin" style="display: none;"></i>
                            Update Status
                        </button>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Delete student</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-24">
                    <form>
                        <div class="row">   
                            
                                <input type="hidden" class="form-control radius-8" id="user_id1">
                                
                            Do you want to delete this student ?                        
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
      
     
function DeleteStudent(id) {
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
                url: "/admin/delete-student",
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


function openStatusModal() {
    let selected = [];
    let studentListHTML = '';

    document.querySelectorAll('.student-checkbox:checked').forEach(cb => {
        selected.push(cb.value);
        const name = cb.getAttribute('data-name');
        const contact = cb.getAttribute('data-contact');

        studentListHTML += `<div class="list-group-item d-flex justify-content-between">
                                <span>${name}</span>
                                <small class="text-muted">${contact}</small>
                            </div>`;
    });

    if (selected.length === 0) {
        alert("Please select at least one student.");
        return;
    }

    $('#statusModal').modal('show');
    document.getElementById('status_selected_students').value = selected.join(',');
    document.getElementById('status-student-list').innerHTML = studentListHTML;
}

// Optional: clear student list on modal close
document.getElementById('statusModal').addEventListener('hidden.bs.modal', () => {
    document.getElementById('status-student-list').innerHTML = '';
    document.getElementById('status_selected_students').value = '';
    document.getElementById('status').value = '';
});

function updateStatus() {
    const selectedStudents = document.getElementById('status_selected_students').value;
    const status = document.getElementById('status').value;

    if (!status) {
        alert("Please select a status.");
        return;
    }

    document.getElementById('status-loader').style.display = 'inline-block';

    $.ajax({
        url: '/admin/bulk-update-student-status', // set your actual endpoint here
        method: 'POST',
        data: {
            selected_students: selectedStudents,
            status: status,
            _token: '{{ csrf_token() }}'
        },
        success: function (res) {
            document.getElementById('status-loader').style.display = 'none';
            $('#statusModal').modal('hide');
            Swal.fire({
                            text: 'Status updated successfully !',
                            closeOnClickOutside: false,
                            position: 'top-end',
                            icon: 'success',
                            toast: true,
                            showConfirmButton: false,
                            timer: 2000
                        });
            location.reload();
        },
        error: function () {
            document.getElementById('status-loader').style.display = 'none';
            alert("Something went wrong.");
        }
    });
}

    </script>