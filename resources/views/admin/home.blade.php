@extends('admin.layout')
@section('title')
    <title>Dashboard</title>
@endsection
@section('content')
<style media="screen">
  @media (max-width: 924px) {
    .chart-buttons{
      margin-top: 7% !important;

    }
    .sty{
      margin-top: 10px;
    }
  }

  @media (max-width: 760px){
    .chart-buttons{
      margin-top: 7% !important;

    }

  }
  .chart-buttons
  {
    margin-top: 2%;
  }
.card-stats p {
  color: white !important;
}
.card-stats {
  border-radius: 6px;
}
.chart-buttons .btn:focus {
  box-shadow: none !important;
}
</style>
<h3>Dashboard</h3>
<div class="main-panel">
  <!-- Navbar
  <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
    <div class="container-fluid">
      <div class="navbar-wrapper">
        <div class="navbar-toggle">
          <button type="button" class="navbar-toggler">
            <span class="navbar-toggler-bar bar1"></span>
            <span class="navbar-toggler-bar bar2"></span>
            <span class="navbar-toggler-bar bar3"></span>
          </button>
        </div>
        <a class="navbar-brand" href="#pablo">Home</a>
      </div>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
        <span class="navbar-toggler-bar navbar-kebab"></span>
      </button>
      <div class="collapse navbar-collapse justify-content-end" id="navigation">

        <ul class="navbar-nav">

          <li class="nav-item btn-rotate dropdown">
            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <p>
                <span class="d-lg-none d-md-block">Some Actions</span>
              </p>
            </a>
            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
              <a class="dropdown-item" href="{{ url('dashboard/logout') }}">Logout</a>
            </div>
          </li>

        </ul>
      </div>
    </div>
  </nav>
  End Navbar -->
  <!-- <div class="panel-header panel-header-lg">

<canvas id="bigDashboardChart"></canvas>


