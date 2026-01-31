
<div class="row row-cols-xxxl-3 row-cols-lg-4 row-cols-sm-2 row-cols-1 gy-2 mt-4">

      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Total Approved Students</p>
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
      <div class="col">
        <div class="card shadow-none border bg-gradient-start-1 h-100">
          <div class="card-body p-20">
            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
              <div>
                <p class="fw-medium text-primary-light mb-1">Interviews Created</p>
                <span>(f)</span>
                <h6 class="mb-0">{{ $interviewsCount }}</h6>
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
                <p class="fw-medium text-primary-light mb-1">Employers Created</p>
                <span>(g)</span>
                <h6 class="mb-0">{{ $empCount }}</h6>
              </div>             
            </div>           
          </div>
        </div>
      </div>
</div><br>