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
  <?php include 'templates/css_resources.php' ?>
</head>

<body>
  <?php include 'templates/navheader.php'; ?>

  <!-- ****************************************************** -->

  <!--body-->
    <div class="col s12 m12 l10">
      <div class="wrapper">
        <?php include 'templates/sidenav.php'; ?>

        <div class="main-container">
          <div class="main-body">
            <div class="col s6 m6 l12">
              <div class="col s6 m6 l4">


               </div>
             </div>


            <div class="col s12 m12 l12">
              <div class="row">
                <div class="col s12 m12 l7">
                  <div class="card panel" id="detail-header">
                  <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");

                    $query2 = "SELECT t.ticket_number, u.isChecked, u.isApproved, u.approver as approver,u.checker as checker FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE t.ticket_id = '".$_GET['id']."'";

                    $result2= mysqli_query($db,$query2);

                    while($row = mysqli_fetch_assoc($result2)){?>
                      <div class="header">

                       <?php echo "<h5><input class=\"material-icons\" alt=\"Go back\" type=\"submit\" id=\"details-back\" value=\"arrow_back\" onclick=\"window.history.go(-1); return false;\"><b>Ticket #" . $row['ticket_number'];

                       $id = $_SESSION['requestor_id'];
                       $ticketID =$_GET['id'];

                       if ($row['approver']==$id) { ?>
                       <form id="approve" name="approve" method="post">
                         <input id="approve" type="submit" onclick="php_processes/approve-process.php'" value="Approve">
                         <input  id="approve" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                       </form>

                      <?php }
                      elseif ($row['checker']==$id) { ?>
                       <form id="check" name="check" method="post">
                       <input id="check" type="submit" onclick="php_processes/check-process.php'" value="Check" />
                         <input id="check" name = "ticketID" type="hidden" value="<?php echo $ticketID?>">
                      </form>
                    <?php }};?>
                      </div>
                    </div>

                  <div class="card-panel">
                    <span class="black-text">
                      <?php
                        $db = mysqli_connect("localhost", "root", "", "eei_db");

                        $query = "SELECT t.ticket_title, s.request_details, r.email_address as email, DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join service_ticket_t s on (s.ticket_id=t.ticket_id) WHERE s.ticket_id = '".$_GET['id']."'";
                        $query2 = "SELECT u.isChecked, u.isApproved, u.approver as approver,u.checker as checker,t.ticket_title, u.access_requested, u.dept_proj,DATE_FORMAT(date_prepared, '%W %M %e %Y') as date_prepared, CONCAT(r.first_name, ' ', r.last_name) As requestor , r.user_type as user_type FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) left join user_access_ticket_t u on (u.ticket_id=t.ticket_id) WHERE u.ticket_id = '".$_GET['id']."'";

                        $result = mysqli_query($db,$query);
                        $result2= mysqli_query($db,$query2);


                        while($row = mysqli_fetch_assoc($result)){
                            $email = $row['email'];
                           echo "<h5><b>" . $row['ticket_title'] . "</h5>" .
                                "<p id=\"requestor_details\">" . "<style=\"color:blue\">" . "<span class=\"name-in-ticket tooltipped\" data-position=\"right\" data-delay=\"50\" data-tooltip=\"$email\">" . $row['requestor'] . "</span>" . "<span class=\"request_date\">" . " reported on " . $row['date_prepared'] . "</p>" .
                                "<p id=\"details\">" . $row['request_details'] . "</p>";
                       };
                       while($row = mysqli_fetch_assoc($result2)){

                          echo "<h5><b>" . $row['ticket_title'] . "</h5>" .
                               "<p id=\"requestor_details\">" . "<style=\"color:blue\">" . "<span class=\"name-in-ticket\">" . $row['requestor'] . "</span>" . "<span class=\"request_date\">" . " reported on " . $row['date_prepared'] . "</p>" .
                               "<br> <p id=\"details\">" . $row['access_requested'] . "</p>";
                          }; ?>

                 </div>
                 <?php if($_SESSION['user_type'] == 'Administrator'){ ?>
                 <div class="card-panel" id="ticket-properties">
                   <span class="black-text">
                        <form id="properties" name="properties" method="post">
                          <div class="tprop-header"><h6>Assign Ticket Properties</h6></div>
                          <div class="tprop"><input class="waves-effect waves-light save" id="request-form-row" name="submit" type="submit" value="Save"></div>
                   </span>
                          <div id="properties" class="row " id="request-form-row">
                            <div class="col s12 m12 l12 properties-box" id="properties-box">
                              <div class="col s12 m6 l6">
                                <div class="input-field ticket-properties" id="request-form">
                                  <?php
                                    $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                                    <select name = "category" required>
                                    <option value= "disabled selected">Select</option>
                                    <?php $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'ticket_category'");
                                    $row = mysqli_fetch_array($get_user_type);
                                    $enumList = explode(",", str_replace("'", "", substr($row['column_type'], 5, (strlen($row['column_type'])-6))));
                                    foreach($enumList as $value){?>
                                    <option value='<?php echo $value?>'> <?php echo $value?> </option>
                                        <?php } ?>
                                    </select>

                                <label for="title">Category</label>
                                </div>
                              </div>
                              <div class="col s12 m6 l6">
                                <div class="input-field ticket-properties" id="request-form">
                                  <?php
                                    $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                                    <select name = "severity" required >
                                    <option value="">Select</option>
                                    <?php

                                    $get_user_type = mysqli_query($db, "SELECT column_type FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_NAME = 'ticket_t' AND COLUMN_NAME = 'severity_level'");
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
                                <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
                              </div>
                            </div>
                          </div>
                      </form>
                   </span>
                </div>
              <?php } ?>

             <?php if($_SESSION['user_type'] == 'Technicals Group Manager'){ ?>
               <div class="card-panel" id="ticket-properties">
               <form id="assignee" name="properties" method="post">
                 <div class="tprop-header"><h6>Assign to Ticket Agent</h6></div>
                 <div class="tprop">
                   <input class="waves-effect waves-light save" id="request-form-row" name="submit" type="submit" value="Save">
                   <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
                 </div>

                 <div id="properties" class="row " id="request-form-row">
                   <div class="col s12 m12 l12 properties-box" id="properties-box">
                     <div class="input-field ticket-properties" id="request-form">
                       <?php
                         $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                         <select name = "assignee" required >
                         <option value="">Select</option>
                           <?php
                             $result = mysqli_query($db, "SELECT requestor_id, CONCAT(first_name, ' ', last_name) AS technician FROM requestor_t WHERE user_type = 'Technician'");

                             while ($row = mysqli_fetch_array($result))
                               {?>
                                   <option value='<?php echo $row['requestor_id']?>'> <?php echo $row['technician'] ?></option>;
                                   <?php
                               } ?>

                               </select>
                         <label for="title">Select Technician:</label>
                     </div>
                 </div>
               </div>
             </div>
           </form>
         <?php } ?>
         <?php if($_SESSION['user_type'] == 'Network Group Manager'){ ?>
           <div class="card-panel" id="ticket-properties">
           <form id="assignee" name="properties" method="post">
             <div class="tprop-header"><h6>Assign to Ticket Agent</h6></div>
             <div class="tprop">
               <input class="waves-effect waves-light save" id="request-form-row" name="submit" type="submit" value="Save">
               <input value = "<?php echo $_GET['id']?>" class="title" name="id" type="hidden" data-length="40" class="validate" required>
             </div>

             <div id="properties" class="row " id="request-form-row">
               <div class="col s12 m12 l12 properties-box" id="properties-box">
                 <div class="input-field ticket-properties" id="request-form">
                   <?php
                     $db = mysqli_connect("localhost", "root", "", "eei_db");?>

                     <select name = "assignee" required >
                     <option value="">Select</option>
                       <?php
                         $result = mysqli_query($db, "SELECT requestor_id, CONCAT(first_name, ' ', last_name) AS nengineer FROM requestor_t WHERE user_type = 'Network Engineer'");

                         while ($row = mysqli_fetch_array($result))
                           {?>
                               <option value='<?php echo $row['requestor_id']?>'> <?php echo $row['nengineer'] ?></option>;
                               <?php
                           } ?>

                           </select>
                     <label for="title">Select Network Engineer:</label>
                 </div>
             </div>
           </div>
         </div>
       </form>
     <?php } ?>
       </div>


                <div class="col s12 m12 l5">
                  <div class="card-panel" id="right-card">
                    <span class="black-text">
                      <table id="ticket-details">
                        <tbody>
                            <?php
                            $db = mysqli_connect("localhost", "root", "", "eei_db");

                              $query = "SELECT t.ticket_status, t.severity_level, t.ticket_category, t.date_required FROM ticket_t t WHERE ticket_id = '".$_GET['id']."'";

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


                                echo "<tr><td class=\"first\">" . "Category" . "</td><td>"  . $row['ticket_category']  . "</td>" .
                                     "<tr><td class=\"first\">" . "Status" .  "</td><td><span class=\"badge new\">" . $row['ticket_status'] . "</span></td>" .
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
                          <h6><i class="material-icons">info</i>&nbsp;Other Ticket Information</h6>
                          <?php
                            $db = mysqli_connect("localhost", "root", "", "eei_db");

                            $query = "SELECT CONCAT(r.first_name, ' ', r.last_name) As requestor , r.email_address AS email FROM ticket_t t INNER JOIN requestor_t r  on (t.requestor_id=r.requestor_id) WHERE t.ticket_id = '".$_GET['id']."'";

                             $result = mysqli_query($db,$query);

                             while($row = mysqli_fetch_assoc($result)){
                               echo "<div class=\"row\" id=\"tagent-info\">" .
                                      "<div class=\"name-in-ticket\">" . $row['requestor'] . "</div>" .
                                      "<div class=\"request_date\">" . $row['email'] . "</div>" .
                                      "<div class=\"request_date\">" . "Requestor" . "</div>" .

                                      "</div>";
                            };
                           ?>
                           <?php
                             $db = mysqli_connect("localhost", "root", "", "eei_db");

                             $query = "SELECT CONCAT(r.first_name, r.last_name) AS approver, r.email_address AS email FROM requestor_t r LEFT JOIN user_access_ticket_t U ON r.requestor_id = u.approver WHERE u.ticket_id = '".$_GET['id']."'";

                              $result = mysqli_query($db,$query);

                              while($row = mysqli_fetch_assoc($result)){
                                echo "<div class=\"row\" id=\"tagent-info\">" .
                                       "<div class=\"name-in-ticket\">" . $row['approver'] . "</div>" .
                                       "<div class=\"request_date\">" . $row['email'] . "</div>" .
                                       "<div class=\"request_date\">" . "Approver" . "</div>" .
                                       "</div>";
                             };
                            ?>

                            <?php
                              $db = mysqli_connect("localhost", "root", "", "eei_db");

                              $query = "SELECT CONCAT(r.first_name, r.last_name) AS checker, r.email_address AS email FROM requestor_t r LEFT JOIN user_access_ticket_t U ON r.requestor_id = u.checker WHERE u.ticket_id = '".$_GET['id']."'";

                               $result = mysqli_query($db,$query);

                               while($row = mysqli_fetch_assoc($result)){
                                 echo "<div class=\"row\" id=\"tagent-info\">" .
                                        "<div class=\"name-in-ticket\">" . $row['checker'] . "</div>" .
                                        "<div class=\"request_date\">" . $row['email'] . "</div>" .
                                        "<div class=\"request_date\">" . "Checker" . "</div>" .
                                        "</div>";
                              };
                             ?>

                             <?php
                               $db = mysqli_connect("localhost", "root", "", "eei_db");

                               $query = "SELECT CONCAT(r.first_name, r.last_name) AS tagent, r.email_address AS email FROM requestor_t r LEFT JOIN ticket_t t ON r.requestor_id =t.ticket_agent_id WHERE t.ticket_id = '".$_GET['id']."'";

                                $result = mysqli_query($db,$query);

                                while($row = mysqli_fetch_assoc($result)){
                                  echo "<div class=\"row\" id=\"tagent-info\">" .
                                         "<div class=\"name-in-ticket\">" . $row['tagent'] . "</div>" .
                                         "<div class=\"request_date\">" . $row['email'] . "</div>" .
                                         "<div class=\"request_date\">" . "Ticket Agent" . "</div>" .
                                         "</div>";
                               };
                              ?>

                           <hr style="margin-bottom: 15px;">
                           <h6><i class="material-icons">edit</i>&nbsp; Ticket Activity Log</h6>
                           <div id="container" class="alog">
                             <?php if ($_SESSION['user_type'] != 'Requestor'){ ?>
                              <div class="comment_input">
                                  <div class="row">
                                    <form id="activity_log" method="POST">
                                      <div class="row">
                                       <div class="input-field col s12">
                                        <input type="text" id="activity_log" name="comments" placeholder=" " class="materialize-textarea" required>
                                        <label for="activity_log">Log activity here</label>
                                        <?php
                                          $db = mysqli_connect("localhost", "root", "", "eei_db");

                                          $query2 = "SELECT COUNT(*) as count, ticket_number FROM ticket_t WHERE ticket_id = '".$_GET['id']."'";

                                          $result2= mysqli_query($db,$query2);

                                          while($row = mysqli_fetch_assoc($result2)){
                                            // $logger = $_SESSION['requestor_id'];

                                            $ticketID = $row['ticket_number'];
                                          }
                                         ?>
                                         <div class="tprop"><input id="post" class="waves-effect waves-light save" type="submit" name="submit" onclick="php_processes/activitylog_process.php'" value="Post" />
                                         <input id="post" name = "ticketID" type="hidden" value="<?php echo $ticketID?>"></div>
                                        </div>
                                      </div>
                                    </form>
                                  </div>
                                </div>
                                <?php   } ?>
                              <div id="comment_logs">
                                <?php
                                $db = mysqli_connect("localhost", "root", "", "eei_db");
                                $result = mysqli_query($db, "SELECT a.activity_log_details, DATE_FORMAT(a.timestamp, '%M %e %Y') as timestamp, a.logger, a.activity_log_id, CONCAT(r.first_name, ' ', r.last_name) AS user, t.ticket_number FROM activity_log_t a LEFT JOIN ticket_t t ON a.ticket_no = t.ticket_number LEFT JOIN requestor_t r ON r.requestor_id = a.logger WHERE t.ticket_id = '".$_GET['id']."' ORDER BY a.activity_log_id DESC");
                                while($row=mysqli_fetch_array($result)){
                                  // echo "<h6>Logs</h6><br>";
                                  if (mysqli_num_rows($result)==0) {
                                    echo "<i>There are no activity logs for this ticket.</i>"; }
                                     else {
                                        echo "<div class='comments_content'>";
                                        echo "<div class=\"row\" id=\"logs\">" .
                                               "<div class=\"user\">" . $row['user'] . "</div>" .
                                               "<div class=\"date_posted\">" . $row['timestamp'] . "</div>" .
                                               "<div class=\"details\">" .  $row['activity_log_details'] . "</div>" .
                                               "</div><hr></div>";};};
                                ?>
                              </div>
                            </div>








                </div>
              </div>
            </div>
          </div><!-- end div of row -->
        </div><!-- end div of main body -->

        <!-- ****************************************************** -->

        <!-- HIDDEN FORMS -->
        <?php include 'templates/ticketforms.php'; ?>

      </div> <!-- End of main container of col 10 -->
    </div> <!-- End of wrapper of col l10 -->
  </div>
  <!-- END OF COL l10 -->

  <?php include 'templates/js_resources.php' ?>

  </body>
</html>
