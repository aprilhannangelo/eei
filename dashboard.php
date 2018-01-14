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
      // var myEvent = window.attachEvent || window.addEventListener;
      // var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable
      //
      // myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
      //     var confirmationMessage = ' ';  // a space
      //     (e || window.event).returnValue = confirmationMessage;
      //     return confirmationMessage;
      // });

      //on document load, hide access and service request forms
      // code in CSS display:none

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


      //initialize datepicker of materializecss
      $('.datepicker').pickadate({
         selectMonths: false, // Creates a dropdown to control month
         selectYears: false, // Creates a dropdown of 15 years to control year,
         // today: 'Today',
         today: 'Today',
         clear: 'Clear',
         close: 'Ok',
         closeOnSelect: false // Close upon selecting a date,
       });

     //set current date to field
      var now = new Date();
      var day = ("0" + now.getDate()).slice(-2);
      var month = ("0" + (now.getMonth() + 1)).slice(-2);
      var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
      $('#date_prepared').val(today);
      $('#date_prepared2').val(today);

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
              $(".main-body").show();
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
       //  $(".cancel").click(function(){
       //   window.history.back();
       //   return false;
       // });
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
              <li><a class="dropdown-button btn-invert" data-activates="dropdown2" data-beloworigin="true">New Ticket<i class="tiny material-icons" id="add-ticket">add</i></a></li>
              <li><a href="#!"><i class="small material-icons">notifications_none</i></a></li>
              <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="medium material-icons" style="margin-right: 10px">person_pin</i><?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?><i class="right tiny material-icons" id="profile">keyboard_arrow_down</i></a>
              </li>
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
          <li><a class="service"> Service Request</a></li>
      		<li><a class="access">Access Request</a></li>
      </ul>
    </header>

    <!-- Side Navigation -->
    <div class="col s12 m12 l2">
        <ul id="slide-out" class="side-nav fixed">
          <li><a class="waves-effect" href="#!"><i class="tiny material-icons">home</i>Home</a></li>
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
              <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Tickets for Review</a>
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
                <a class="collapsible-header" href="home.php"><i class="tiny material-icons">view_list</i>Requests for Review</a>
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
      <!-- End of Side Navigation -->

    <div class="col s12 m12 l10"> <!-- Note that "m8 l9" was added -->
      <!--body-->
      <div class="col s12 m12 l10">
        <div class="wrapper">
          <div class="main-container">
            <div class="main-body">
              <div class="container" id="dashboard">
                <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Export">

                <h4><b>Ticket Summary</b></h4>
                <div class="row">
                  <ul class="tabs">
                   <li class="tab col s6 l6"><a href="#test-swipe-1">Status</a></li>
                   <li class="tab col s6 l6"><a href="#test-swipe-2">Type</a></li>
                  </ul>
                </div>
                   <div id="test-swipe-1" class="col s12">
                     <div class="col s12 m12 l12">
                       <div class="row">
                         <div class="col s12 m12 l2" id="db-panel">
                           <div class="card-panel grey lighten-5">
                             <span id="db-panel-label-overdue">Overdue</span>
                             <!-- get number of tickets whose due date base on their severity level has passed -->
                             <!-- placeholder lang yung result nito for now hehe -->
                             <?php
                             $db = mysqli_connect("localhost", "root", "", "eei_db");

                               $query = "SELECT COUNT(ticket_status) AS status FROM ticket_t WHERE ticket_status='New'";
                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                  echo "<h3 class=\"db-panel-label-overdue\">" . $row['status'] . "</h3>";
                              };
                             ?>
                           </div>
                         </div>
                         <div class="col s6 m6 l2" id="db-panel">
                           <div class="card-panel grey lighten-5">
                             <span class="black-text" id="db-panel-label">New</span>
                             <?php
                             $db = mysqli_connect("localhost", "root", "", "eei_db");

                               $query = "SELECT COUNT(ticket_status) AS status FROM ticket_t WHERE ticket_status='New'";
                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                  echo "<h3>" . $row['status'] . "</h3>";
                              };
                             ?>
                           </div>
                         </div>
                         <div class="col s6 m6 l2" id="db-panel">
                           <div class="card-panel grey lighten-5">
                             <span class="black-text" id="db-panel-label">Pending</span>
                             <?php
                             $db = mysqli_connect("localhost", "root", "", "eei_db");

                               $query = "SELECT COUNT(ticket_status) AS status FROM ticket_t WHERE ticket_status='Pending'";
                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                 echo "<h3>" . $row['status'] . "</h3>";
                              };
                             ?>
                           </div>
                         </div>
                         <div class="col s6 m6 l2" id="db-panel">
                           <div class="card-panel grey lighten-5">
                             <span class="black-text" id="db-panel-label">Resolved</span>
                             <?php
                             $db = mysqli_connect("localhost", "root", "", "eei_db");

                               $query = "SELECT COUNT(ticket_status) AS status FROM ticket_t WHERE ticket_status='Resolved'";
                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                 echo "<h3>" . $row['status'] . "</h3>";
                              };
                             ?>
                           </div>
                         </div>
                         <div class="col s6 m6 l2" id="db-panel">
                           <div class="card-panel grey lighten-5">
                             <span class="black-text" id="db-panel-label">Closed</span>
                             <?php
                             $db = mysqli_connect("localhost", "root", "", "eei_db");

                               $query = "SELECT COUNT(ticket_status) AS status FROM ticket_t WHERE ticket_status='Closed'";
                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                 echo "<h3>" . $row['status'] . "</h3>";
                              };
                             ?>
                           </div>
                         </div>
                       </div>
                     </div>
                   </div>

               <div id="test-swipe-2" class="col s12">
                 <div class="col s12 m12 l12">
                   <div class="row">
                     <div class="col s12 m4 l4">
                       <div class="card-panel grey lighten-5" id="db-panel-2">
                         <span class="black-text" id="db-panel-label">Technicals</span>
                         <!-- get number of tickets whose due date base on their severity level has passed -->
                         <?php
                         $db = mysqli_connect("localhost", "root", "", "eei_db");

                           $query = "SELECT COUNT(ticket_category) AS cat FROM ticket_t WHERE ticket_category='Technicals'";
                           $result = mysqli_query($db,$query);

                           while($row = mysqli_fetch_assoc($result)){
                              echo "<h3>" . $row['cat'] . "</h3>";
                          };
                         ?>
                       </div>
                     </div>
                     <div class="col s12 m4 l4">
                       <div class="card-panel grey lighten-5" id="db-panel-2">
                         <span class="black-text" id="db-panel-label">Access</span>
                         <?php
                         $db = mysqli_connect("localhost", "root", "", "eei_db");

                         $query = "SELECT COUNT(ticket_category) AS cat FROM ticket_t WHERE ticket_category='Access'";
                           $result = mysqli_query($db,$query);

                           while($row = mysqli_fetch_assoc($result)){
                              echo "<h3>" . $row['cat'] . "</h3>";
                          };
                         ?>
                       </div>
                     </div>
                     <div class="col s12 m4 l4">
                       <div class="card-panel grey lighten-5" id="db-panel-2">
                         <span class="black-text" id="db-panel-label">Network</span>
                         <?php
                         $db = mysqli_connect("localhost", "root", "", "eei_db");

                           $query = "SELECT COUNT(ticket_category) AS cat FROM ticket_t WHERE ticket_category='Network'";
                           $result = mysqli_query($db,$query);

                           while($row = mysqli_fetch_assoc($result)){
                             echo "<h3>" . $row['cat'] . "</h3>";
                          };
                         ?>
                       </div>
                     </div>
                     </div>
                   </div>
                 </div>
                 <div class="search-bar"><h5 class="body-header"><b>How can we help you today?</b></h5>
                   <!-- <p><i>Need help on something? Try to search on our knowledge base first for simple solutions to your problems before submitting a ticket. </i></p> -->
                   <ul class="collapsible collapsible-accordion">
                     <li class="faq">
                       <a class="collapsible-header" href="#!">Technicals <i class="right tiny material-icons">keyboard_arrow_down</i></a>
                       <div class="collapsible-body">
                         <ul>
                           <li class="faq-category"><a href="#!">Computer</a></li>
                           <li class="faq-category"><a href="#!">Printer</a></li>
                           <li class="faq-category"><a href="#!">Scanner</a></li>
                           <li class="faq-category"><a href="#!">Mouse</a></li>
                           <li class="faq-category"><a href="#!">laptop</a></li>
                         </ul>
                       </div>
                     </li>
                     <li class="faq">
                       <a class="collapsible-header" href="#!">Access <i class="right tiny material-icons">keyboard_arrow_down</i></a>
                       <div class="collapsible-body">
                         <ul>
                           <li class="faq-category"><a href="#!">Computer</a></li>
                           <li class="faq-category"><a href="#!">Printer</a></li>
                           <li class="faq-category"><a href="#!">Scanner</a></li>
                         </ul>
                       </div>
                     </li>
                     <li class="faq">
                       <a class="collapsible-header" href="#!">Network <i class="right tiny material-icons">keyboard_arrow_down</i></a>
                       <div class="collapsible-body">
                         <ul>
                           <li class="faq-category"><a href="#!">Computer</a></li>
                           <li class="faq-category"><a href="#!">Printer</a></li>
                           <li class="faq-category"><a href="#!">Scanner</a></li>
                         </ul>
                       </div>
                     </li>
                   </ul>
                 </div>
               </div>

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
