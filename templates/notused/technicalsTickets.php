<!-- DEFAULT DISPLAY: VISIBLE  -->
<div class="technicals-tickets">
  <table id="datatable" class="striped">
    <div class="table-header">
      <span class="table-title"><b>All Technicals Tickets</b></span>
      <div class="actions">
        <div class="sorter">
          <!-- Dropdown Trigger for New Ticket -->
          <a class="dropdown-button btn-sort" data-activates="dropdown4" data-beloworigin="true">Category</a>
          <!-- Dropdown Structure -->
          <ul id="dropdown4" class="dropdown-content collection">
              <li><a class="technicals" selected>Technicals</a></li>
              <li><a class="access">Access</a></li>
              <li><a class="network">Network</a></li>
          </ul>
          <!-- Dropdown Trigger for New Ticket -->
            <a class="dropdown-button btn-sort" data-activates="dropdown4" data-beloworigin="true">Severity</a>
          <!-- Dropdown Structure -->
          <ul id="dropdown4" class="dropdown-content collection">
              <li><a class="s1">SEV1</a></li>
              <li><a class="s2">SEV2</a></li>
              <li><a class="s3">SEV3</a></li>
              <li><a class="s4">SEV4</a></li>
              <li><a class="s5">SEV5</a></li>
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
      <?php
      $db = mysqli_connect("localhost", "root", "", "eei_db");
          $query = "SELECT * FROM ticket_t LEFT JOIN service_ticket_t USING (ticket_id, ticket_number) LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE ticket_t.ticket_category='Technicals' AND ticket_t.requestor_id = '".$_SESSION['requestor_id']."'";
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
    </tbody>
  </table>
</div>
