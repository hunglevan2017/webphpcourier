<!DOCTYPE html>
<html lang="en">
  <head>

    <?php
      require_once("appbar/header.php");
      require_once("function.php");


     ?>
  </head>
  <body class="app sidebar-mini">
    <!-- Sidebar menu-->
    <?php
        require_once("appbar/nav.php");
    ?>
    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i>Contract Monitoring</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Contract Monitoring</a></li>
        </ul>
      </div>

      <div class="row tile">
        <div class="col-md-5 ">
          <div class="form-group row">
              <label class="control-label col-md-2">Date</label>
              <div class="col-md-10">
                <input type="text" autocomplete="off" class="form-control" id="datepicker-monitoring">
              </div>

          </div>
        </div>

        <div class="col-md-2 text-center mb-3">
          <button id="btn-system-monitoring" class="btn btn-info btn-block mb-3">Search</button>
        </div>


        <div class="col-12">
          <div class="overlay loading">
            <div class="m-loader mr-4">
              <svg class="m-circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="4" stroke-miterlimit="10"/>
              </svg>
            </div>
            <h3 class="l-text">Loading</h3>
          </div>
          <div class="bs-component">
            <ul class="nav nav-tabs">
              <li class="nav-item"><a class="nav-link active" data-toggle="tab" href="#sendto247">Send to 247 (API)</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#saleretry">Sale retry</a></li>
              <li class="nav-item"><a class="nav-link" data-toggle="tab" href="#sgbchangestage">SGB change stage</a></li>
            </ul>
            <div class="tab-content" id="myTabContent">
              <div class="tab-pane fade active show" id="sendto247">
                <br/>
                <h4>Summary</h4>
                <div class="table-responsive exportMonitoring" data-title="Summary">
                  <table class="table table-striped" id="table-summary-send-to-247">

                  </table>
                </div>

                <br/>
                <h4>Details</h4>
                <div class="table-responsive exportMonitoring" data-title="Details">
                  <table class="table table-striped" id="table-detail-send-to-247">

                  </table>
                </div>
              </div>


              <div class="tab-pane fade" id="saleretry">
                <br/>
                <h4>Summary</h4>
                <div class="table-responsive exportMonitoring" data-title="Summary">
                  <table class="table table-striped" id="table-summary-sale-retry">

                  </table>
                </div>

                <br/>
                <h4>Details</h4>
                <div class="table-responsive exportMonitoring" data-title="Details">
                  <table class="table table-striped" id="table-detail-sale-retry">

                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="sgbchangestage">
                <br/>
                <h4>Summary</h4>
                <div class="table-responsive exportMonitoring" data-title="Summary">
                  <table class="table table-striped" id="table-summary-sgbchangestage">

                  </table>
                </div>

                <br/>
                <h4>Details</h4>
                <div class="table-responsive exportMonitoring" data-title="Details">
                  <table class="table table-striped" id="table-detail-sgbchangestage">

                  </table>
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>

    </main>
    <?php
      require_once("appbar/footer.php");
     ?>
     <script type="text/javascript" src="js/monitoring.js"></script>
  </body>
</html>
