<?php
  include "templates/dbconfig.php";
  session_start();
  if(!isset($_SESSION['userid'])){
    header('location: index.php');
  }
?>
<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js" type="text/javascript"></script>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>
      $(document).ready(function(){
        $('.tooltipped').tooltip({delay: 50});


        //on document load, hide access and service request forms
        $(".accesst").hide();
        $(".servicet").hide();

        //if service request from dropdown menu is clicked..
        $('.service').click(function(){
          $(".main-body").hide();
          $(".servicet").show();
          $(".accesst").hide();
        });

        //if access request from dropdown menu is clicked..
        $('.access').click(function(){
          $(".main-body").hide();
          $(".accesst").show();
          $(".servicet").hide();
        });

        //initialize select dropdown for materialize [DO NOT REMOVE]
          $('select').material_select();

          var tr = document.getElementById("status");
          var tds = tr.getElementsByTagName("td");

          for(var i = 0; i < tds.length; i++) {
             tds[i].style.color="red";
          }
      });

        jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
          window.location = $(this).data("href");
      });

      //sweet alert
      $("#service").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'php_processes/service_ticket_process.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data)
           {
               ticketNo= JSON.parse(data);
               swal("Ticket Submitted!", "Your ticket number is: " +ticketNo , "success");
           }
        })
      });

      $("#access").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'php_processes/access_ticket_process.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data)
           {
               ticketNo= JSON.parse(data);
               swal("Ticket Submitted!", "Your ticket number is: " +ticketNo , "success");
           }
        })
      });




});
    </script>
  </head>

  <body>
    <!-- Navbar goes here -->
    <header class="page-topbar">
    <nav  class="blue-grey darken-4">
       <div class="nav-wrapper">
         <a href="#!" class="brand-logo"><img class="company_logo" src="img/eei.png"></a><span class="name">EEI Corporation Service Desk</span>
         <ul class="right hide-on-med-and-down">
           <li><a class="dropdown-button btn-invert" href="#!" data-activates="dropdown2" data-beloworigin="true">New Ticket<i class="tiny material-icons" id="add-ticket">add</i></a></li>
            <li><a href="sass.html"><i class="small material-icons">notifications_none</i></a></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="medium material-icons" style="margin-right: 10px">person_pin</i><?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?><i class="right tiny material-icons" id="profile">keyboard_arrow_down</i></a></li>
         </ul>
       </div>
    </nav>
    <!-- Dropdown Structure -->
    <ul id="dropdown" class="dropdown-content collection">
        <li><a href="myprofile.php">My Profile</a></li>
        <li><a href="php_processes/logout.php">Log out</a></li>
    </ul>
    <!-- Dropdown Structure -->
    <ul id="dropdown2" class="dropdown-content collection">
        <li><a class="service" href="#"> Service Request</a></li>
    		<li><a class="access" href="#">Access Request</a></li>
    </ul>
  </header>

  <!-- Page Layout here -->
    <div class="col s12 m12 l2"> <!-- Note that "m4 l3" was added -->
      <ul id="slide-out" class="side-nav fixed">
        <li><a href="home.php"><i class="tiny material-icons">home</i>Home</a></li>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>View Tickets</a>
              <div class="collapsible-body">
                <ul>
                  <li class="collapsible"><a href="tickets.php">All Tickets</a></li>
                  <li class="collapsible"><a href="#!">In Progress</a></li>
                  <li class="collapsible"><a href="#!">Resolved</a></li>
                </ul>
              </div>
            </li>
          </ul>
          <?php
            if($_SESSION['user_type'] == 'Administrator'){
          ?>
            <li><a href="#!"><i class="tiny material-icons">markunread</i>View Requests</a></li>
            <li><a href="#!"><i class="tiny material-icons">settings</i>Manage Users</a></li>
            <li><a href="dashboard.php"><i class="tiny material-icons">dashboard</i>Dashboard</a></li>
            <?php
          }
          ?>
      </ul>
      <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
  </div>

    <div class="col s12 m12 l10"> <!-- Note that "m8 l9" was added -->
      <!--body-->
      <div class="col s12 m12 l10">
        <div class="wrapper">
          <div class="main-container">
            <div class="main-body">
              <div class="col s6 m6 l12">
                <div class="col s6 m6 l4">


