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
          <div class="main-body">
            <div class="material-table">
              <!-- DEFAULT DISPLAY: HIDDEN  -->
              <div class="pending-tickets">
                <table id="datatable" class="striped">
                  <div class="table-header">
                    <span class="table-title"><b>Pending Tickets</b></span>
                    <div class="actions">
                      <div class="sorter">
                        <!-- Dropdown Trigger for New Ticket -->
                        <a class="dropdown-button btn-sort" data-activates="dropdown3" data-beloworigin="true">Category</a>
                        <!-- Dropdown Structure -->
                        <ul id="dropdown3" class="dropdown-content collection">
                            <li><a href="?view=technicals" class="technicals">Technicals</a></li>
                            <li><a href="?view=access" class="accesstickets">Access</a></li>
                            <li><a href="?view=network" class="network">Network</a></li>
                        </ul>
                        <!-- Dropdown Trigger for New Ticket -->
                          <a class="dropdown-button btn-sort" data-activates="dropdown4" data-beloworigin="true">Severity</a>
                        <!-- Dropdown Structure -->
                        <ul id="dropdown4" class="dropdown-content collection">
                            <li><a href="?view=sev1">SEV1</a></li>
                            <li><a href="?view=sev2">SEV2</a></li>
                            <li><a href="?view=sev3">SEV3</a></li>
                            <li><a href="?view=sev4">SEV4</a></li>
                            <li><a href="?view=sev5">SEV5</a></li>
                        </ul>
                      </div>
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
                    <!--Connect to mysql database-->
                    <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");{

                      //all my pending tickets
                      $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";

                      //if category button for sorting is selected
                      switch ((isset($_GET['view']) ? $_GET['view'] : ''))
                      {
                          case ("technicals"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.ticket_category='Technicals' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;

                          case ("access"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.ticket_category='Access' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;

                          case ("network"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.ticket_category='Network' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;
                      }

                      //if severity button for sorting is selected
                      switch ((isset($_GET['view']) ? $_GET['view'] : ''))
                      {
                          case ("sev1"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.severity_level='SEV1' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;

                          case ("sev2"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.severity_level='SEV2' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;

                          case ("sev3"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.severity_level='SEV3' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;

                          case ("sev4"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.severity_level='SEV4' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;

                          case ("sev5"):
                            $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Pending' AND ticket_t.severity_level='SEV5' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
                            break;
                      } ?>

                    <?php $result = mysqli_query($db,$query);?>
                       <?php while($row = mysqli_fetch_assoc($result)){
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
                          }
                         ?>

                          <tr class='clickable-row' data-href="details.php?id=<?php echo $row['ticket_id']?>">
                            <td id="type"><span class="<?php echo $class?>"> <?php echo $row['ticket_category'][0]?></span><p style="margin-top:25px;margin-bottom:-5px;font-size:8pt;"><?php echo $row['severity_level']?></p></td>
                            <td> <?php echo $row['ticket_number']?>  </td>
                            <td><span class="badge new"><?php echo $row['ticket_status']?>  </span></td>
                            <td> <?php echo $row['ticket_title']?>   </td>
                            <td> <?php echo $row['date_prepared']?>  </td>
                            <td> <?php echo $row['remarks'] ?>       </td>
                          </tr>
                        <?php }} ?>
                  </tbody>
                </table>
              </div>
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
