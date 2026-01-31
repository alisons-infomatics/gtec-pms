<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>G-TEC PMS</title>
  <link rel="icon" type="image/png" href="{{asset('/admin/assets/images/favicon.png')}}" sizes="16x16">
  
  <!-- remix icon font css  -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/remixicon.css')}}">
  <!-- BootStrap css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/bootstrap.min.css')}}">
  <!-- Apex Chart css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/apexcharts.css')}}">
  <!-- Data Table css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/dataTables.min.css')}}">
  <!-- Text Editor css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/editor-katex.min.css')}}">
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/editor.atom-one-dark.min.css')}}">
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/editor.quill.snow.css')}}">
  <!-- Date picker css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/flatpickr.min.css')}}">
  <!-- Calendar css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/full-calendar.css')}}">
  <!-- Vector Map css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/jquery-jvectormap-2.0.5.css')}}">
  <!-- Popup css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/magnific-popup.css')}}">
  <!-- Slick Slider css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/slick.css')}}">
  <!-- prism css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/prism.css')}}">
  <!-- file upload css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/file-upload.css')}}">
  
  <link rel="stylesheet" href="{{asset('/admin/assets/css/lib/audioplayer.css')}}">
  <!-- main css -->
  <link rel="stylesheet" href="{{asset('/admin/assets/css/style.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
<link href="https://cdn.jsdelivr.net/npm/selectize/dist/css/selectize.css" rel="stylesheet">
</head>
  <body>
<aside class="sidebar">
  <button type="button" class="sidebar-close-btn">
    <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
  </button>
  <div>
    <a href="/admin/dashboard" class="sidebar-logo">
      <img src="{{asset('/admin/assets/images/logo.png')}}" alt="site logo" class="light-logo">
      <img src="{{asset('/admin/assets/images/logo.png')}}" alt="site logo" class="dark-logo">
      <img src="{{asset('/admin/assets/images/logo.png')}}" alt="site logo" class="logo-icon">
    </a>
  </div>
  <div class="sidebar-menu-area">
    <ul class="sidebar-menu" id="sidebar-menu">

      <li>
        <a href="/admin/dashboard">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Dashboard</span>
        </a>
      </li>
      
      @if(auth()->guard('admin')->user()->id==1)
      
      <li class="sidebar-menu-group-title">Users</li>

      <li>
        <a href="/admin/users">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Users</span>
        </a>
      </li>
      @endif

@php

$my_roles=DB::table('user_types')->where('id',auth()->guard('admin')->user()->user_type)->first();
$rulesArray = explode(',', $my_roles->rules);
@endphp
      
@if(in_array('130', $rulesArray))
      <li class="sidebar-menu-group-title">Interviews</li>

      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Interviews</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="/admin/pending-interviews"><i class="ri-circle-fill circle-icon w-auto"></i> Pending</a>
          </li>
          <li>
            <a href="/admin/shortlisted-interviews"><i class="ri-circle-fill circle-icon w-auto"></i> Short Listed</a>
          </li>
          <li>
            <a href="/admin/placed-interviews"><i class="ri-circle-fill circle-icon w-auto"></i> Placed</a>
          </li>
          <li>
            <a href="/admin/rejected-interviews"><i class="ri-circle-fill circle-icon w-auto"></i> Rejected</a>
          </li>
          
          
        </ul>
      </li>
      
    @endif  

      <li class="sidebar-menu-group-title">Students</li>
