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

<body id="login-page" class="valign-wrapper">
<div class="container">
    <div class="valign-wrapper">
        <div class="card-panel" id="login" class="row">
          <div class="card-content white-text">
            <div class="row">
            <img src="img/EEI.png" class="login-logo">
          </div>
              <span class="card-title"><h5>EEI Corporation's Service Desk</h5></span>
          </div>
          <form method="post">
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
            </div>
            <div class="row">
               <input class="waves-effect waves-light btn-login" name="submit" type="submit" value="Login">
               <br>
               <a class="password-forgot" href"#!">Forgot Password?</a>
            </div>
            </form>
          </div>
      </div>
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
              <?php
            }
          }
          ?>
          <!-- END OF LOGIN PROCESS -->
</div>


      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/javascript.js"></script>
  </body>

</html>