</div> -->
  <div class="content">
    <div class="row">
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 sty">
        <div class="card card-stats" style="background: #824cde;">
          <div class="card-body ">
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="numbers">
                  <p class="card-title text-center">{{$all_user}}
                  <p class="card-category text-center">Total Users</p>
                    <p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 sty">
        <div class="card card-stats" style="background:#ef6e84;">
          <div class="card-body ">
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="numbers">
                  <p class="card-category text-center">{{$today_user}}</p>
                  <p class="card-title text-center">New Users Today
                    <p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 sty">
        <div class="card card-stats" style="background: #e28637;">
          <div class="card-body ">
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="numbers">
                  <p class="card-category text-center">{{$online_user}}</p>
                  <p class="card-title text-center">Online Now
                    <p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-3 col-md-6 col-sm-6 col-12 sty">
        <div class="card card-stats" style="background: #4040d2;">
          <div class="card-body ">
            <div class="row">
              <div class="col-12 col-md-12">
                <div class="numbers">
                  <p class="card-category text-center">{{$message}}</p>
                  <p class="card-title text-center">Messages
                    <p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="chart-buttons mar" style="position:absolute;top: 40%;right: 3%;z-index: 9;">
      <a href="#" id="day_btn" class="btn" style="color: black !important;">Day</a>
      <a href="#" id="week_btn" class="btn" style="color: black !important;">Week</a>
      <a href="#" id="month_btn" class="btn" style="color: black !important;">Month</a>
    </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row" id="today_user" style="margin-top: 20px;">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Todays Users</h5>
            <!-- <p class="card-category">Patners Registered</p> -->
          </div>
          <div class="card-body ">
            <canvas id=chartHours width="400" height="100"></canvas>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <div class="legend">
                <i class="fa fa-circle text-success"></i> User
              <!-- <i class="fa fa-circle" style="color: #fcc468;"></i> Most successful -->
              <!-- <i class="fa fa-circle text-danger"></i> Unsuccessfull -->
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row" id="weekly_user" style="margin-top: 20px;display:none;">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Weekly Users</h5>
            <!-- <p class="card-category">Patners Registered</p> -->
          </div>
          <div class="card-body ">
            <canvas id=chartHours_weekly width="400" height="100"></canvas>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <div class="legend">
                <i class="fa fa-circle text-success"></i> User
              <!-- <i class="fa fa-circle" style="color: #fcc468;"></i> Most successful -->
              <!-- <i class="fa fa-circle text-danger"></i> Unsuccessfull -->
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
    <div class="row" id="monthly_user" style="margin-top: 20px;display:none;">
      <div class="col-md-12">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Monthly Users</h5>
            <!-- <p class="card-category">Patners Registered</p> -->
          </div>
          <div class="card-body ">
            <canvas id=chartHours_monthly width="400" height="100"></canvas>
          </div>
          <div class="card-footer ">
            <hr>
            <div class="stats">
              <div class="legend">
                <i class="fa fa-circle text-success"></i> User
              <!-- <i class="fa fa-circle" style="color: #fcc468;"></i> Most successful -->
              <!-- <i class="fa fa-circle text-danger"></i> Unsuccessfull -->
            </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>
    <!-- <div class="row">
      <div class="col-md-4">
        <div class="card ">
          <div class="card-header ">
            <h5 class="card-title">Quotes</h5>
            <p class="card-category">Total quotes</p>
          </div>
          <div class="card-body ">
            <canvas id="chartEmail"></canvas>
          </div>
          <div class="card-footer ">
            <div class="legend">
              <i class="fa fa-circle text-primary"></i> Won
              <i class="fa fa-circle text-warning"></i> Pending
              <i class="fa fa-circle text-danger"></i> Rejected
            </div>
            <hr>
            <div class="stats">
              <i class="fa fa-calendar"></i> Number of quotes
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-8">
        <div class="card card-chart">
          <div class="card-header">
            <h5 class="card-title">Payments</h5>
            <p class="card-category">Line Chart with Points</p>
          </div>
          <div class="card-body">
            <canvas id="speedChart" width="400" height="100"></canvas>
          </div>
          <div class="card-footer">
            <div class="chart-legend">
              <i class="fa fa-circle text-info"></i> Quotation
              <i class="fa fa-circle text-warning"></i> Membership
            </div>
            <hr/>
            <div class="card-stats">
              <i class="fa fa-check"></i> Data information certified
            </div>
          </div>
        </div>
      </div>
      <div class="col-md-12" style="display:none;">
        <div class="card card-chart">
          <div class="card-header">
            <h5 class="card-title">Company Sale</h5>
            <p class="card-category">Line Chart with Points</p>
          </div>
          <div class="card-body">
            <canvas id="speedChartCompany" width="400" height="100"></canvas>
          </div>
          <div class="card-footer">
            <div class="chart-legend">
              <i class="fa fa-circle text-info"></i> Tesla Model S
              <i class="fa fa-circle text-warning"></i> BMW 5 Series
            </div>
            <hr/>
            <div class="card-stats">
              <i class="fa fa-check"></i> Data information certified
            </div>
          </div>
        </div>
      </div>
    </div> -->
  </div>

</div>
@endsection
@section('javascript')
<script>
  $('#day_btn').on('click',function () {
    // alert("daily");
    $('#today_user').show();
    $('#weekly_user').hide();
    $('#monthly_user').hide();
      $('html, body').animate({
          scrollTop: $('#today_user').offset().top
      }, 'slow');
  });
  $('#week_btn').on('click',function () {
    // alert("week");
    $('#today_user').hide();
    $('#weekly_user').show();
    $('#monthly_user').hide();
      $('html, body').animate({
          scrollTop: $('#weekly_user').offset().top
      }, 'slow');
  });
  $('#month_btn').on('click',function () {
    // alert("month");
    $('#today_user').hide();
    $('#weekly_user').hide();
    $('#monthly_user').show();
      $('html, body').animate({
          scrollTop: $('#monthly_user').offset().top
      }, 'slow');
  });
</script>
@endsection
