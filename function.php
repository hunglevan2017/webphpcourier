<?php
session_start();
date_default_timezone_set('Asia/Ho_Chi_Minh');
require_once 'Conf.php';
require_once 'PostgreSQLClass.php';

if(isset($_POST['action'])){
  $action = $_POST['action'];

  switch ($action) {
      case 'Authenticate':
        $action();
        break;

      case 'FecSendToSGB':
        $action();
        break;

      case 'SGBAllocatedToDeliverVendor':
        $action();
        break;

      case 'ProcessingStatusOfDeliveryVendor':
        $action();
        break;

      case 'SignedContractOfDeliveryVendor':
        $action();
        break;

      case 'DailyReportCourierPrintingDetails':
        $action();
        break;

      case 'DailyReportCourier':
        $action();
        break;

      case 'ReportTeamPrintingGeneral':
        $action();
        break;

      case 'ReceiveImageUpload':
        $action();
        break;

      case 'ReportSgbSendTo247Summary':
        $action();
        break;

      case 'ReportSgbSendTo247Detail':
        $action();
        break;

        case 'ReportSalesRetrySummary':
          $action();
          break;

        case 'ReportSalesRetryDetail':
          $action();
          break;

        case 'ReportSgbChangeStageSummary':
          $action();
          break;

        case 'ReportSgbChangeStageDetail':
          $action();
          break;
  }

}

function Authenticate() {

  $userName = $_POST['username'];
  $password = $_POST['password'];
  $isSuccess = false;

	$ldap_host = "ldap://10.1.1.31:389";

  $ldap_host1 = 'ldap://ho-srv-ldap03.corp.saigonbpo.vn';

  $ldapDn = "uid=".$userName.",ou=Users,dc=saigonbpo,dc=vn";

	$ldap = ldap_connect($ldap_host);

  ldap_set_option($ldap, LDAP_OPT_PROTOCOL_VERSION, 3);
  ldap_set_option($ldap, LDAP_OPT_REFERRALS, 0);
  ldap_set_option($ldap, LDAP_OPT_NETWORK_TIMEOUT, 10);


  $ldapbind = ldap_bind($ldap,$ldapDn,$password);

  if ($ldapbind) {
    $isSuccess = true;
    $_SESSION['user'] = $userName;
  }
  ldap_close($ldap);

  echo $isSuccess;
  exit();
}

function Login(){
  $userName = $_POST['username'];
  $password = md5($_POST['password']);

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;

  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.lookup_channel where cc_code='$userName' and cc_password='$password'");

      $stmt->execute();
      $results = $stmt->fetchAll();

      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }

  if(count($results) > 0){
    $_SESSION['user'] = $userName;
  }else{
    unset($_SESSION['user']);
  }

  echo json_encode($results[0]);
  exit();
  // echo count($results) > 0;
}

function FecSendToSGB(){

  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  $resultDataReport = array();
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }

      $con->beginTransaction();
      $stmt = $con->prepare("select $proj_schema.report_fec_sends_to_sgb_summary('$date', '$vendor')");
      //echo ("select * from $proj_schema.sp_search_id_f1('".$idf1."');");die;
      $stmt->execute();
      $cursors = $stmt->fetchAll();
      $stmt->closeCursor();
      //echo $cursors[0][0];die;
      // get each result set
      $results = array();
      foreach ($cursors as $k => $v) {
          $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
          $results[$k] = $stmt->fetchAll();

          $i = 0;
          for ($j = 0; $j < count($results[$k]); $j++) {

              foreach ($results[$k][$j] as $key => $value) {
                  if (!is_int($key)) {
                      $resultDataReport[$i][$key] = $value;
                  }
              }
              $i++;
          }

          break;
      }
      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }

  echo json_encode($resultDataReport);
  exit();
}

function SGBAllocatedToDeliverVendor(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  $resultDataReport = array();
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }

      $con->beginTransaction();
      $stmt = $con->prepare("select $proj_schema.report_sgb_allocated_to_delivery_vendor('$date', '$vendor')");
      //echo ("select * from $proj_schema.sp_search_id_f1('".$idf1."');");die;
      $stmt->execute();
      $cursors = $stmt->fetchAll();
      $stmt->closeCursor();
      //echo $cursors[0][0];die;
      // get each result set
      $results = array();
      foreach ($cursors as $k => $v) {
          $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
          $results[$k] = $stmt->fetchAll();

          $i = 0;
          for ($j = 0; $j < count($results[$k]); $j++) {

              foreach ($results[$k][$j] as $key => $value) {
                  if (!is_int($key)) {
                      $resultDataReport[$i][$key] = $value;
                  }
              }
              $i++;
          }

          break;
      }
      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($resultDataReport);
  exit();
}

function ProcessingStatusOfDeliveryVendor(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_processing_status_of_delivery_vendor('$date', '$vendor')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
   echo json_encode($results);
   exit();
}