@if(in_array('101', $rulesArray))
<li>
        <a href="/admin/add-student">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Add New</span>
        </a>
      </li>
      @endif
      @if(in_array('100', $rulesArray))
      <li>
        <a href="/admin/approval-pending-students">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Approval Pending</span>
        </a>
      </li>
      @endif
      @if(in_array('110', $rulesArray))
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Students</span>
        </a>
        <ul class="sidebar-submenu">
          <li>
            <a href="/admin/live-students"><i class="ri-circle-fill circle-icon w-auto"></i> Live</a>
          </li>
          <li>
            <a href="/admin/no-response-students"><i class="ri-circle-fill circle-icon w-auto"></i> No Response</a>
          </li>
          <li>
            <a href="/admin/self-placed-students"><i class="ri-circle-fill circle-icon w-auto"></i> Self Placed</a>
          </li>
          <li>
            <a href="/admin/no-need-students"><i class="ri-circle-fill circle-icon w-auto"></i> No Need</a>
          </li>
          <li>
            <a href="/admin/blocked-students"><i class="ri-circle-fill circle-icon w-auto"></i> Blocked</a>
          </li>
          <li>
            <a href="/admin/placed-students"><i class="ri-circle-fill circle-icon w-auto"></i> Placed</a>
          </li>
          
        </ul>
      </li>
      @endif

     <!--  <li>
        <a href="/admin/active-students">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Active</span>
        </a>
      </li>
      <li>
        <a href="/admin/completed-students">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Completed</span>
        </a>
      </li>
      <li>
        <a href="/admin/blocked-students">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Blocked</span>
        </a>
      </li> -->
@if(in_array('120', $rulesArray))
      <li class="sidebar-menu-group-title">Employers</li>

      <li>
        <a href="/admin/employers">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Employers</span>
        </a>
      </li>
      @endif

      <li class="sidebar-menu-group-title">Job Role Status</li>

      <li>
        <a href="/admin/add-job-role">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Add</span>
        </a>
      </li>
      
      <li>
        <a href="/admin/job-roles-list">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Open List</span>
        </a>
      </li>
      <li>
        <a href="/admin/closed-job-roles-list">
          <iconify-icon icon="mage:email" class="menu-icon"></iconify-icon>
          <span>Closed List</span>
        </a>
      </li>

<li class="sidebar-menu-group-title">Master Data</li>
      <li class="dropdown">
        <a href="javascript:void(0)">
          <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
          <span>Master Data</span>
        </a>
        <ul class="sidebar-submenu">
            @if(in_array('140', $rulesArray))
          <li>
            <a href="/admin/departments"><i class="ri-circle-fill circle-icon w-auto"></i> Departments</a>
          </li>
          @endif
          @if(in_array('150', $rulesArray))
          <li>
            <a href="/admin/courses"><i class="ri-circle-fill circle-icon w-auto"></i> Courses</a>
          </li>
          @endif
          @if(in_array('160', $rulesArray))
          <li>
            <a href="/admin/job-roles"><i class="ri-circle-fill circle-icon w-auto"></i> Job Roles</a>
          </li>
          @endif
          @if(in_array('170', $rulesArray))
          <li>
            <a href="/admin/user-types"><i class="ri-circle-fill circle-icon w-auto"></i> User Types</a>
          </li>
          @endif
        </ul>
      </li>
      
     
     
        </ul>
      </li>
    </ul>
  </div>
</aside>

