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
          <h1><i class="fa fa-dashboard"></i>Daily Report - Team Printing</h1>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="#">Daily Report - Team Printing</a></li>
        </ul>
      </div>

      <div class="row tile">
        <div class="col-5 mb-3">
          <div class="form-group row">
              <label class="control-label col-md-2">Month</label>
              <div class="col-md-10">
                <input type="text" autocomplete="off" class="form-control" id="datepicker">
              </div>
          </div>
        </div>

        <div class="col-5 ">
          <div class="form-group row">
              <label class="control-label col-md-4">Delivery vendor</label>
              <div class="col-md-8 boder-select">
                <select class="form-control" id="delivery-vendor" multiple="multiple">
                  <option value="247">247</option>
                </select>
              </div>
          </div>
        </div>

        <div class="col-md-2 text-center">
          <button id="btn-daily-report-team-printing" class="btn btn-info btn-block mb-3">Search</button>
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

          <button id="exportExcelTeamPrinting" class="btn btn-primary mt-3" style="float:right">Export to excel</button>
          <br/>
          <br/>
          <h4>General</h4>
          <div class="table-responsive exportTeamPrinting" data-title="General">
            <table class="table table-striped" id="table-general">

            </table>
          </div>

          <br/>
          <h4>PDOC From FEC</h4>
          <div class="table-responsive exportTeamPrinting" data-title="PDOC From FEC">
            <table id="table-daily-report-courier" class="table table-striped">

            </table>
          </div>

          <br/>
          <h4>Receive Image Upload</h4>
          <div class="table-responsive exportTeamPrinting" data-title="Receive Image Upload">
            <table class="table table-hover table-bordered" id="table-receive-image-upload">
            </table>
          </div>
        </div>
      </div>

    </main>
    <?php
      require_once("appbar/footer.php");
     ?>
     <script type="text/javascript" src="js/report.js"></script>
  </body>
</html>
