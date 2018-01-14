<?php
  session_start();
  if(!isset($_SESSION['requestor_id'])){
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
            var myEvent = window.attachEvent || window.addEventListener;
            var chkevent = window.attachEvent ? 'onbeforeunload' : 'beforeunload'; /// make IE7, IE8 compatable

            myEvent(chkevent, function(e) { // For >=IE7, Chrome, Firefox
                var confirmationMessage = ' ';  // a space
                (e || window.event).returnValue = confirmationMessage;
                return confirmationMessage;
            });

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
        $(".requestort").hide();
        //if service request from dropdown menu is clicked..
        $('.service').click(function(){
          $(".main-body").hide();
          $(".servicet").show();
          $(".accesst").hide();
          $(".requestort").hide();
        });
        $('.requestor').click(function(){
          $(".main-body").hide();
          $(".servicet").hide();
          $(".accesst").hide();
          $(".requestort").show();
        });

        //if access request from dropdown menu is clicked..
        $('.access').click(function(){
          $(".main-body").hide();
          $(".accesst").show();
          $(".servicet").hide();
          $(".requestort").hide();
        });


        //initialize select dropdown for materialize [DO NOT REMOVE]
          $('select').material_select();
          $(".clickable-row").click(function() {
              window.location = $(this).data("href");
          });
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
          var ticketNo;
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

          $("#requestor").submit(function(e) {
            e.preventDefault();
            $.ajax({
              url: 'php_processes/new-requestor.php',
              type: 'POST',
              data: $(this).serialize(),
              success: function(data)
               {
                 requestor_name= JSON.parse(data);
                   swal("User Added!", "You have added " +requestor_name + " as a user" , "success");
               }

            })
          });

          $(".cancel").click(function(){
        		window.history.back();
        		return false;
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
                <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>View My Tickets</a>
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
              <?php }?>
        </ul>
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
  </div>

      <!--body-->
      <div class="col s12 m12 l10">
        <div class="wrapper">
          <div class="main-container">
            <div class="main-body">
              <div class="material-table">
                <div class="table-header">
                  <span class="table-title"><b>Manage Users</b></span>
                  <div class="actions">
                    <a href="#" class="modal-trigger waves-effect btn-flat nopadding requestor"><i class="material-icons">person_add</i></a>
                    <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                  </div>
                </div>
                <table id="datatable">
                  <thead>
                    <tr>
                      <th>Requestor Name</th>
                      <th>User ID</th>
                      <th>Email Address</th>
                      <th>User Type</th>
                    </tr>
                  </thead>
                  <tbody>
                    <!--Connect to mysql database-->
                    <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");
                    //Query for the way the table is shown in hr-index.php
                    $query = "SELECT * FROM requestor_t";


                    $result = mysqli_query($db,$query);
                    while ($row = mysqli_fetch_assoc($result)){
                    ?>

                      <tr class='clickable-row' data-href="profile.php?id=<?php echo $row['requestor_id']?>">
                            <td class = 'user-row'> <?php echo $row['first_name'] . ' ' . $row['last_name']?>  </td>
                            <td class = 'user-row'> <?php echo $row['userid']?>   </td>
                            <td class = 'user-row'> <?php echo $row['email_address']?>  </td>
                            <td class = 'user-row'> <?php echo $row['user_type']?> </td>
                          </tr>
                        <?php }?>
                  </tbody>
                </table>
              </div>
            </div>
            <!-- end of main body div -->

            <form id="requestor" name="requestor" method="post">
              <div id="requestor" class="requestort">
                <div class="search-bar"><h5 class="body-header"><b>New User</b></h5></div>
                <hr>
                  <div class="row">
                      <div class="col s12">
                        <div class="row">
                            <div class="col s12 l6" id="form">
                              <h6>User Details</h6>
                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input placeholder=" " class="userid" name="userid" type="text" data-length="40" class="validate" required>
                                    <label for="title">User ID</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input placeholder=" " class="fname" name="fname" type="text" data-length="40" class="validate" required>
                                    <label for="title">First Name</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input placeholder=" " class="lname" name="lname" type="text" data-length="40" class="validate" required>
                                    <label for="title">Last Name</label>
                                  </div>
                                </div>
                              </div>

                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input placeholder=" " class="email" name="email" type="text" data-length="40" class="validate" required>
                                    <label for="title">Email Address</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <input  class="password" name="password" type="text" data-length="40" class="validate" >
                                    <label for="title">Password</label>
                                  </div>
                                </div>
                              </div>
                              <div class="row" id="request-form-row">
                                <div class="col s12">
                                  <div class="input-field" id="request-form">
                                    <?php
                                      $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                                      <select name = "type" required>
                                      <option value= "">Select</option>
                                      <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'requestor_t' AND COLUMN_NAME = 'user_type'");
                                      $row = mysqli_fetch_array($get_user_type);
                                      $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                      foreach($enumList as $value){?>
                                      <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                          <?php } ?>
                                      </select>

                                  <label for="title">User Type</label>
                                  </div>
                                </div>
                              </div>

                                <div class="row">
                                  <input class="waves-effect waves-light submit" id="request-form" name="submit" type="submit" value="Submit">
                                  <input class="waves-effect waves-light cancel" id="request-form" name="submit" type="submit" value="Cancel">
                                </div>
                            </div>

                        </div>
                      </div>
                  </div>
                </div>
              </form>

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