<main class="dashboard-main">
  <div class="navbar-header">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <div class="d-flex flex-wrap align-items-center gap-4">
        <button type="button" class="sidebar-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
          <iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
        </button>
        <button type="button" class="sidebar-mobile-toggle">
          <iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
        </button>
        <form class="navbar-search" hidden>
          <input type="text" name="search" placeholder="Search">
          <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
        </form>
      </div>
    </div>
    <div class="col-auto">
      <div class="d-flex flex-wrap align-items-center gap-3">
        <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button>
        <div class="dropdown d-none d-sm-inline-block" hidden>
          <!-- <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
            <img src="assets/images/lang-flag.png" alt="image" class="w-24 h-24 object-fit-cover rounded-circle">
          </button> -->
          <div class="dropdown-menu to-top dropdown-menu-sm">
            <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
              <div>
                <h6 class="text-lg text-primary-light fw-semibold mb-0">Choose Your Language</h6>
              </div>
            </div>

            <div class="max-h-400-px overflow-y-auto scroll-sm pe-8">
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="english"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag1.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">English</span>
                  </span>
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="english">
              </div>
  
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="japan"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag2.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">Japan</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="japan">
              </div>
              
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="france"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag3.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">France</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="france">
              </div>
              
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="germany"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag4.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">Germany</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="germany">
              </div>
              
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="korea"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag5.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">South Korea</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="korea">
              </div>
              
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="bangladesh"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag6.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">Bangladesh</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="bangladesh">
              </div>
              
              <div class="form-check style-check d-flex align-items-center justify-content-between mb-16">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="india"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag7.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">India</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="india">
              </div>
              <div class="form-check style-check d-flex align-items-center justify-content-between">
                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="canada"> 
                  <span class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                    <img src="assets/images/flags/flag8.png" alt="" class="w-36-px h-36-px bg-success-subtle text-success-main rounded-circle flex-shrink-0">
                    <span class="text-md fw-semibold mb-0">Canada</span>
                  </span>  
                </label>
                <input class="form-check-input" type="radio" name="crypto" id="canada">
              </div>
            </div>
          </div>
        </div><!-- Language dropdown end -->

        <div class="dropdown">
          <!-- <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
            <iconify-icon icon="mage:email" class="text-primary-light text-xl"></iconify-icon>
          </button> -->
          <div class="dropdown-menu to-top dropdown-menu-lg p-0">
            <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
              <div>
                <h6 class="text-lg text-primary-light fw-semibold mb-0">Message</h6>
              </div>
              <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">05</span>
            </div>
            
           <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
            
            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-40-px h-40-px rounded-circle flex-shrink-0 position-relative">
                  <img src="assets/images/notification/profile-3.png" alt="">
                  <span class="w-8-px h-8-px bg-success-main rounded-circle position-absolute end-0 bottom-0"></span>
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Kathryn Murphy</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-100-px">hey! there i’m...</p>
                </div>
              </div>
              <div class="d-flex flex-column align-items-end"> 
                <span class="text-sm text-secondary-light flex-shrink-0">12:30 PM</span>
                <span class="mt-4 text-xs text-base w-16-px h-16-px d-flex justify-content-center align-items-center bg-warning-main rounded-circle">8</span>
              </div>
            </a>

            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-40-px h-40-px rounded-circle flex-shrink-0 position-relative">
                  <img src="assets/images/notification/profile-4.png" alt="">
                  <span class="w-8-px h-8-px  bg-neutral-300 rounded-circle position-absolute end-0 bottom-0"></span>
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Kathryn Murphy</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-100-px">hey! there i’m...</p>
                </div>
              </div>
              <div class="d-flex flex-column align-items-end"> 
                <span class="text-sm text-secondary-light flex-shrink-0">12:30 PM</span>
                <span class="mt-4 text-xs text-base w-16-px h-16-px d-flex justify-content-center align-items-center bg-warning-main rounded-circle">2</span>
              </div>
            </a>

            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-40-px h-40-px rounded-circle flex-shrink-0 position-relative">
                  <img src="assets/images/notification/profile-5.png" alt="">
                  <span class="w-8-px h-8-px bg-success-main rounded-circle position-absolute end-0 bottom-0"></span>
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Kathryn Murphy</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-100-px">hey! there i’m...</p>
                </div>
              </div>
              <div class="d-flex flex-column align-items-end"> 
                <span class="text-sm text-secondary-light flex-shrink-0">12:30 PM</span>
                <span class="mt-4 text-xs text-base w-16-px h-16-px d-flex justify-content-center align-items-center bg-neutral-400 rounded-circle">0</span>
              </div>
            </a>

            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-40-px h-40-px rounded-circle flex-shrink-0 position-relative">
                  <img src="assets/images/notification/profile-6.png" alt="">
                  <span class="w-8-px h-8-px bg-neutral-300 rounded-circle position-absolute end-0 bottom-0"></span>
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Kathryn Murphy</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-100-px">hey! there i’m...</p>
                </div>
              </div>
              <div class="d-flex flex-column align-items-end"> 
                <span class="text-sm text-secondary-light flex-shrink-0">12:30 PM</span>
                <span class="mt-4 text-xs text-base w-16-px h-16-px d-flex justify-content-center align-items-center bg-neutral-400 rounded-circle">0</span>
              </div>
            </a>

            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-40-px h-40-px rounded-circle flex-shrink-0 position-relative">
                  <img src="assets/images/notification/profile-7.png" alt="">
                  <span class="w-8-px h-8-px bg-success-main rounded-circle position-absolute end-0 bottom-0"></span>
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Kathryn Murphy</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-100-px">hey! there i’m...</p>
                </div>
              </div>
              <div class="d-flex flex-column align-items-end"> 
                <span class="text-sm text-secondary-light flex-shrink-0">12:30 PM</span>
                <span class="mt-4 text-xs text-base w-16-px h-16-px d-flex justify-content-center align-items-center bg-warning-main rounded-circle">8</span>
              </div>
            </a>

           </div>
            <div class="text-center py-12 px-16"> 
                <a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">See All Message</a>
            </div>
          </div>
        </div><!-- Message dropdown end -->

        <div class="dropdown">
          <!-- <button class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center" type="button" data-bs-toggle="dropdown">
            <iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
          </button> -->
          <div class="dropdown-menu to-top dropdown-menu-lg p-0">
            <div class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
              <div>
                <h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
              </div>
              <span class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">05</span>
            </div>
            
           <div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                  <iconify-icon icon="bitcoin-icons:verify-outline" class="icon text-xxl"></iconify-icon>
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Congratulations</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-200-px">Your profile has been Verified. Your profile has been Verified</p>
                </div>
              </div>
              <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
            </a>
            
            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                  <img src="assets/images/notification/profile-1.png" alt="">
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Ronald Richards</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-200-px">You can stitch between artboards</p>
                </div>
              </div>
              <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
            </a>
            
            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                  AM
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Arlene McCoy</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to prototyping</p>
                </div>
              </div>
              <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
            </a>

            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                  <img src="assets/images/notification/profile-2.png" alt="">
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Annette Black</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to prototyping</p>
                </div>
              </div>
              <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
            </a>

            <a href="javascript:void(0)" class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
              <div class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"> 
                <span class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
                  DR
                </span> 
                <div>
                  <h6 class="text-md fw-semibold mb-4">Darlene Robertson</h6>
                  <p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to prototyping</p>
                </div>
              </div>
              <span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
            </a>
           </div>

            <div class="text-center py-12 px-16"> 
                <a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">See All Notification</a>
            </div>

          </div>
        </div><!-- Notification dropdown end -->

        <!--<div class="dropdown">-->
        <!--  <button class="d-flex justify-content-center align-items-center rounded-circle" type="button" data-bs-toggle="dropdown">-->
        <!--    <img src="{{asset('/img/usr.jpg')}}" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">-->
        <!--  </button>-->
        <!--  <div class="dropdown-menu to-top dropdown-menu-sm">-->
        <!--    <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">-->
        <!--      <div>-->
        <!--        <h6 class="text-lg text-primary-light fw-semibold mb-2">{{auth()->guard('admin')->user()->name}}</h6>-->

        <!--        <span class="text-secondary-light fw-medium text-sm">{{auth()->guard('admin')->user()->GetType->user_type}}</span>-->
        <!--      </div>-->
        <!--      <button type="button" class="hover-text-danger">-->
        <!--        <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon> -->
        <!--      </button>-->
        <!--    </div>-->
        <!--    <ul class="to-top-list">-->
              <!-- <li>
        <!--        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="view-profile.html"> -->
        <!--        <iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>  My Profile</a>-->
        <!--      </li> -->
              <!-- <li>
        <!--        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="email.html"> -->
        <!--        <iconify-icon icon="tabler:message-check" class="icon text-xl"></iconify-icon>  Inbox</a>-->
        <!--      </li> -->
              <!-- <li>
        <!--        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3" href="company.html"> -->
        <!--        <iconify-icon icon="icon-park-outline:setting-two" class="icon text-xl"></iconify-icon>  Change Password</a>-->
        <!--      </li> -->
        <!--      <li>-->
        <!--        <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3" href="/admin/logout"> -->
        <!--        <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon>  Log Out</a>-->
        <!--      </li>-->
        <!--    </ul>-->
        <!--  </div>-->
        <!--</div><!-- Profile dropdown end -->
        <div class="dropdown position-relative">
          <button id="dropdownToggle" class="d-flex justify-content-center align-items-center rounded-circle" type="button">
            <img src="{{asset('/img/usr.jpg')}}" alt="image" class="w-40-px h-40-px object-fit-cover rounded-circle">
          </button>
        
          <div id="dropdownMenu" class="dropdown-menu to-top dropdown-menu-sm" style="display: none; position: absolute; top: 100%; right: 0; z-index: 1050;">
            <div class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
              <div>
                <h6 class="text-lg text-primary-light fw-semibold mb-2">{{ auth()->guard('admin')->user()->name }}</h6>
                <span class="text-secondary-light fw-medium text-sm">{{ auth()->guard('admin')->user()->GetType->user_type }}</span>
              </div>
              <button type="button" class="hover-text-danger" id="dropdownClose">
                <iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
              </button>
            </div>
            <ul class="to-top-list">
              <li>
                <a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3" href="/admin/logout">
                  <iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> Log Out
                </a>
              </li>
            </ul>
          </div>
        </div>
        
        <script>
          document.addEventListener('DOMContentLoaded', function () {
            const toggle = document.getElementById('dropdownToggle');
            const menu = document.getElementById('dropdownMenu');
            const closeBtn = document.getElementById('dropdownClose');
        
            toggle.addEventListener('click', function (e) {
              e.stopPropagation(); 
              menu.style.display = (menu.style.display === 'none' || menu.style.display === '') ? 'block' : 'none';
            });
        
            closeBtn.addEventListener('click', function () {
              menu.style.display = 'none';
            });
        
            // Close when clicking outside
            document.addEventListener('click', function () {
              menu.style.display = 'none';
            });
          });
        </script>

      </div>
    </div>
  </div>
