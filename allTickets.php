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
  <?php include 'templates/sidenav.php'; ?>

  <!-- ****************************************************** -->

  <!--body-->
    <div class="col s12 m12 l10">
      <div class="wrapper">
        <div class="main-container">
          <div class="material-table">

            <!-- DEFAULT DISPLAY: VISIBLE  -->
            <div class="all-tickets">
              <table id="datatable" class="striped">
                <div class="table-header">
                  <span class="table-title"><b>All Tickets</b></span>
                  <div class="actions">
                    <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
                  </div>
                </div>
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
                  $db = mysqli_connect("localhost", "root", "", "eei_db"); {?>

                    <!-- DISPLAY ASSIGNED TICKETS OF TECHNICIAN-->
                    <?php
                      if($_SESSION['user_type'] == 'Technician') {
                    ?>
                      <?php
                          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_agent_id = '".$_SESSION['requestor_id']."'";
                       ?>

                    <!-- DISPLAY ASSIGNED TICKETS OF ENGINEER-->
                    <?php } elseif($_SESSION['user_type'] == 'Network Engineer'){?>
                      <?php
                          $query = "SELECT * FROM ticket_t LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_agent_id = '".$_SESSION['requestor_id']."'";
                       ?>

                    <!-- EVERYONE ELSE NA HINDI TICKET AGENT DISPLAY TICKETS THEY SUBMITTED -->
                    <?php } else { ?>
                      <?php
                          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                       ?>

                    <?php }

                          $result = mysqli_query($db,$query);
                          while($row = mysqli_fetch_assoc($result)){
                             switch($row['ticket_category'])
                              {
                                  // assumes 'type' column is one of CAR | TRUCK | SUV
                                  case("Technicals"):
                                      $class = 'ticket_cat_t';
                                      break;
                                  case("Access"):
                                     $class = 'ticket_cat_a';
                                     break;
                                  case("Network"):
                                    $class = 'ticket_cat_n';
                                    break;
                                  case(""):
                                    $class = 'ticket_cat_blank';
                                    break;
                              }?>

                            <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                              <td id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                              <td> <?php echo $row['ticket_number']?>  </td>
                              <td><span class="badge new"><?php echo $row['ticket_status']?>  </span></td>
                              <td> <?php echo $row['ticket_title']?>   </td>
                              <td> <?php echo $row['date_prepared']?>  </td>
                              <td> <?php echo $row['remarks'] ?>       </td>
                            </tr>
                          <?php } ?>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>

          </div>

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
