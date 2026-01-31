@extends('layouts.Admin')

@section('content')
  
  <div class="dashboard-main-body">
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
  <h6 class="fw-semibold mb-0">Dashboard</h6>
  <ul class="d-flex align-items-center gap-2">
    <li class="fw-medium">
      <a href="" class="d-flex align-items-center gap-1 hover-text-primary">
        <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
        Dashboard
      </a>
    </li>
    <li></li>
    <li class="fw-medium"></li>
  </ul>
</div>
<!-- first card -->

    <div class="row row-cols-xxxl-3 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-2">
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Registered Students</p>
                <span>(a+c+d+e)</span>
                <h6 class="mb-0">{{$std->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Live Students</p>
                <span>(a)</span>
                <h6 class="mb-0">{{$std->where('status','Live')->whereNotNull('approve_date')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Placed Students</p>
                <span>(b)</span>
                <h6 class="mb-0">{{$std->where('status','Placed')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Placement Percentage</p>
                <span>(b/a)*100 %</span>
                <h6 class="mb-0">{{ number_format($fullLivePlacedPercentage, 2) }} %<h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">No Need Students</p>
                <span>(c)</span>
                <h6 class="mb-0">{{$std->where('status','No Need')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">No Response Students</p>
                <span>(d)</span>
                <h6 class="mb-0">{{$std->where('status','No Response')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Self Placed Students</p>
                <span>(e)</span>
                <h6 class="mb-0">{{$std->where('status','Self Placed')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
</div><br>
<!-- first card -->   
 <h6>Monthwise Data</h6>
<!-- Monthly Report -->
<form method="GET" action="{{ url('admin/dashboard') }}" class="row g-3 mb-4">
    <div class="col-md-3">
      From Date
        <input type="date" name="start_date" value="{{ $sdt }}" class="form-control" placeholder="Start Date" required>
    </div>
    <div class="col-md-3">
      To Date
        <input type="date" name="end_date" value="{{ $edt }}" class="form-control" placeholder="End Date" required>
    </div>
    <div class="col-md-3">
      Department
        <select class="form-control" id="dept" name="dept">
        <option value="All" @if($cdept=='All') selected @endif>All</option>
        @foreach($dept as $d)
        <option value="{{$d->id}}" @if($cdept==$d->id) selected @endif>{{$d->department}}</option>
        @endforeach

        </select>
    </div>
    <div class="col-md-2">
      <br>
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div class="row row-cols-xxxl-3 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-2 mt-4">



      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Registered Students</p>
                <span>(a+c+d+e)</span>
                <h6 class="mb-0">{{$filteredStd->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Live Students</p>
                <span>(a)</span>
                <h6 class="mb-0">{{$filteredStd->where('status','Live')->whereNotNull('approve_date')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>

      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Placed Students</p>
                <span>(b)</span>
                <h6 class="mb-0">{{$filteredStd->where('status','Placed')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Placement Percentage</p>
                <span>(b/a)*100 %</span>
                <h6 class="mb-0">{{ number_format($filteredLivePlacedPercentage, 2) }} %<h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">No Need Students</p>
                <span>(c)</span>
                <h6 class="mb-0">{{$filteredStd->where('status','No Need')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">No Response Students</p>
                <span>(d)</span>
                <h6 class="mb-0">{{$filteredStd->where('status','No Response')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Self Placed Students</p>
                <span>(e)</span>
                <h6 class="mb-0">{{$filteredStd->where('status','Self Placed')->count()}}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
</div><br>

<!-- Monthly Report -->

@if($counsilers != ' ')
 
 <h6>Counsellor Report</h6>
<!-- Monthly Report -->
<form id="filterForm" class="row g-3 mb-4">
    <div class="col-md-3">
      From Date
        <input type="date" name="start_date" value="{{ $sdt }}" class="form-control" placeholder="Start Date" required>
    </div>
    <div class="col-md-3">
      To Date
        <input type="date" name="end_date" value="{{ $edt }}" class="form-control" placeholder="End Date" required>
    </div>
    <div class="col-md-3">
      Counsellor
        <select class="form-control" id="counsilers" name="counsilers">
        <option value="All" >All</option>
        @foreach($counsilers as $counsiler)
            <option value="{{ $counsiler->id }}">
                {{ $counsiler->name }}
            </option>
        @endforeach

        </select>
    </div>
    <div class="col-md-3">
    Department
        <select class="form-control" id="counsiler_departments" name="departments">
            <option value="All">All</option>
        </select>
    </div>

    <div class="col-md-2">
      <br>
        <button type="submit" class="btn btn-primary w-100">Filter</button>
    </div>
</form>

<div id="filteredResults" class="mt-4">
    <p>Search With a Counsellor</p>
</div>



@endif

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function () {
        $('#filterForm').on('submit', function (e) {
        e.preventDefault();

        $.ajax({
            url: "{{ route('counsiler.report') }}", 
            type: 'GET',
            data: $(this).serialize(),
            beforeSend: function () {
                $('#filteredResults').html('<p>Loading...</p>');
            },
            success: function (response) {
                $('#filteredResults').html(response);
            },
            error: function () {
                $('#filteredResults').html('<p class="text-danger">Something went wrong.</p>');
            }
        });
    });
    
    $('#counsilers').on('change', function () {
        const counsilerId = $(this).val();

        if (counsilerId && counsilerId !== 'All') {
            $.ajax({
                url: `/admin/get-counsiler-departments/${counsilerId}`,
                type: 'GET',
                success: function (response) {
                    const departmentDropdown = $('#counsiler_departments');
                    departmentDropdown.empty();
                    departmentDropdown.append('<option value="All">All</option>');
                    $.each(response, function (key, department) {
                        departmentDropdown.append(`<option value="${department.id}">${department.department}</option>`);
                    });
                }
            });
        } else {
            $('#counsiler_departments').empty().append('<option value="">Select Department</option>');
        }
    });
});

</script>











   

      



      
      

















      <!-- //////////////////////////////////////////////////////////////////////////////////////////////// -->

    <div class="row gy-4 mt-1" hidden>
      <div class="col-xxl-6 col-xl-12">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex flex-wrap align-items-center justify-content-between">
              <h6 class="text-lg mb-0">Sales Statistic</h6>
              <select class="form-select bg-base form-select-sm w-auto radius-8">
                <option>Yearly</option>
                <option>Monthly</option>
                <option>Weekly</option>
                <option>Today</option>
              </select>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-2 mt-8">
              <h6 class="mb-0">$27,200</h6>
              <span class="text-sm fw-semibold rounded-pill bg-success-focus text-success-main border br-success px-8 py-4 line-height-1 d-flex align-items-center gap-1">
                10% <iconify-icon icon="bxs:up-arrow" class="text-xs"></iconify-icon>
              </span>
              <span class="text-xs fw-medium">+ $1500 Per Day</span>
            </div>
            <div id="chart" class="pt-28 apexcharts-tooltip-style-1"></div>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-xl-6">
        <div class="card h-100 radius-8 border">
          <div class="card-body p-24">
              <h6 class="mb-12 fw-semibold text-lg mb-16">Total Subscriber</h6>
              <div class="d-flex align-items-center gap-2 mb-20">
                  <h6 class="fw-semibold mb-0">5,000</h6>
                  <p class="text-sm mb-0">
                      <span class="bg-danger-focus border br-danger px-8 py-2 rounded-pill fw-semibold text-danger-main text-sm d-inline-flex align-items-center gap-1">
                          10%
                          <iconify-icon icon="iconamoon:arrow-down-2-fill" class="icon"></iconify-icon>  
                      </span> 
                    - 20 Per Day 
                  </p>
              </div>

              <div id="barChart" class="barChart"></div>
            
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-xl-6">
        <div class="card h-100 radius-8 border-0 overflow-hidden">
          <div class="card-body p-24">
            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
              <h6 class="mb-2 fw-bold text-lg">Users Overview</h6>
              <div class="">
                <select class="form-select form-select-sm w-auto bg-base border text-secondary-light radius-8">
                  <option>Today</option>
                  <option>Weekly</option>
                  <option>Monthly</option>
                  <option>Yearly</option>
                </select>
              </div>
            </div>


            <div id="userOverviewDonutChart" class="apexcharts-tooltip-z-none"></div>

            <ul class="d-flex flex-wrap align-items-center justify-content-between mt-3 gap-3">
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px radius-2 bg-primary-600"></span>
                  <span class="text-secondary-light text-sm fw-normal">New: 
                      <span class="text-primary-light fw-semibold">500</span>
                  </span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px radius-2 bg-yellow"></span>
                  <span class="text-secondary-light text-sm fw-normal">Subscribed:  
                      <span class="text-primary-light fw-semibold">300</span>
                  </span>
              </li>
            </ul>
            
          </div>
        </div>
      </div>
      <div class="col-xxl-9 col-xl-12">
        <div class="card h-100">
            <div class="card-body p-24">

              <div class="d-flex flex-wrap align-items-center gap-1 justify-content-between mb-16">
                <ul class="nav border-gradient-tab nav-pills mb-0" id="pills-tab" role="tablist">
                  <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center active" id="pills-to-do-list-tab" data-bs-toggle="pill" data-bs-target="#pills-to-do-list" type="button" role="tab" aria-controls="pills-to-do-list" aria-selected="true">
                      Latest Registered 
                      <span class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">35</span>
                    </button>
                  </li>
                  <li class="nav-item" role="presentation">
                    <button class="nav-link d-flex align-items-center" id="pills-recent-leads-tab" data-bs-toggle="pill" data-bs-target="#pills-recent-leads" type="button" role="tab" aria-controls="pills-recent-leads" aria-selected="false" tabindex="-1">
                      Latest Subscribe 
                      <span class="text-sm fw-semibold py-6 px-12 bg-neutral-500 rounded-pill text-white line-height-1 ms-12 notification-alert">35</span>
                    </button>
                  </li>
                </ul>
                <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                  View All
                  <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
                </a>
              </div>

              <div class="tab-content" id="pills-tabContent">   
                <div class="tab-pane fade show active" id="pills-to-do-list" role="tabpanel" aria-labelledby="pills-to-do-list-tab" tabindex="0">
                  <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">Users </th>
                          <th scope="col">Registered On</th>
                          <th scope="col">Plan</th>
                          <th scope="col" class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Dianne Russell</h6>
                                <span class="text-sm text-secondary-light fw-medium">redaniel@gmail.com</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Free</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user2.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Wade Warren</h6>
                                <span class="text-sm text-secondary-light fw-medium">xterris@gmail.com</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Basic</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user3.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Albert Flores</h6>
                                <span class="text-sm text-secondary-light fw-medium">seannand@mail.ru</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Standard</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user4.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Bessie Cooper </h6>
                                <span class="text-sm text-secondary-light fw-medium">igerrin@gmail.com</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Business</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user5.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Arlene McCoy</h6>
                                <span class="text-sm text-secondary-light fw-medium">fellora@mail.ru</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Enterprise </td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane fade" id="pills-recent-leads" role="tabpanel" aria-labelledby="pills-recent-leads-tab" tabindex="0">
                  <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                      <thead>
                        <tr>
                          <th scope="col">Users </th>
                          <th scope="col">Registered On</th>
                          <th scope="col">Plan</th>
                          <th scope="col" class="text-center">Status</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Dianne Russell</h6>
                                <span class="text-sm text-secondary-light fw-medium">redaniel@gmail.com</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Free</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user2.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Wade Warren</h6>
                                <span class="text-sm text-secondary-light fw-medium">xterris@gmail.com</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Basic</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user3.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Albert Flores</h6>
                                <span class="text-sm text-secondary-light fw-medium">seannand@mail.ru</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Standard</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user4.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Bessie Cooper </h6>
                                <span class="text-sm text-secondary-light fw-medium">igerrin@gmail.com</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Business</td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                        <tr>
                          <td>
                            <div class="d-flex align-items-center">
                              <img src="assets/images/users/user5.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                              <div class="flex-grow-1">
                                <h6 class="text-md mb-0 fw-medium">Arlene McCoy</h6>
                                <span class="text-sm text-secondary-light fw-medium">fellora@mail.ru</span>
                              </div>
                            </div>
                          </td>
                          <td>27 Mar 2024</td>
                          <td>Enterprise </td>
                          <td class="text-center"> 
                            <span class="bg-success-focus text-success-main px-24 py-4 rounded-pill fw-medium text-sm">Active</span> 
                          </td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
      <div class="col-xxl-3 col-xl-12">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
              <h6 class="mb-2 fw-bold text-lg mb-0">Top Performer</h6>
              <a href="javascript:void(0)" class="text-primary-600 hover-text-primary d-flex align-items-center gap-1">
                View All
                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon"></iconify-icon>
              </a>
            </div>

            <div class="mt-32">

              <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                <div class="d-flex align-items-center">
                  <img src="assets/images/users/user1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                  <div class="flex-grow-1">
                    <h6 class="text-md mb-0 fw-medium">Dianne Russell</h6>
                    <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                  </div>
                </div>
                <span class="text-primary-light text-md fw-medium">$20</span>
              </div>

              <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                <div class="d-flex align-items-center">
                  <img src="assets/images/users/user2.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                  <div class="flex-grow-1">
                    <h6 class="text-md mb-0 fw-medium">Wade Warren</h6>
                    <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                  </div>
                </div>
                <span class="text-primary-light text-md fw-medium">$20</span>
              </div>

              <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                <div class="d-flex align-items-center">
                  <img src="assets/images/users/user3.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                  <div class="flex-grow-1">
                    <h6 class="text-md mb-0 fw-medium">Albert Flores</h6>
                    <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                  </div>
                </div>
                <span class="text-primary-light text-md fw-medium">$30</span>
              </div>

              <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                <div class="d-flex align-items-center">
                  <img src="assets/images/users/user4.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                  <div class="flex-grow-1">
                    <h6 class="text-md mb-0 fw-medium">Bessie Cooper</h6>
                    <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                  </div>
                </div>
                <span class="text-primary-light text-md fw-medium">$40</span>
              </div>

              <div class="d-flex align-items-center justify-content-between gap-3 mb-24">
                <div class="d-flex align-items-center">
                  <img src="assets/images/users/user5.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                  <div class="flex-grow-1">
                    <h6 class="text-md mb-0 fw-medium">Arlene McCoy</h6>
                    <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                  </div>
                </div>
                <span class="text-primary-light text-md fw-medium">$10</span>
              </div>

              <div class="d-flex align-items-center justify-content-between gap-3">
                <div class="d-flex align-items-center">
                  <img src="assets/images/users/user1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden">
                  <div class="flex-grow-1">
                    <h6 class="text-md mb-0 fw-medium">Arlene McCoy</h6>
                    <span class="text-sm text-secondary-light fw-medium">Agent ID: 36254</span>
                  </div>
                </div>
                <span class="text-primary-light text-md fw-medium">$10</span>
              </div>

            </div>
            
          </div>
        </div>
      </div>
      <div class="col-xxl-6 col-xl-12">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between mb-20">
              <h6 class="mb-2 fw-bold text-lg mb-0">Top Countries</h6>
                <select class="form-select form-select-sm w-auto bg-base border text-secondary-light radius-8">
                  <option>Today</option>
                  <option>Weekly</option>
                  <option>Monthly</option>
                  <option>Yearly</option>
                </select>
            </div>

            <div class="row gy-4">
              <div class="col-lg-6">
                <div id="world-map" class="h-100 border radius-8"></div>
              </div>

              <div class="col-lg-6">
                <div class="h-100 border p-16 pe-0 radius-8">
                  <div class="max-h-266-px overflow-y-auto scroll-sm pe-16">
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12 pb-2">
                      <div class="d-flex align-items-center w-100">
                          <img src="assets/images/flags/flag1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12">
                        <div class="flex-grow-1">
                          <h6 class="text-sm mb-0">USA</h6>
                          <span class="text-xs text-secondary-light fw-medium">1,240 Users</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2 w-100">
                        <div class="w-100 max-w-66 ms-auto">
                          <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-primary-600 rounded-pill" style="width: 80%;"></div>
                          </div>
                        </div>
                        <span class="text-secondary-light font-xs fw-semibold">80%</span>
                      </div>
                    </div>
      
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12 pb-2">
                      <div class="d-flex align-items-center w-100">
                          <img src="assets/images/flags/flag2.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12">
                        <div class="flex-grow-1">
                          <h6 class="text-sm mb-0">Japan</h6>
                          <span class="text-xs text-secondary-light fw-medium">1,240 Users</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2 w-100">
                        <div class="w-100 max-w-66 ms-auto">
                          <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-orange rounded-pill" style="width: 60%;"></div>
                          </div>
                        </div>
                        <span class="text-secondary-light font-xs fw-semibold">60%</span>
                      </div>
                    </div>
      
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12 pb-2">
                      <div class="d-flex align-items-center w-100">
                          <img src="assets/images/flags/flag3.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12">
                        <div class="flex-grow-1">
                          <h6 class="text-sm mb-0">France</h6>
                          <span class="text-xs text-secondary-light fw-medium">1,240 Users</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2 w-100">
                        <div class="w-100 max-w-66 ms-auto">
                          <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-yellow rounded-pill" style="width: 49%;"></div>
                          </div>
                        </div>
                        <span class="text-secondary-light font-xs fw-semibold">49%</span>
                      </div>
                    </div>
      
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12 pb-2">
                      <div class="d-flex align-items-center w-100">
                          <img src="assets/images/flags/flag4.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12">
                        <div class="flex-grow-1">
                          <h6 class="text-sm mb-0">Germany</h6>
                          <span class="text-xs text-secondary-light fw-medium">1,240 Users</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2 w-100">
                        <div class="w-100 max-w-66 ms-auto">
                          <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-success-main rounded-pill" style="width: 100%;"></div>
                          </div>
                        </div>
                        <span class="text-secondary-light font-xs fw-semibold">100%</span>
                      </div>
                    </div>
      
                    <div class="d-flex align-items-center justify-content-between gap-3 mb-12 pb-2">
                      <div class="d-flex align-items-center w-100">
                          <img src="assets/images/flags/flag5.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12">
                        <div class="flex-grow-1">
                          <h6 class="text-sm mb-0">South Korea</h6>
                          <span class="text-xs text-secondary-light fw-medium">1,240 Users</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2 w-100">
                        <div class="w-100 max-w-66 ms-auto">
                          <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-info-main rounded-pill" style="width: 30%;"></div>
                          </div>
                        </div>
                        <span class="text-secondary-light font-xs fw-semibold">30%</span>
                      </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-between gap-3">
                      <div class="d-flex align-items-center w-100">
                          <img src="assets/images/flags/flag1.png" alt="" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12">
                        <div class="flex-grow-1">
                          <h6 class="text-sm mb-0">USA</h6>
                          <span class="text-xs text-secondary-light fw-medium">1,240 Users</span>
                        </div>
                      </div>
                      <div class="d-flex align-items-center gap-2 w-100">
                        <div class="w-100 max-w-66 ms-auto">
                          <div class="progress progress-sm rounded-pill" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
                            <div class="progress-bar bg-primary-600 rounded-pill" style="width: 80%;"></div>
                          </div>
                        </div>
                        <span class="text-secondary-light font-xs fw-semibold">80%</span>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

      <div class="col-xxl-6">
        <div class="card h-100">
          <div class="card-body">
            <div class="d-flex align-items-center flex-wrap gap-2 justify-content-between">
              <h6 class="mb-2 fw-bold text-lg mb-0">Generated Content</h6>
              <select class="form-select form-select-sm w-auto bg-base border text-secondary-light radius-8">
                <option>Today</option>
                <option>Weekly</option>
                <option>Monthly</option>
                <option>Yearly</option>
              </select>
            </div>

            <ul class="d-flex flex-wrap align-items-center mt-3 gap-3">
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px rounded-circle bg-primary-600"></span>
                  <span class="text-secondary-light text-sm fw-semibold">Word: 
                      <span class="text-primary-light fw-bold">500</span>
                  </span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <span class="w-12-px h-12-px rounded-circle bg-yellow"></span>
                  <span class="text-secondary-light text-sm fw-semibold">Image:  
                      <span class="text-primary-light fw-bold">300</span>
                  </span>
              </li>
            </ul>

            <div class="mt-40">
              <div id="paymentStatusChart" class="margin-16-minus"></div>
            </div>
            
          </div>
        </div>
      </div>
    </div>
  </div>

  @endsection