</div> 




@yield('content')




<footer class="d-footer">
  <div class="row align-items-center justify-content-between">
    <div class="col-auto">
      <p class="mb-0">© 2025 G-TEC PMS. All Rights Reserved.</p>
    </div>
    <div class="col-auto">
      <p class="mb-0">Made by <span class="text-primary-600">Alisons Infomatics</span></p>
    </div>
  </div>
</footer>
</main>
  
  <!-- jQuery library js -->
  <script src="{{asset('/admin/assets/js/lib/jquery-3.7.1.min.js')}}"></script>
  <!-- Bootstrap js -->
  <script src="{{asset('/admin/assets/js/lib/bootstrap.bundle.min.js')}}"></script>
  <!-- Apex Chart js -->
  <script src="{{asset('/admin/assets/js/lib/apexcharts.min.js')}}"></script>
  <!-- Data Table js -->
  <script src="{{asset('/admin/assets/js/lib/dataTables.min.js')}}"></script>
  <!-- Iconify Font js -->
  <script src="{{asset('/admin/assets/js/lib/iconify-icon.min.js')}}"></script>
  <!-- jQuery UI js -->
  <script src="{{asset('/admin/assets/js/lib/jquery-ui.min.js')}}"></script>
  <!-- Vector Map js -->
  <script src="{{asset('/admin/assets/js/lib/jquery-jvectormap-2.0.5.min.js')}}"></script>
  <script src="{{asset('/admin/assets/js/lib/jquery-jvectormap-world-mill-en.js')}}"></script>
  <!-- Popup js -->
  <script src="{{asset('/admin/assets/js/lib/magnifc-popup.min.js')}}"></script>
  <!-- Slick Slider js -->
  <script src="{{asset('/admin/assets/js/lib/slick.min.js')}}"></script>
  <!-- prism js -->
  <script src="{{asset('/admin/assets/js/lib/prism.js')}}"></script>
  <!-- file upload js -->
  <script src="{{asset('/admin/assets/js/lib/file-upload.js')}}"></script>
  <!-- audioplayer -->
  <script src="{{asset('/admin/assets/js/lib/audioplayer.js')}}"></script>
  
  <!-- main js -->
  <script src="{{asset('/admin/assets/js/app.js')}}"></script>

