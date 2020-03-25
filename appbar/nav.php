<?php
  if(!isset($_SESSION['user'])){
    header("Location: index.php");
    exit();
  }

  $namePage = basename($_SERVER['PHP_SELF'], '.php');
?>

<header class="app-header"><a class="app-header__logo" href="index.html"><img style="width:10rem" src="images/logoBPO.png"/></a>
  <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"><i class="fas fa-bars"></i></a>
  <!-- Navbar Right Menu-->
  <ul class="app-nav">
    <!-- User Menu-->
    <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu"><i class="fa fa-user fa-lg"></i></a>
      <ul class="dropdown-menu settings-menu dropdown-menu-right">
        <li><a class="dropdown-item" href="index.php?logout=true"><i class="fas fa-sign-out-alt fa-lg"></i> Logout</a></li>
      </ul>
    </li>
  </ul>
</header>

<!-- Menu bar -->
<div class="app-sidebar__overlay" data-toggle="sidebar"></div>
<aside class="app-sidebar">
  <ul class="app-menu">

    <li class="treeview <?php echo isPageHasExpandMonitoring() ? 'is-expanded' : '' ?>">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fas fa-desktop"></i><span class="app-menu__label">Monitoring</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item <?php echo $namePage == 'systemmonitoring' ? 'active' : '' ?>" href="systemmonitoring.php"><i class="app-menu__icon "></i> System Monitoring</a></li>
      </ul>
    </li>

    <li class="treeview <?php echo isPageHasExpand() ? 'is-expanded' : '' ?>">
      <a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-th-list"></i><span class="app-menu__label">Report</span><i class="treeview-indicator fa fa-angle-right"></i></a>
      <ul class="treeview-menu">
        <li><a class="treeview-item <?php echo $namePage == 'dailyreportcourierprinting' ? 'active' : '' ?>" href="dailyreportcourierprinting.php"><i class="app-menu__icon"></i> Daily Report - Courier Printing</a></li>
        <li><a class="treeview-item <?php echo $namePage == 'dailyreportcourier' ? 'active' : '' ?>" href="dailyreportcourier.php"><i class="app-menu__icon"></i> Daily Report - Courier</a></li>
        <li><a class="treeview-item <?php echo $namePage == 'dailyreportteamprinting' ? 'active' : '' ?>" href="dailyreportteamprinting.php"><i class="app-menu__icon"></i> Daily Report - Team Printing</a></li>
      </ul>
    </li>

    <a class="app-menu__item" href="http://10.1.1.104/mafc_dc/InsertStatusSignView.php"><i class="app-menu__icon fa fa-plus"></i><span class="app-menu__label">Insert Sign For 247</span><i class="treeview-indicator "></i></a>

  </ul>
</aside>

<?php
  function isPageHasExpand(){
    $namePage = basename($_SERVER['PHP_SELF'], '.php');
    $isExpanded = false;
    switch ($namePage) {
      case 'dailyreportcourierprinting':
        $isExpanded = true;
        break;

      case 'dailyreportcourier':
        $isExpanded = true;
        break;

      case 'dailyreportteamprinting':
        $isExpanded = true;
        break;

      default:
        $isExpanded = false;
        break;
    }

    return $isExpanded;
  }

  function isPageHasExpandMonitoring(){
    $namePage = basename($_SERVER['PHP_SELF'], '.php');
    $isExpanded = false;
    switch ($namePage) {
      case 'contractmonitoring':
        $isExpanded = true;
        break;

      case 'systemmonitoring':
        $isExpanded = true;
        break;

      default:
        $isExpanded = false;
        break;
    }

    return $isExpanded;
  }
?>
