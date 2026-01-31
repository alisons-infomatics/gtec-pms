@extends('layouts.Admin')

@section('content')
<div class="dashboard-main-body">
  <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Rules</h6>
  </div>

  <div class="card basic-data-table">
    <div class="card-header">
      <h5 class="card-title mb-0">
        Rules
      </h5>
    </div>

    <div class="card-body">
      <form action="/admin/set-rules" method="POST">
        @csrf

        <div class="row">

        <input type="hidden" name="user_type_id" value="{{ $user_type->id }}">
          <!-- Select All -->
          <div class="col-12 mb-4">
            <div class="form-check">
              <input class="form-check-input" type="checkbox" id="select-all">
              <label class="form-check-label fw-bold" for="select-all">
                Select All Permissions
              </label>
            </div>
          </div>

          @php
          $rulesArray = explode(',', $user_type->rules);
          $sections = [
              'student_requests' => 'Student Requests',
              'students' => 'Students',
              'employers' => 'Employers',
              'interviews' => 'Interviews',
              'departments' => 'Master Data - Departments',
              'courses' => 'Master Data - Courses',
              'job_roles' => 'Master Data - Job Roles',
              'user_types' => 'Master Data - User Types'
          ];
          $actions = [
              'view' => '101',
              'add' => '102',
              'edit' => '103',
              'delete' => '104'
              
          ];
          $startCode = 100;
          @endphp

          @foreach ($sections as $sectionKey => $sectionTitle)
          <div class="col-12 mb-4 p-3 border rounded shadow-sm">
            <div class="d-flex justify-content-between align-items-center mb-2">
              <h6 class="fw-bold mb-0" style="font-size:14px !important;">{{ $sectionTitle }}</h6>
              <div class="form-check">
                <input class="form-check-input select-section" type="checkbox" id="select-{{ $sectionKey }}" data-section="{{ $sectionKey }}">
                <label class="form-check-label small" for="select-{{ $sectionKey }}">
                  Select All
                </label>
              </div>
            </div>

            <div class="row">
              @foreach ($actions as $action => $code)
                @php
                  $uniqueCode = $startCode + (array_search($sectionKey, array_keys($sections)) * 10) + (array_search($action, array_keys($actions)));
                @endphp
                <div class="col-md-2 col-6 mb-2">
                  <div class="form-check d-flex align-items-center gap-2">
                    <input class="form-check-input checkbox-{{ $sectionKey }}" type="checkbox" 
                      name="rules[]" 
                      value="{{ $uniqueCode }}" 
                      id="{{ $sectionKey }}-{{ $action }}"
                      {{ in_array($uniqueCode, $rulesArray) ? 'checked' : '' }}>
                    <label class="form-check-label" for="{{ $sectionKey }}-{{ $action }}">
                      {!! getPermissionIcon($action) !!} {{ ucfirst($action) }}
                    </label>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
          @endforeach

          <div class="col-12 text-center mt-4">
            <button type="submit" class="btn btn-primary px-5">Save Permissions</button>
          </div>

        </div>
      </form>
    </div>
  </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

  // Select All functionality
  $('#select-all').on('change', function() {
    $('input[type="checkbox"]').not(this).prop('checked', this.checked);
  });

  // Section wise select all
  $('.select-section').on('change', function() {
    var section = $(this).data('section');
    $('.checkbox-' + section).prop('checked', this.checked);
  });

});
</script>
@endpush

@php
function getPermissionIcon($action) {
    switch ($action) {
        case 'view':
            return '<iconify-icon icon="iconamoon:eye-light"></iconify-icon>';
        case 'add':
            return '<iconify-icon icon="tabler:plus"></iconify-icon>';
        case 'edit':
            return '<iconify-icon icon="lucide:edit"></iconify-icon>';
        case 'delete':
            return '<iconify-icon icon="mingcute:delete-2-line"></iconify-icon>';
        
        default:
            return '';
    }
}
@endphp