<script src="{{asset('/admin/assets/js/homeOneChart.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/selectize/dist/js/standalone/selectize.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@stack('scripts')

<script>

   $(document).ready(function() {
       
       

    let table = new DataTable('#dataTable', {
    ordering: false,      // 🔥 disable sorting
    responsive: true      // 🔥 make table responsive
});

$('.select2').selectize({
      placeholder: "Select options",
      allowClear: true
    });

        $('#deptselect').selectize({
        create: false, // Disable custom entry
        placeholder: "Choose Departments",
        plugins: ['remove_button'],
        allowEmptyOption: false
    });

        $('#dept1').selectize({
        create: false, // Disable custom entry
        placeholder: "Choose Departments",
        plugins: ['remove_button'],
        allowEmptyOption: false
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
 
  


 $('#jdept').on('change', function () {
    const selectedDepts = $(this).val();
    GetCrs(selectedDepts);
});

</script>
<script>
    $(document).ready(function () {
        $('#bulk_attendance').on('change', function () {
            const value = $(this).val();
            
            if (value === 'Attended') {
                $('#bulk_status_field').show();
                $('#status').attr('required', true);
            } else {
                $('#bulk_status_field').hide();
                $('#status').removeAttr('required').val('');
            }
        });
    
        // Trigger on load if pre-selected
        $('#bulk_attendance').trigger('change');
    });

</script>
<script>
    const courseOptions = {
        
        "Plus Two": ["Biology Science", "Computer Science", "Commerce", "Humanities"],
        "Bachelor's": ["BSc Physics", "BSc Chemistry", "BCom", "BA English", "BTech", "BCA"],
        "Diploma": ["Diploma in Civil", "Diploma in Mechanical", "Diploma in Electrical"],
        "Master's": ["MSc Physics", "MSc CS", "MCom", "MA English", "MBA", "MCA"],
        "PhD": ["PhD in Physics", "PhD in Management", "PhD in Literature"]
    };

    $(document).ready(function () {
        // Initialize Selectize
        const $qualificationSelect = $('#qualifications_select').selectize({
            maxItems: null
        });

        const $courseSelect = $('#courses_select').selectize({
            maxItems: null,
            options: [],
            valueField: 'value',
            labelField: 'text',
            searchField: 'text',
        });

        const courseSelectize = $courseSelect[0].selectize;

        $('#qualifications_select').on('change', function () {
            const selected = $(this).val() || [];

            if(selected != "High School"){
                if (selected.length === 0) {
                    $('#courses_wrapper').hide();
                    courseSelectize.clearOptions();
                    return;
                }
    
                let courses = [];
    
                selected.forEach(q => {
                    if (courseOptions[q]) {
                        courses = [...courses, ...courseOptions[q]];
                    }
                });
    
                courses = [...new Set(courses)];
                
                // Update the Selectize options
                courseSelectize.clearOptions();
    
                courses.forEach(course => {
                    courseSelectize.addOption({ value: course, text: course });
                });
                
                courseSelectize.refreshOptions(false);
                $('#courses_wrapper').show();
            }
        });
        
        
    });
</script>


</body>
</html>