function SignedContractOfDeliveryVendor(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  $resultDataReport = array();
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }

      $con->beginTransaction();
      $stmt = $con->prepare("select $proj_schema.report_signed_contract_of_delivery_vendor('$date', '$vendor')");
      //echo ("select * from $proj_schema.sp_search_id_f1('".$idf1."');");die;
      $stmt->execute();
      $cursors = $stmt->fetchAll();
      $stmt->closeCursor();
      //echo $cursors[0][0];die;
      // get each result set
      $results = array();
      foreach ($cursors as $k => $v) {
          $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
          $results[$k] = $stmt->fetchAll();

          $i = 0;
          for ($j = 0; $j < count($results[$k]); $j++) {

              foreach ($results[$k][$j] as $key => $value) {
                  if (!is_int($key)) {
                      $resultDataReport[$i][$key] = $value;
                  }
              }
              $i++;
          }

          break;
      }
      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($resultDataReport);
  exit();
}

function DailyReportCourierPrintingDetails(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_daily_courier_printing_details('$date', '$vendor')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function DailyReportCourier(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  $resultDataReport = array();
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }

      $con->beginTransaction();
      $stmt = $con->prepare("select $proj_schema.report_daily_rp_courier('$date', '$vendor')");
      //echo ("select * from $proj_schema.sp_search_id_f1('".$idf1."');");die;
      $stmt->execute();
      $cursors = $stmt->fetchAll();
      $stmt->closeCursor();
      //echo $cursors[0][0];die;
      // get each result set
      $results = array();
      foreach ($cursors as $k => $v) {
          $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
          $results[$k] = $stmt->fetchAll();

          $i = 0;
          for ($j = 0; $j < count($results[$k]); $j++) {

              foreach ($results[$k][$j] as $key => $value) {
                  if (!is_int($key)) {
                      $resultDataReport[$i][$key] = $value;
                  }
              }
              $i++;
          }

          break;
      }
      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($resultDataReport);
  exit();
}

function ReportTeamPrintingGeneral(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_team_printing_general('$date', '$vendor')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function ReceiveImageUpload(){
  $date = isset($_POST['date']) ? $_POST['date'] : date("m/Y");
  $vendor = isset($_POST['vendor']) ? $_POST['vendor'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  $resultDataReport = array();
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }

      $con->beginTransaction();
      $stmt = $con->prepare("select $proj_schema.report_daily_rp_receive_image_upload('$date', '$vendor')");
      //echo ("select * from $proj_schema.sp_search_id_f1('".$idf1."');");die;
      $stmt->execute();
      $cursors = $stmt->fetchAll();
      $stmt->closeCursor();
      //echo $cursors[0][0];die;
      // get each result set
      $results = array();
      foreach ($cursors as $k => $v) {
          $stmt = $con->query('FETCH ALL IN "' . $v[0] . '";');
          $results[$k] = $stmt->fetchAll();

          $i = 0;
          for ($j = 0; $j < count($results[$k]); $j++) {

              foreach ($results[$k][$j] as $key => $value) {
                  if (!is_int($key)) {
                      $resultDataReport[$i][$key] = $value;
                  }
              }
              $i++;
          }

          break;
      }
      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($resultDataReport);
  exit();
}

function ReportSgbSendTo247Summary(){
  $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date("m/Y");
  $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_sgb_send_to_247_summary('$fromDate', '$toDate')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function ReportSgbSendTo247Detail(){
  $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date("m/Y");
  $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_sgb_send_to_247_detail('$fromDate', '$toDate')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function ReportSalesRetrySummary(){
  $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date("m/Y");
  $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_sales_retry_summary('$fromDate', '$toDate')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function ReportSalesRetryDetail(){
  $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date("m/Y");
  $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_sales_retry_detail('$fromDate', '$toDate')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function ReportSgbChangeStageSummary(){
  $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date("m/Y");
  $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_sgb_change_stage_summary('$fromDate', '$toDate')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}

function ReportSgbChangeStageDetail(){
  $fromDate = isset($_POST['fromDate']) ? $_POST['fromDate'] : date("m/Y");
  $toDate = isset($_POST['toDate']) ? $_POST['toDate'] : "";

  $conf = new Conf();
  $proj_schema = $conf->digi_soft_dbschema;
  //print_r($proj_schema);
  try {
// Connect to Database
      $pgSQL = new PostgreSQLClass();
      $con = $pgSQL->getConDPO_DIGISOFT();
      if (!$con) {
          return $resultDataReport;
      }
// begin transaction, this is all one process
      $con->beginTransaction();
      $stmt = $con->prepare("select * from $proj_schema.report_sgb_change_stage_detail('$fromDate', '$toDate')");

      $stmt->execute();
      $results = $stmt->fetchAll();
      //print_r($cursors);
      $stmt->closeCursor();

      $con->commit();
      unset($stmt);
  } catch (Exception $exc) {
      echo $exc->getTraceAsString();
  }
  echo json_encode($results);
  exit();
}


 ?>
