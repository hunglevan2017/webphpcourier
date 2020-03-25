<!DOCTYPE html>
<html>
  <head>

    <?php
      session_start();
      require_once("appbar/header.php");

      if(isset($_GET['logout'])){
        session_destroy();
      }

      if(isset($_SESSION['user'])){
        header("Location: dailyreportcourierprinting.php");
        exit();
      }
     ?>
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">

      <div class="login-box">
        <form class="login-form" id="login-form">
          <h3 class="login-head">
            <img src="images/logoBPO.png"/>
          </h3>
          <div class="form-group">
            <label class="control-label">USERNAME</label>
            <input class="form-control" id="username" name="username" type="text" placeholder="Email" autofocus>
            <div class="form-control-feedback hide" id="username-feedback">Sorry, that username's taken. Try another?</div>
          </div>
          <div class="form-group">
            <label class="control-label">PASSWORD</label>
            <input class="form-control" id="password" name="password" type="password" placeholder="Password">
            <div class="form-control-feedback hide" id="password-feedback">Sorry, that username's taken. Try another?</div>
          </div>
          <div class="form-group btn-container">
            <button type="button" class="btn btn-primary btn-block" id="btn-login"><i class="fas fa-sign-in-alt fa-lg fa-fw"></i>SIGN IN</button>
          </div>
        </form>
      </div>
    </section>
    <!-- Essential javascripts for application to work-->

    <?php
      require_once("appbar/footer.php");
     ?>
  </body>
</html>
