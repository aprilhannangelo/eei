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
  <!-- ************** FONT ************* -->
  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

  <!-- ************** STYLESHEETS ************* -->
  <!--Import materialize.css-->
  <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
  <!--Import style.css-->
  <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>

  <!-- Other JQuery versions -->
  <!-- <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script> -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>


  <!-- JQuery to hide forms on load (for mobile)-->
  <script type="text/javascript" src="//code.jquery.com/jquery-1.8.3.js"></script>

    <script>
      $(document).ready(function(){
        //live searching for user access request form

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


      });

        jQuery(document).ready(function($) {
      $(".clickable-row").click(function() {
          window.location = $(this).data("href");
      });

      // sweet alert
      $("#service").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'php_processes/service_ticket_process.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function(data)
           {
             ticketNo= JSON.parse(data);
             swal({
                title: "Ticket Submitted!",
                text: "Your ticket number is: " +ticketNo,
                type: "success",
                icon: "success"
            }).then(function(){
              window.location="tickets.php";
            });
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
           swal({
              title: "Ticket Submitted!",
              text: "Your ticket number is: " +ticketNo,
              type: "success",
              icon: "success"
          }).then(function(){
            window.location="tickets.php";
          });
         }
        })
     });

      $("#properties").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'php_processes/updateType-Severity.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function()
           {
               swal("Ticket Updated", "success");
               $(".main-body").show();

           }
        })
        history.back();
      });
      $("#check").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'php_processes/check-process.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function()
           {
               swal("Ticket Updated", "success");
           }
        })
        history.back();
      });
      $("#approve").submit(function(e) {
        e.preventDefault();
        $.ajax({
          url: 'php_processes/approve-process.php',
          type: 'POST',
          data: $(this).serialize(),
          success: function()
           {
               swal("Ticket Updated", "success");
           }
        })
        history.back();
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
  <div class="col s12 m12 l2">
      <ul id="slide-out" class="side-nav fixed">
        <li><a class="waves-effect" href="home.php"><i class="tiny material-icons">home</i>Home</a></li>
          <ul class="collapsible collapsible-accordion">
            <li>
              <a class="collapsible-header waves-effect" href="#!"><i class="tiny material-icons">view_list</i>My Tickets</a>
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
            <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Tickets For Review</a>
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
                          $query2 = "SELECT u.isChecked, u.isApproved, u.approver as approver,u.checker as checker,t.ticket_title, u.access_requested, u.dept_proj,DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE u.ticket_id = '".$_GET['id']."'";

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
                            ?>
                       </div>
                       <div class="approvecheck-buttons">
                         <?php
                           $id = $_SESSION['requestor_id'];
                           $ticketID =$_GET['id'];

                           if ($row['approver']==$id) { ?>
                           <form id="approve" name="approve" method="post">
                             <input class="waves-effect waves-light back" id="request-form" type="submit" onclick="php_processes/approve-process.php'" value="Approve">
                             <input class="waves-effect waves-light back" id="request-form" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                           </form>

                          <?php }
                          elseif ($row['checker']==$id) { ?>
                           <form id="check" name="properties" method="post">
                           <input class="waves-effect waves-light back" id="request-form" type="submit" onclick="php_processes/check-process.php'" value="Check">
                             <input class="waves-effect waves-light back" id="request-form" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                          </form>

                    <?php }
                  };?>
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
                            <h6><i class="left small material-icons" id="tagent">arrow_drop_down</i>Ticket Agent Information</h6>
                            <div class="row" id="tagent-info">
                            <?php
                              $db = mysqli_connect("localhost", "root", "", "eei_db");

                              $query = "SELECT CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) WHERE t.ticket_id = '".$_GET['id']."'";

                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                 echo "<span class=\"name-in-ticket\">" . $row['requestor'] . "</span>" . "<br>" .
                                 "<span class=\"request_date\">" . $row['user_type'] . "</span>";
                              };
                             ?>
                           </div>

                          <?php if($_SESSION['user_type'] == 'Administrator'){ ?>
                            <hr>
                            <form id="properties" name="properties" method="post">
                              <h6><i class="left small material-icons" id="tagent">arrow_drop_down</i>Ticket Properties</h6>

                            <div id="properties" class="row " id="request-form-row">
                              <div class="col s12 m12 l12 properties-box" id="properties-box">
                                <div class="col s12 m12 l6">
                                  <div class="input-field ticket-properties" id="request-form">
                                    <?php
                                      $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                                      <select name = "category" >
                                      <option value= "disabled selected">Select</option>
                                      <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_category'");
                                      $row = mysqli_fetch_array($get_user_type);
                                      $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                      foreach($enumList as $value){?>
                                      <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                          <?php } ?>
                                      </select>

                                  <label for="title">Type</label>
                                  </div>
                                </div>
                                <div class="col s12 m12 l6">
                                  <div class="input-field ticket-properties" id="request-form">
                                    <?php
                                      $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                                      <select name = "severity" required >
                                      <option value="">Select</option>
                                      <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'severity_level'");
                                      $row = mysqli_fetch_array($get_user_type);
                                      $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                      foreach($enumList as $value){?>
                                      <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                          <?php } ?>
                                      </select>

                                      <label for="title">Severity</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row ticket-properties">
                                <div class="col s12">
                                  <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                                </div>
                              </div>
                              <div class="row" id="request-form-row3">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
                                  </div>
                                </div>
                              </div>

                            </div>
                          </form>
                        <?php } ?>
                      </div>
                  </div>
                </div><!-- end div of row -->
            </div>




            <!-- HIDDEN FORMS -->

            <!-- SERVICE REQUEST FORM -->
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
                    </div>
                  </div>
              </div>
            </form> <!-- End of Service Request Form -->


            <!-- USER ACCESS FORM  -->
            <form id="access" name="access" method="post">
              <div id="access" class="accesst">
                <div class="search-bar"><h5 class="body-header"><b>New Access Request</b></h5></div>
                  <hr>
                    <div class="row">
                      <div class="col s12 m12 l6" id="form">
                        <h6>Request Details</h6>
                        <div class="col s12 m12 l6">
                          <div class="row" id="request-form-row4">
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
                          <div class="row" id="request-form-row4">
                            <div class="col s12">
                              <div class="input-field" id="request-form">
                                <input placeholder=" " name="rc_no" type="number" class="validate">
                                <label for="rc_no">R.C. Number</label>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row" id="request-form-row3">
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
                        <div class="row" id="request-form-row2">
                          <div class="col s12">
                            <div class="input-field" id="request-form">
                              <input placeholder=" " name="access_request" type="text" class="validate">
                              <label for="Access Request">Access Request</label>
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
                                <div class="input-field search-box" id="request-form">
                                  <input placeholder=" " name="approver" autocomplete="off" type="text" class="validate">
                                  <div class="result" id="result1"></div>
                                  <label for="approver">Approver</label>
                                </div>
                              </div>
                            </div>

                            <div class="row" id="request-form-row3">
                              <div class="col s12">
                                <div class="input-field search-box" id="request-form">
                                  <input placeholder=" " name="checker" autocomplete="off" type="text" class="validate">
                                  <div class="result" id='result2'></div>
                                    <label for="approver">Checker</label>
                                </div>
                              </div>
                            </div>
                        <div class="row" id="request-form-row3">
                         <div class="col s12">
                           <div class="input-field" id="request-form">
                             <input type="text" class="datepicker"  id="expiry_date" name="expiry_date" placeholder="">
                             <label for="expiry_date">Expiry Date (YYYY/MM/DD)</label>
                           </div>
                         </div>
                        </div>
                        <div class="row">
                          <div class="col s12">
                            <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                            <input class="waves-effect waves-light cancel" id="request-form" name="submit" type="submit" value="Cancel">
                          </div>
                        </div>
                      </div>
                    </div>
              </div>
            </form><!-- End of User Access Request Form -->

          <!-- ************** IMPORT JAVASCRIPT ************* -->
          <!--JQuery version of Materialize-->
          <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
          <!--Import materialize.js-->
          <script type="text/javascript" src="js/materialize.min.js"></script>
          <!--Import javascript.js for DataTables script-->
          <script type="text/javascript" src="js/javascript.js"></script>
          <!--Import for Sweet Alert-->
          <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </body>
</html>
