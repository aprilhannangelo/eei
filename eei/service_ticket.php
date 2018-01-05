<?php
  session_start();
  if(!isset($_SESSION['first_name'])){
    header('location: index.php');
  }

  include_once ('templates/dbconfig.php');

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
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script type="text/javascript">
  function show(target) {
      document.getElementById(target).style.display = 'block';
  }

  function hide(target) {
      document.getElementById(target).style.display = 'none';
  }
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
            <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="medium material-icons" style="margin-right: 10px">person_pin</i><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name']?></a></li>
         </ul>
       </div>
    </nav>
    <!-- Dropdown Structure -->
    <ul id="dropdown" class="dropdown-content collection">
        <li><a href="sass.html">My Profile</a></li>
    		<li><a href="logout.php">Log out</a></li>
    </ul>
    <!-- Dropdown Structure -->
    <ul id="dropdown2" class="dropdown-content collection">
        <li><a href="#!" onclick="show('service')"> Service Request</a></li>
    		<li><a href="#!" onclick="hide('service')">Access Request</a></li>
    </ul>
  </header>

  <!-- Page Layout here -->
  <div class="col s12 m12 l2">
        <ul id="slide-out" class="side-nav fixed">
          <li><a href="home.php"><i class="tiny material-icons">home</i>Home</a></li>
          <li><a href="dashboard.php"><i class="tiny material-icons">dashboard</i>Dashboard</a></li>
            <ul class="collapsible collapsible-accordion">
              <li>
                <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>View Tickets</a>
                <div class="collapsible-body">
                  <ul>
                    <li class="collapsible"><a href="viewTickets.html">All Tickets</a></li>
                    <li class="collapsible"><a href="#!">In Progress</a></li>
                    <li class="collapsible"><a href="#!">Resolved</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          <li><a href="#!"><i class="tiny material-icons">markunread</i>View Requests</a></li>
          <li><a href="#!"><i class="tiny material-icons">settings</i>Manage Users</a></li>
        </ul>
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>

    <!--body-->
    <div class="col s12 m12 l10">
      <div class="wrapper">
      <div class="main-container">
          <form method="post" action="php_processes/service_ticket_process.php">
            <div id="service">
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
          <div id="access">
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
</div>
  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script type="text/javascript" src="js/javascript.js"></script>
  <script>
    $(document).ready(function() {
      $('select').material_select();
      // document.getElementById('date_prepared').valueAsDate = new Date();
    });
  </script>

</body>
</html>
