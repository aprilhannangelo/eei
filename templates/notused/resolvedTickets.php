
            <div class="resolved-tickets">
              <table id="datatable" class="striped">
                <div class="table-header">
                  <span class="table-title"><b>Resolved Tickets</b></span>
                  <div class="actions">
                    <!-- Dropdown Trigger for New Ticket -->
                    <a class="dropdown-button btn-sort" data-activates="dropdown6" data-beloworigin="true">Status</a>
                    <!-- Dropdown Structure -->
                    <ul id="dropdown6" class="dropdown-content collection">
                      <li><a class="pending">Pending</a></li>
                      <li><a class="inprogress">In Progress</a></li>
                      <li><a class="resolved">Resolved</a></li>
                      <li><a class="closed">Closed</a></li>
                    </ul>
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
                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                  //Query for the way the table is shown in hr-index.php
                  $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_status = 'Resolved' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";


                  $result = mysqli_query($db,$query);?>
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
                      <?php
                    }?>
                </tbody>
              </table>
            </div>
