<?php
  session_start();

  if(!isset($_SESSION['requestor_id'])){
    header('location: index.php');
  }

  // LETTER AVATAR
  // require('letter-avatar/letter-avatar-master/src/LetterAvatar.php');
  // require('vendor/autoload.php');
  // use YoHang88\LetterAvatar\LetterAvatar;
  // $avatar = new LetterAvatar($_SESSION['last_name'] . $_SESSION['first_name']);


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
     <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>

    $(document).ready(function(){

        var myEvent = window.attachEvent || window.addEventListener;
        var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable

        myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
            var confirmationMessage = ' ';  // a space
            (e || window.event).returnValue = confirmationMessage;
            return confirmationMessage;
        });

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

       //character counter for ticket Title
          $('input#input_text, textarea#textarea1').characterCounter();

      //to prevent user from typing ticket title when charcount reaches 40
          var max = 40;
          $('.title').keypress(function(e) {
              if (e.which < 0x20) {
                  // e.which < 0x20, then it's not a printable character
                  // e.which === 0 - Not a character
                  return;     // Do nothing
              }
              if (this.value.length == max) {
                  e.preventDefault();
              } else if (this.value.length > max) {
                  // Maximum exceeded
                  this.value = this.value.substring(0, max);
              }
          });

          //initialize modals
          $('.modal').modal();


          $('.datepicker').pickadate({
             selectMonths: false, // Creates a dropdown to control month
             selectYears: false, // Creates a dropdown of 15 years to control year,
             // today: 'Today',
             today: 'Today',
             clear: 'Clear',
             close: 'Ok',
             closeOnSelect: false // Close upon selecting a date,
           });


          var now = new Date();
          var day = ("0" + now.getDate()).slice(-2);
          var month = ("0" + (now.getMonth() + 1)).slice(-2);
          var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
          $('#date_prepared').val(today);
          $('#date_prepared2').val(today);

          //sweet alert
          $("#service").submit(function(e) {
            e.preventDefault();
            $.ajax({
              url: 'php_processes/service_ticket_process.php',
              type: 'POST',
              data: $(this).serialize()
            })
            swal("Ticket Submitted!", "Your ticket number is: ", "success");
          });

          $("#access").submit(function(e) {
            e.preventDefault();
            $.ajax({
              url: 'php_processes/access_ticket_process.php',
              type: 'POST',
              data: $(this).serialize()
            })
            swal("Ticket Submitted!", "Your ticket number is: ", "success");
          });
        });
    </script>
  </head>

  <body>
    <!-- Navbar goes here -->
    <header class="page-topbar">
    <nav  class="color">
       <div class="nav-wrapper">
         <a href="#!" class="brand-logo"><img class="company_logo" src="img/eei.png"></a><span class="name">EEI Corporation Service Desk</span>
         <ul class="right hide-on-med-and-down">
           <li><a class="dropdown-button btn-invert" href="#!" data-activates="dropdown2" data-beloworigin="true">New Ticket<i class="tiny material-icons" id="add-ticket">add</i></a></li>

            <li><a href="sass.html"><i class="small material-icons">notifications_none</i></a></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?><i class="right tiny material-icons" id="profile">keyboard_arrow_down</i></a></li>
         </ul>
       </div>
    </nav>
    <!-- Dropdown Structure -->
    <ul id="dropdown" class="dropdown-content collection">
        <li><a href="myprofile.php">My Profile</a></li>
        <li><a href="logout.php">Log out</a></li>
    </ul>
    <!-- Dropdown Structure -->
    <ul id="dropdown2" class="dropdown-content collection">
        <li><a class="service"> Service Request</a></li>
    		<li><a class="access">Access Request</a></li>
    </ul>
  </header>

  <!-- Page Layout here -->
    <div class="col s12 m12 l2">
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

      <!--body-->
      <div class="col s12 m12 l10">
        <div class="wrapper">
          <div class="main-container">
            <div class="main-body">
              <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Edit">
              <!-- <img src="<?php echo $avatar ?>"></img> -->
              <h4 class="body-header"><b><?php echo $_SESSION['first_name'] . ' ' . $_SESSION['last_name'] ?></b></h4>
              <h6 class="body-header" id="line2"><b><?php echo $_SESSION['user_type'] ?></b></h6>

              <hr>
              <br>
              <table id="profile">
                <tbody>
                  <tr>
                    <td>First Name</td>
                    <td><?php echo $_SESSION['first_name']?></td>
                  </tr>
                  <tr>
                    <td>Last Name</td>
                    <td><?php echo $_SESSION['last_name']?></td>
                  </tr>
                  <tr>
                    <td>Userid</td>
                    <td><?php echo $_SESSION['userid']?></td>
                  </tr>
                  <tr>
                    <td>E-mail Address</td>
                    <td><?php echo $_SESSION['email_address']?></td>
                  </tr>
                  <tr>
                    <td>User Type</td>
                    <td><?php echo $_SESSION['user_type']?></td>
                  </tr>
                  <tr>
                    <td>Requestor ID</td>
                    <td><?php echo $_SESSION['requestor_id']?></td>
                  </tr>
                </tbody>
              </table>
            </div>

            <form id="service" name="service" method="post">
              <div id="service" class="servicet">
                <div class="search-bar"><h5 class="body-header"><b>New Service Request </b></h5></div>
                <hr>
                        <div class="row">
                          <div class="col s12 m12 l12">
                            <div class="col s12 m12 l6" id="form">
                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input placeholder="<?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?>" name="rname" type="text" disabled>
                                    <label for="rname">Requestor's Name</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row" id="request-form-row2">
                                  <div class="col s12">
                                    <!-- <i class="tiny material-icons" id="form">event</i>Date Prepared: -->
                                    <div class="input-field" id="request-form">
                                      <input type="text"  id="date_prepared" name="date_prepared" disabled>
                                      <label for="date_prepared">Date Prepared (YYYY/MM/DD)</label>
                                    </div>
                                  </div>
                                </div>
                              </div>
                              <div class="col s12 m12 l6" id="form">
                                <div class="row" id="request-form-row">
                                  <div class="col s12">
                                    <div class="input-field" id="request-form">
                                      <input placeholder=" " class="title" name="title" type="text" data-length="40" class="validate" required>
                                      <label for="title">Request Title</label>
                                    </div>
                                  </div>
                                </div>
                                <div class="input-field" id="request-form-row3">
                                  <textarea id="textarea1" placeholder=" " class="materialize-textarea" name="request_details" required></textarea>
                                  <label for="textarea1" required>Details</label>
                                </div>
                                <div class="row">
                                  <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                                  <input class="waves-effect waves-light cancel" id="request-form" name="submit" type="submit" value="Cancel">
                                </div>
                            </div>
                            <!-- <div class="col s12 m12 l6" id="form">
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
                                  <input placeholder="" id="last_name" type="text" class="validate">
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
                            </div> -->
                        </div>
                      </div>
                </div>
              </form>

            <!--  ********************************* access ticket **************************************** -->
          <form method="post" id="access">
            <div id="access" class="accesst">
              <div class="search-bar"><h5 class="body-header"><b>New Access Request</b></h5></div>
                <hr>
                  <div class="row">
                    <div class="col s12 m12 l6" id="form">
                      <h6>Request Details</h6>
                      <div class="col s12 m12 l6">
                        <div class="row" id="request-form-row">
                          <div class="col s12">
                            <!-- <i class="tiny material-icons" id="form">event</i>Date Prepared: -->
                            <div class="input-field" id="request-form">
                              <input type="text"  id="date_prepared2" name="date_prepared2" disabled>
                              <label for="date_prepared2">Date Prepared (YYYY/MM/DD)</label>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="col s12 m12 l6">
                        <div class="row" id="request-form-row">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " name="rc_no" type="number" class="validate">
                              <label for="rc_no">R.C. Number</label>
                            </div>
                          </div>
                        </div>
                      </div>

                        <div class="row" id="request-form-row2">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " class="title" name="title" type="text" data-length="40" class="validate" required>
                              <label for="title">Request Title</label>
                            </div>
                          </div>
                        </div>

                        <div class="row" id="request-form-row2">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " name="company" type="text" class="validate">
                              <label for="company">Company</label>
                            </div>
                          </div>
                        </div>

                        <div class="row" id="request-form-row2">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " name="dp" type="text" class="validate">
                              <label for="Department/Project">Department/Project</label>
                            </div>
                          </div>
                        </div>


                    </div>


                    <div class="col s12 m12 l6" id="form">
                      <h6>Ticket Details</h6>
                      <div class="row" id="request-form-row">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <input placeholder=" " name="names" type="text" class="validate">
                            <label for="Names">Name/s</label>
                          </div>
                        </div>
                      </div>

                      <div class="row" id="request-form-row2">
                        <div class="col s12">
                          <div class="input-field" id="request-form">
                            <input placeholder=" " name="access_request" type="text" class="validate">
                            <label for="Access Request">Access Request</label>
                          </div>
                        </div>
                      </div>

                        <div class="row" id="request-form-row2">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " name="approver" type="text" class="validate">
                              <label for="approver">Approver</label>
                            </div>
                          </div>
                        </div>

                        <div class="row" id="request-form-row3">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " name="checker" type="text" class="validate">
                              <label for="Checekr">Checker</label>
                            </div>
                          </div>
                        </div>


                      <div class="row">
                        <div class="col s12">
                          <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                          <input class="waves-effect waves-light cancel" id="request-form" name="submit" type="submit" value="Cancel">
                        </div>
                      </div>
                        <!-- <div class="row" id="request-form-row">
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

                        <div class="row" id="request-form-row2">
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

                        <div class="row" id="request-form-row2">
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

                        <div class="input-field" id="request-form-row2">
                          <input id="last_name" type="text" class="validate">
                          <label for="last_name">Remarks</label>
                        </div>

                        <div class="input-field" id="request-form-row3">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input type="text" class="datepicker"  id="expiry_date" name="expiry_date" placeholder="">
                              <label for="expiry_date">Expiry Date (YYYY/MM/DD)</label>
                            </div>
                          </div>
                        </div>

                        <div class="row" id="request-form-row2">
                          <div class="col s12 m12 l6">
                            <div class="input-field inline" id="request-form">
                              <i class="tiny material-icons" id="form">event</i>Resolution Date:
                              <input type="date" class="datepicker">
                            </div>
                          </div>
                        </div>

                        <div class="input-field" id="request-form-row2">
                          <div class="col s12 m12 l6">
                            <p>
                              <input type="checkbox" class="filled-in" id="filled-in-box approver" name="approver"/>
                              <label for="filled-in-box approver">Approved?</label>
                            </p>
                          </div>
                          <div class="col s12 m12 l6">
                            <p>
                              <input type="checkbox" class="filled-in" id="filled-in-box checker" name="checker" />
                              <label for="filled-in-box checker">Checked?</label>
                            </p>
                          </div>
                        </div> -->
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
      <script type="text/javascript" src="js/javascript.js"></script>
    </body>
</html>