<input class="waves-effect waves-light back" id="request-form" type="submit" onclick="window.location.href='tickets.php'" value="Back">

                  <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");

                    $query = "SELECT ticket_number FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";
                    $result = mysqli_query($db,$query);

                    while($row = mysqli_fetch_assoc($result)){
                       echo "<h4><b>Ticket #" . $row['ticket_number'];
                   };
                  ?>
                </div>
              <div class="col s12 m12 l12">
                <div class="row">
                  <div class="col s12 m12 l7">
                    <div class="card-panel">
                      <span class="black-text">
                        <?php
                          $db = mysqli_connect("localhost", "root", "", "eei_db");

                          $query = "SELECT t.ticket_title, s.request_details, DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join service_ticket_t s on (s.ticket_id=t.ticket_id) WHERE s.ticket_id = '".$_GET['id']."'";
                          $query2 = "SELECT t.ticket_title, u.access_requested, u.dept_proj,DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE u.ticket_id = '".$_GET['id']."'";

                          $result = mysqli_query($db,$query);
                          $result2= mysqli_query($db,$query2);


                          while($row = mysqli_fetch_assoc($result)){

                             echo "<h4><b>" . $row['ticket_title'] .
                                  "<br><p id=\"requestor_details\">" . "<style=\"color:blue\">" . "<span class=\"name-in-ticket\">" . $row['requestor'] . "</span>" . "<span class=\"request_date\">" . " reported on " . $row['date_prepared'] . "</p>" .
                                  "<p id=\"details\">" . $row['request_details'] . "</p>";
                         };
                         while($row = mysqli_fetch_assoc($result2)){

                            echo "<h4><b>" . $row['ticket_title'] .
                                 "<br><p id=\"requestor_details\">" . "<style=\"color:blue\">" . "<span class=\"name-in-ticket\">" . $row['requestor'] . "</span>" . "<span class=\"request_date\">" . " reported on " . $row['date_prepared'] . "</p>" .
                                 "<p id=\"details\">" . $row['access_requested'] . "</p>";
                        };

                        ?>
                    </div>
                  </div>
                  <div class="col s12 m12 l5">
                    <div class="card-panel" id="right-card">
                      <span class="black-text">
                        <table id="ticket-details">
                          <tbody>
                              <?php
                              $db = mysqli_connect("localhost", "root", "", "eei_db");

                                $query = "SELECT t.ticket_status, t.severity_level, t.date_required FROM ticket_t t WHERE ticket_id = '".$_GET['id']."'";

                                $result = mysqli_query($db,$query);

                                while($row = mysqli_fetch_assoc($result)){
                                  switch($row['severity_level'])
                                  {
                                      // assumes 'type' column is one of CAR | TRUCK | SUV
                                      case("SEV1"):
                                          $class = 'sev1';
                                          break;

                                     case("SEV2"):
                                         $class = 'sev2';
                                         break;

                                     case("SEV3"):
                                         $class = 'sev3';
                                         break;

                                     case("SEV4"):
                                         $class = 'sev4';
                                         break;

                                     case("SEV5"):
                                         $class = 'sev5';
                                         break;

                                    case(""):
                                        $class = 'blanksev';
                                        break;
                                  }
                                  echo "<tr><td class=\"first\">" . "Status" .  "</td><td class=\"deet\">" . $row['ticket_status'] . "</td>" .
                                       "<tr><td class=\"first\">" . "Severity" . "</td><td class=\"$class\" id=\"sev\">"  . $row['severity_level']  . "</td>" .
                                       "<tr><td class=\"first\">" . "Due on" . "</td><td class=\"deet\">" .  $row['date_required'] . "</td>";
                               };
                              ?>
                            </tbody>
                          </table>
                    </div>
                    <hr style="margin-left:  20px;">

                    <div class="card-panel" id="right-card2">
                      <span class="black-text">
                        <table id="ticket-details">
                            <h6><i class="left small material-icons" id="tagent">arrow_drop_down</i>Ticket Agent Information</h6>
                          <tbody>
                            <?php
                              $db = mysqli_connect("localhost", "root", "", "eei_db");

                              $query = "SELECT t.ticket_title, s.request_details, DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join service_ticket_t s on (s.ticket_id=t.ticket_id) WHERE t.ticket_id = '".$_GET['id']."'";
                                       $query2 = "SELECT u.access_requested, u.dept_proj,DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE t.ticket_id = '".$_GET['id']."'";

                               $result = mysqli_query($db,$query);
                               $result2= mysqli_query($db,$query2);

                               while($row = mysqli_fetch_assoc($result)){
                                 echo "<tr class=\"tagent_info\"><td class=\"name-in-ticket\">" . $row['requestor'] ."</td>" .
                                 "<tr class=\"tagent_info\"><td class=\"request_date\">" . $row['user_type'] . "</tr>";
                              };

                              while($row2 = mysqli_fetch_assoc($result2)){
                                echo "<tr class=\"tagent_info\"><td class=\"name-in-ticket\">" . $row['requestor'] ."</td>" .
                                "<tr class=\"tagent_info\"><td class=\"request_date\">" . $row['user_type'] . "</tr>";
                             };
                             ?>
                            </tbody>
                          </table>
                    </div>
                  </div>
                </div>
                <!-- ^ end div of row -->
            </div>




          <!--  FORMS INVISIBLE DO NOT EDIT -->
          <form method="post" action="php_processes/service_ticket_process.php">
            <div id="service" class="servicet">
              <div class="search-bar"><h5 class="body-header"><b>Service Request Form</b></h5></div>
                <hr>
            <div class="row">
                <div class="col s12">
                  <div class="row">
                      <div class="col s12 l6" id="form">
                        <h6>Request Details</h6>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <i class="tiny material-icons" id="form">event</i>Date Prepared:
                              <div class="input-field inline" id="request-form">
                                <input type="date" class="datepicker" id="date_prepared" name="date_prepared" required>
                              </div>
                            </div>
                          </div>
                            <!-- <div class="row" id="request-form-row">
                              <div class="col s12">
                                <i class="tiny material-icons" id="form">event</i>Date Required:
                                <div class="input-field inline" id="request-form">
                                  <input type="date" class="datepicker" name="date_required" required>
                                </div>
                              </div>
                            </div> -->
                          <div class="input-field" id="request-form-row">
                            <textarea id="textarea1" class="materialize-textarea" name="request_details" required></textarea>
                            <label for="textarea1" required>Details</label>
                          </div>
                      </div>
                      <div class="col s12 m12 l6" id="form">
                        <h6>Ticket Details</h6>
                          <div class="row" id="request-form-row2">
                            <div class="input-field col s12">
                              <?php
                                $db = mysqli_connect("localhost", "root", "", "eei_db");
                              ?>
                              <form method="post" action="service_ticket_process.php">
                                <?php
                                  echo "<select>";
                                  echo "<option value=\"\" disabled selected>Select</option>";
                                  $get_ticket_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_type'");
                                  $row = mysqli_fetch_array($get_ticket_type);
                                  $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                  foreach($enumList as $value)
                                  echo "<option value=\"$value\">$value</option>";
                                  echo "</select>";
                                ?>
                              </form>
                              <label>Ticket Type</label>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <label>Ticket Category</label>

                            <div class="input-field col s12">
                              <?php
                                $db = mysqli_connect("localhost", "root", "", "eei_db");
                              ?>
                              <form method="post" action="service_ticket_process.php">
                                <?php
                                  echo "<select>";
                                  echo "<option value=\"\" disabled selected>Select</option>";
                                  $get_ticket_category = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_category'");
                                  $row = mysqli_fetch_array($get_ticket_category);
                                  $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                  foreach($enumList as $value)
                                  echo "<option value=\"$value\">$value</option>";
                                  echo "</select>";
                                ?>
                              </form>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                          <label>Ticket Severity</label>
                            <div class="input-field col s12">
                              <?php
                                $db = mysqli_connect("localhost", "root", "", "eei_db");
                              ?>
                              <form method="post" action="service_ticket_process.php">
                                <?php
                                  echo "<select>";
                                  echo "<option value=\"\" disabled selected>Select:</option>";
                                  $get_severity_level = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'severity_level'");
                                  $row = mysqli_fetch_array($get_severity_level);
                                  $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                  foreach($enumList as $value)
                                  echo "<option value=\"$value\">$value</option>";
                                  echo "</select>";
                                ?>
                              </form>
                            </div>
                          </div>
                          <div class="input-field" id="request-form-row">
                            <input id="last_name" type="text" class="validate">
                            <label for="last_name">Remarks</label>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <i class="tiny material-icons" id="form">event</i>Resolution Date:
                              <div class="input-field inline" id="request-form">
                                <input type="date" class="datepicker">
                              </div>
                            </div>
                          </div>
                      </div>
                      <div class="row">
                        <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                        <input class="waves-effect waves-light clear" name="clear" type="submit" value="Clear">
                        <input class="waves-effect waves-light cancel" name="submit" type="submit" value="Cancel">
                      </div>
                  </div>
                </div>
            </div>
          </div>

          <!--  ********************************* access ticket **************************************** -->
          <div id="access" class="accesst">
            <div class="search-bar"><h5 class="body-header"><b>User Access Form</b></h5></div>
              <hr>
            <div class="row">
                <div class="col s12">
                  <div class="row">
                      <div class="col s12 l6" id="form">
                        <h6>Request Details</h6>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <i class="tiny material-icons" id="form">event</i>Date Prepared:
                              <div class="input-field inline" id="request-form">
                                <input type="date" class="datepicker" id="date_prepared" name="date_prepared" required>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <div class="input-field" id="request-form">
                                <input placeholder=" " id="company" type="text" class="validate">
                                <label for="company">Company</label>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <div class="input-field" id="request-form">
                                <input placeholder=" " id="Department/Project" type="text" class="validate">
                                <label for="Department/Project">Department/Project</label>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <div class="input-field" id="request-form">
                                <input placeholder=" " id="rc_no" type="number" class="validate">
                                <label for="rc_no">R.C. Number</label>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <div class="input-field" id="request-form">
                                <input placeholder=" " id="Names" type="text" class="validate">
                                <label for="Names">Name/s</label>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <div class="input-field" id="request-form">
                                <input placeholder=" " id="Names" type="text" class="validate">
                                <label for="Access Request">Access Request</label>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              <i class="tiny material-icons" id="form">event</i>Expiry Date:
                              <div class="input-field inline" id="request-form">
                                <input type="date" class="datepicker" id="expiry_date" name="date_prepared" required>
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              Approver (if any):
                              <div class="input-field inline" id="request-form">
                                <input type="text" class="validate" id="approver" name="approver">
                              </div>
                            </div>
                          </div>
                          <div class="row" id="request-form-row">
                            <div class="col s12">
                              Checker (if any):
                              <div class="input-field inline" id="request-form">
                                <input type="text" class="validate" id="checker" name="checker">
                              </div>
                            </div>
                          </div>

                      </div>
                        <div class="col s12 m12 l6" id="form">
                          <h6>Ticket Details</h6>
                            <div class="row" id="request-form-row2">
                              <label>Ticket Type</label>
                              <div class="input-field col s12">
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                                ?>
                                <form method="post" action="service_ticket_process.php">
                                  <?php
                                    echo "<select>";
                                    echo "<option value=\"\" disabled selected>Select</option>";
                                    $get_ticket_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_type'");
                                    $row = mysqli_fetch_array($get_ticket_type);
                                    $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                    foreach($enumList as $value)
                                    echo "<option value=\"$value\">$value</option>";
                                    echo "</select>";
                                  ?>
                                </form>
                              </div>
                            </div>
                            <div class="row" id="request-form-row">
                              <label>Ticket Category</label>
                              <div class="input-field col s12">
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                                ?>
                                <form method="post" action="service_ticket_process.php">
                                  <?php
                                    echo "<select>";
                                    echo "<option value=\"\" disabled selected>Select</option>";
                                    $get_ticket_category = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_category'");
                                    $row = mysqli_fetch_array($get_ticket_category);
                                    $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                    foreach($enumList as $value)
                                    echo "<option value=\"$value\">$value</option>";
                                    echo "</select>";
                                  ?>
                                </form>

                              </div>
                            </div>
                            <div class="row" id="request-form-row">
                              <label>Ticket Severity</label>
                              <div class="input-field col s12">
                                <?php
                                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                                ?>
                                <form method="post" action="service_ticket_process.php">
                                  <?php
                                    echo "<select>";
                                    echo "<option value=\"\" disabled selected>Select:</option>";
                                    $get_severity_level = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'severity_level'");
                                    $row = mysqli_fetch_array($get_severity_level);
                                    $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                    foreach($enumList as $value)
                                    echo "<option value=\"$value\">$value</option>";
                                    echo "</select>";
                                  ?>
                                </form>

                              </div>
                            </div>
                            <div class="input-field" id="request-form-row">
                              <input id="last_name" type="text" class="validate">
                              <label for="last_name">Remarks</label>
                            </div>
                            <div class="row" id="request-form-row">
                              <div class="col s12">
                                <i class="tiny material-icons" id="form">event</i>Resolution Date:
                                <div class="input-field inline" id="request-form">
                                  <input type="date" class="datepicker">
                                </div>
                              </div>
                            </div>
                            <div class="col l6">
                              <label>Approver</label>
                              <p>
                                <input type="checkbox" class="filled-in" id="filled-in-box approver" name="approver"/>
                                <label for="filled-in-box approver">Approved?</label>
                              </p>
                            </div>
                            <div class="col l6">
                              <label>Checker</label>
                              <p>
                                <input type="checkbox" class="filled-in" id="filled-in-box checker" name="checker" />
                                <label for="filled-in-box checker">Checked?</label>
                              </p>
                            </div>
                        </div>
                        <div class="row">
                          <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                          <input class="waves-effect waves-light clear" name="clear" type="submit" value="Clear">
                          <input class="waves-effect waves-light cancel" name="submit" type="submit" value="Cancel">
                        </div>
                  </form>
                </div>
              </div>
          </div>

  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>

  <script src='https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'></script>
  <!-- <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js'></script> -->
  <script type="text/javascript" src="js/javascript.js"></script>

    </body>
</html>
