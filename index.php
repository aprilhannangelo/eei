<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css?<?php echo time(); ?>"  media="screen,projection"/>
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body id="login-page">
    <div class="container">
      <div class="container">
        <div class="wrapper">
          <div class="container">
            <div class="col s12 m12 l12">
              <div class="container" id="header">
            <h5 id="login-header"><img class="login_logo" src="img/eei.png"><b>EEI Corporation Service Desk</b>
            </div>
          </div>

          <!--LOGIN PROCESS-->
          <?php
          include "templates/dbconfig.php";
          if(isset($_POST['userid']) && isset($_POST['password'])){
            $username = $_POST['userid'];
            $password = md5($_POST['password']);
            $stmt = $db->prepare("SELECT * FROM requestor_t WHERE userid=? AND password=? ");
            $stmt->bindParam(1, $username);
            $stmt->bindParam(2, $password);
            $stmt->execute();
            $row = $stmt->fetch();
            $user = $row['userid'];
            $pass = $row['password'];
            $id = $row['requestor_id'];
            $fname = $row['first_name'];
            $lname = $row['last_name'];
            $email = $row['email_address'];
            $user_type = $row['user_type'];
            if($username==$user && $password==$pass){
              session_start();
              $_SESSION['userid'] = $user;
              $_SESSION['password'] = $pass;
              $_SESSION['requestor_id'] = $id;
              $_SESSION['user_type'] = $user_type;
              $_SESSION['first_name'] = $fname;
              $_SESSION['last_name'] = $lname;
              $_SESSION['email_address'] = $email;
              ?>
              <script>window.location.assign('home.php')</script>
              <?php
            } else{
              ?>
              <script> Materialize.toast('I am a toast!', 4000) </script>
              <!-- <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
                <strong>Holy guacamole!</strong> You should check in on some of those fields below.
              </div> -->
              <?php
            }
          }
          ?>
          <!-- END OF LOGIN PROCESS -->
          <form method="post">
            <div class="container" id="main">
              <div class="col s12 12 l12">
                <div class="row">
                  <div class="input-field col s12" id="login">
                    <input id="userid" name="userid" type="text" class="validate">
                    <label for="userid" id="login">Userid</label>
                  </div>
                </div>
                <div class="row">
                  <div class="input-field col s12">
                    <input id="password" name="password" type="password" class="validate">
                    <label for="password" id="login">Password</label>
                  </div>
                </div>
                <div class="row" id="controls">
                  <p id="login">
                   <input type="checkbox" id="test5" />
                   <label for="test5">Remember Me</label>
                 </p>
                   <a class="password-forgot" href"#!">Forgot Password?</a>
                </div>
                <div class="row">
                   <input class="waves-effect waves-light btn-login" name="submit" type="submit" value="Login">
                </div>
                <br>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/javascript.js"></script>
  </body>

</html>
