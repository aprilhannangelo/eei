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
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <script>
      $(document).ready(function(){
        $('.search-box input[type="text"]').on("keyup input", function(){
            /* Get input value on change */
            var inputVal = $(this).val();
            var resultDropdown = $(this).siblings(".result");
            if(inputVal.length){
                $.get("php_processes/search.php", {term: inputVal}).done(function(data){
                    // Display the returned data in browser
                    resultDropdown.html(data);
                });
            } else{
                resultDropdown.empty();
            }
        });

        // Set search input value on click of result item
        $(document).on("click", ".result p", function(){
            $(this).parents(".search-box").find('input[type="text"]').val($(this).text());
            $(this).parent(".result").empty();
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
            <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="medium material-icons" style="margin-right: 10px">person_pin</i><?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?></a></li>
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
        <li><a class="service" href="#"> Service Request</a></li>
    		<li><a class="access" href="#">Access Request</a></li>
    </ul>
  </header>

  <!-- Page Layout here -->
  <div class="col s12 m12 l2">
      <ul id="slide-out" class="side-nav fixed">
        <li><a class="waves-effect" href="home.php"><i class="tiny material-icons">home</i>Home</a></li>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header waves-effect" href="#!"><i class="tiny material-icons">view_list</i>View My Tickets</a>
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
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>View Service Tickets</a>
            <div class="collapsible-body">
              <ul>
                <li class="collapsible"><a href="incomingRequests.php">Incoming Tickets</a></li>
                <li class="collapsible"><a href="#!">All Tickets</a></li>
                <li class="collapsible"><a href="#!">Resolved Tickets</a></li>
              </ul>
            </div>
          </li>
        </ul>
              <li><a href="dashboard.php"><i class="tiny material-icons">dashboard</i>Dashboard</a></li>
          <?php
        }
        ?>
        <?php
          if($_SESSION['user_type'] == 'Requestor'){
        ?>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Requests for Review</a>
              <div class="collapsible-body">
                <ul>
                  <li class="collapsible"><a href="incomingRequests.php">Incoming Requests</a></li>
                  <li class="collapsible"><a href="#!">Approved Requests</a></li>
                  <li class="collapsible"><a href="#!">Checked Requests</a></li>
                </ul>
              </div>
            </li>
          </ul>
          <?php
        }
        ?>
        <?php
          if($_SESSION['user_type'] == 'Technicals Group Manager'){
        ?>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Technicals Tickets</a>
            <div class="collapsible-body">
              <ul>
                <li class="collapsible"><a href="incomingRequests.php">Incoming Technicals Tickets</a></li>
                <li class="collapsible"><a href="#!">All Technicals Tickets</a></li>
                <li class="collapsible"><a href="#!">Resolved Technicals Tickets</a></li>
              </ul>
            </div>
          </li>
        </ul>
          <?php
        }
        ?>
         <?php
          if($_SESSION['user_type'] == 'Access Group Manager'){

          ?>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Access Tickets</a>
              <div class="collapsible-body">
                <ul>
                  <li class="collapsible"><a href="incomingRequests.php">Incoming Tickets</a></li>
                  <li class="collapsible"><a href="#!">All Access Tickets</a></li>
                  <li class="collapsible"><a href="#!">Resolved Access Tickets</a></li>
                </ul>
              </div>
            </li>
          </ul>
            <li><a href="manageUsers.php"><i class="tiny material-icons">settings</i>Manage Users</a></li>
            <li><a href="dashboard.php"><i class="tiny material-icons">dashboard</i>Dashboard</a></li>
            <?php
          }
          ?>


        <li><a class="link" href="dashboard.php"><i class="tiny material-icons">help</i>Help and Support</a></li>
    </ul>
    <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>

    <div class="col s12 m12 l10"> <!-- Note that "m8 l9" was added -->
      <!--body-->
      <div class="col s12 m12 l10">
        <div class="wrapper">
          <div class="main-container">
            <div class="main-body">
            <div class="material-table">
              <div class="table-header">
                <span class="table-title"><b>Incoming Requests</b></span>
                <div class="actions">
                  <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                </div>
              </div>
              <table id="datatable" class="striped">

                  <!--Connect to mysql database-->
                  <?php
                  if ($_SESSION['user_type']=='Administrator') {?>
                    <thead>
                      <tr>
                        <th></th>
                        <th>Ticket No.</th>
                        <th>Status</th>
                        <th>Notes</th>
                        <th>Date Created</th>
                        <th>Remarks</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");
                    //Query for the way the table is shown in hr-index.php
                    $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number)
                     WHERE ticket_t.ticket_category is NULL AND (user_access_ticket_t.isApproved=true OR ticket_t.ticket_type='Service')";

                    $result = mysqli_query($db,$query);?>


                       <?php while($row = mysqli_fetch_assoc($result)){
                         switch($row['ticket_type'])
                          {
                              // assumes 'type' column is one of CAR | TRUCK | SUV
                              case("Service"):
                                  $class = 'ticket_cat_t';
                                  break;
                              case("User Access"):
                                 $class = 'ticket_cat_a';
                                 break;
                          }
                         ?>


                          <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                            <td id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_type'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                            <td> <?php echo $row['ticket_number']?>  </td>
                            <td> <?php echo $row['ticket_status']?>  </td>
                            <td> <?php echo $row['ticket_title']?>   </td>
                            <td> <?php echo $row['date_prepared']?>  </td>
                            <td> <?php echo $row['remarks'] ?>       </td>
                          </tr>
                        <?php
                      }}
                      elseif ($_SESSION['user_type']=='Access Group Manager') {?>
                        <thead>
                          <tr>
                            <th></th>
                            <th>Ticket No.</th>
                            <th>Status</th>
                            <th>Department/Project</th>
                            <th>Access Requested</th>
                            <th>Date Created</th>
                          </tr>
                        </thead>
                        <?php
                        $db = mysqli_connect("localhost", "root", "", "eei_db");
                        //Query for the way the table is shown in hr-index.php
                        $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number)  WHERE ticket_t.ticket_category='Access' ";

                        $result = mysqli_query($db,$query);?>


                           <?php while($row = mysqli_fetch_assoc($result)){
                             switch($row['ticket_type'])
                              {
                                  // assumes 'type' column is one of CAR | TRUCK | SUV
                                  case("Service"):
                                      $class = 'ticket_cat_t';
                                      break;
                                  case("User Access"):
                                     $class = 'ticket_cat_a';
                                     break;
                              }
                             ?>

                             <tbody>

                              <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                                <td id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_type'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                                <td> <?php echo $row['ticket_number']?>  </td>
                                <td> <?php echo $row['ticket_status']?>  </td>
                                <td> <?php echo $row['dept_proj']?>   </td>
                                <td> <?php echo $row['access_requested']?>  </td>
                                <td> <?php echo $row['date_prepared'] ?>       </td>
                              </tr>
                            <?php
                          }}
                          elseif ($_SESSION['user_type']=='Technicals Group Manager') {?>
                            <thead>
                              <tr>
                                <th></th>
                                <th>Ticket No.</th>
                                <th>Status</th>
                                <th>Notes</th>
                                <th>Date Created</th>
                                <th>Remarks</th>
                              </tr>
                            </thead>
                            <tbody>

                            <?php
                            $db = mysqli_connect("localhost", "root", "", "eei_db");
                            //Query for the way the table is shown in hr-index.php
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number)  WHERE ticket_t.ticket_category='Technicals'";

                            $result = mysqli_query($db,$query);?>


                               <?php while($row = mysqli_fetch_assoc($result)){
                                 switch($row['ticket_type'])
                                  {
                                      // assumes 'type' column is one of CAR | TRUCK | SUV
                                      case("Service"):
                                          $class = 'ticket_cat_t';
                                          break;
                                      case("User Access"):
                                         $class = 'ticket_cat_a';
                                         break;
                                  }
                                 ?>


                                  <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                                    <td id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_type'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                                    <td> <?php echo $row['ticket_number']?>  </td>
                                    <td> <?php echo $row['ticket_status']?>  </td>
                                    <td> <?php echo $row['ticket_title']?>   </td>
                                    <td> <?php echo $row['date_prepared']?>  </td>
                                    <td> <?php echo $row['remarks'] ?>       </td>
                                  </tr>
                                <?php
                              }}
                              elseif ($_SESSION['user_type']=='Requestor') {?>
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Ticket No.</th>
                                    <th>Status</th>
                                    <th>Department/Project</th>
                                    <th>Access Requested</th>
                                    <th>Date Created</th>
                                  </tr>
                                </thead>
                                <?php
                                $db = mysqli_connect("localhost", "root", "", "eei_db");
                                $id = $_SESSION['requestor_id'];
                                //Query for the way the table is shown in hr-index.php
                                $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number)
                                WHERE (user_access_ticket_t.checker =$id AND user_access_ticket_t.isChecked is NULL) OR (user_access_ticket_t.approver=$id AND user_access_ticket_t.isChecked=true AND user_access_ticket_t.isApproved IS NULL)";

                                $result = mysqli_query($db,$query);?>


                                   <?php while($row = mysqli_fetch_assoc($result)){
                                     switch($row['ticket_type'])
                                      {
                                          // assumes 'type' column is one of CAR | TRUCK | SUV
                                          case("Service"):
                                              $class = 'ticket_cat_t';
                                              break;
                                          case("User Access"):
                                             $class = 'ticket_cat_a';
                                             break;
                                      }
                                     ?>

                                     <tbody>

                                      <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                                        <td id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_type'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                                        <td> <?php echo $row['ticket_number']?>  </td>
                                        <td> <?php echo $row['ticket_status']?>  </td>
                                        <td> <?php echo $row['dept_proj']?>   </td>
                                        <td> <?php echo $row['access_requested']?>  </td>
                                        <td> <?php echo $row['date_prepared'] ?>       </td>
                                      </tr>
                                    <?php
                                  }}?>

                </tbody>
              </table>
            </div>
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
        <form method="POST" name="access" id="access">
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
                            <div class="input-field search-box" id="request-form">
                              <input placeholder=" " name="approver" autocomplete="off" type="text" class="validate">
                              <div class="result"></div>
                              <label for="approver">Approver</label>
                            </div>
                          </div>
                        </div>

                        <div class="row" id="request-form-row3">
                          <div class="col s12">
                            <div class="input-field search-box" id="request-form">
                              <input placeholder=" " name="checker" autocomplete="off" type="text" class="validate">
                              <div class="result"></div>
                                <label for="approver">Checker</label>
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

  <!--Import jQuery before materialize.js-->
  <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
  <script type="text/javascript" src="js/materialize.min.js"></script>
  <script src='https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'></script>
  <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js'></script>
  <script type="text/javascript" src="js/javascript.js"></script>

    </body>
</html>
