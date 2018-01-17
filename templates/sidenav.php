<!-- Side Navigation -->
<div class="col s12 m12 l2">
    <!-- Slideout Navigation -->
    <ul id="slide-out" class="side-nav fixed">
      <li><a class="waves-effect" href="home.php"><i class="tiny material-icons">home</i>Home</a></li>
      <ul class="collapsible collapsible-accordion">
        <li>
          <a class="collapsible-header waves-effect" href="#!"><i class="tiny material-icons">view_list</i>My Tickets</a>
          <div class="collapsible-body">
            <ul>
              <li class="collapsible"><a class="all" href="allTickets.php">All Tickets
                <!-- Badge Counter -->
                <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                  $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t LEFT JOIN requestor_t r ON t.requestor_id = r.requestor_id WHERE t.requestor_id = '".$_SESSION['requestor_id']."'";

                  $result = mysqli_query($db,$query); ?>

                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <span class="badge ticket_count"> <?php echo $row['count'] ?></span>
                  <?php } ?>
              </a></li>

              <li class="collapsible"><a class="inprogress" href="inprogressTickets.php">In Progress
                <!-- Badge Counter -->
                <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                  $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t LEFT JOIN requestor_t r ON t.requestor_id = r.requestor_id WHERE t.ticket_status='In Progress' AND t.requestor_id = '".$_SESSION['requestor_id']."'";

                  $result = mysqli_query($db,$query); ?>

                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <span class="badge ticket_count"> <?php echo $row['count'] ?></span>
                  <?php } ?>
              </a></li>

              <li class="collapsible"><a class="resolved" href="resolvedTickets.php">Resolved
                <!-- Badge Counter -->
                <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                  $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t LEFT JOIN requestor_t r ON t.requestor_id = r.requestor_id WHERE t.ticket_status='Resolved' AND t.requestor_id = '".$_SESSION['requestor_id']."'";

                  $result = mysqli_query($db,$query); ?>

                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <span class="badge ticket_count"> <?php echo $row['count'] ?></span>
                  <?php } ?>
              </a></li>

              <li class="collapsible"><a class="pending" href="pendingTickets.php">Pending
                <!-- Badge Counter -->
                <?php
                  $db = mysqli_connect("localhost", "root", "", "eei_db");
                  $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t LEFT JOIN requestor_t r ON t.requestor_id = r.requestor_id WHERE t.ticket_status='Pending' AND t.requestor_id = '".$_SESSION['requestor_id']."'";

                  $result = mysqli_query($db,$query); ?>

                  <?php while($row = mysqli_fetch_assoc($result)){ ?>
                    <span class="badge ticket_count"> <?php echo $row['count'] ?></span>
                  <?php } ?>
              </a></li>
            </ul>
          </div> <!-- End of div collapsible body -->
        </li>
      </ul> <!-- End of div My Tickets accrodion -->

      <?php if($_SESSION['user_type'] == 'Administrator'){ ?>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Tickets for Review</a>
            <div class="collapsible-body">
              <ul>
                <li class="collapsible"><a href="incomingRequests.php">Incoming Tickets </a></li>
                <li class="collapsible"><a href="#!">All Tickets</a></li>
                <li class="collapsible"><a href="#!">Resolved Tickets</a></li>
              </ul>
            </div>
          </li>
        </ul>

      <?php } elseif($_SESSION['user_type'] == 'Requestor'){ ?>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header" href="#!"><i class="tiny material-icons">hourglass_full</i>Requests for Review</a>
            <div class="collapsible-body">
              <ul>
                <li class="collapsible"><a href="incomingRequests.php">Incoming</a></li>
                <li class="collapsible"><a href="approvedRequests.php">Approved
                  <!-- Badge Counter -->
                  <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");

                    $id = $_SESSION['requestor_id'];
                    $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t  LEFT JOIN requestor_t r ON t.requestor_id = r.requestor_id LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE t.requestor_id = $id AND user_access_ticket_t.isApproved = true";

                    $result = mysqli_query($db,$query); ?>

                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                      <span class="badge ticket_count"> <?php echo $row['count'] ?></span>
                    <?php } ?>
                </a></li>
                <li class="collapsible"><a href="checkedRequests.php">Checked
                  <!-- Badge Counter -->
                  <?php
                    $db = mysqli_connect("localhost", "root", "", "eei_db");

                    $id = $_SESSION['requestor_id'];
                    $query = "SELECT COUNT(t.ticket_id) AS count FROM ticket_t t  LEFT JOIN requestor_t r ON t.requestor_id = r.requestor_id LEFT JOIN user_access_ticket_t USING (ticket_id, ticket_number) WHERE t.requestor_id = $id AND user_access_ticket_t.isChecked = true AND user_access_ticket_t.isApproved = false";

                    $result = mysqli_query($db,$query); ?>

                    <?php while($row = mysqli_fetch_assoc($result)){ ?>
                      <span class="badge ticket_count"> <?php echo $row['count'] ?></span>
                    <?php } ?>
                </a></li>
              </ul>
            </div>
          </li>
        </ul>

      <?php } elseif($_SESSION['user_type'] == 'Technicals Group Manager'){ ?>
        <ul class="collapsible collapsible-accordion">
          <li>
            <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>Technicals Tickets</a>
            <div class="collapsible-body">
              <ul>
                <li class="collapsible"><a href="incomingRequests.php">Incoming Tickets</a></li>
                <li class="collapsible"><a href="#!">All Tickets</a></li>
                <li class="collapsible"><a href="resolvedTickets">Resolved Tickets</a></li>
              </ul>
            </div>
          </li>
        </ul>

      <?php } elseif($_SESSION['user_type'] == 'Access Group Manager'){ ?>
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

      <?php } elseif($_SESSION['user_type'] == 'Technician' OR $_SESSION['user_type'] == 'Network Engineer'){ ?>
         <ul class="collapsible collapsible-accordion">
           <li>
             <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>My Assigned Tickets</a>
             <div class="collapsible-body">
               <ul>
                 <li class="collapsible"><a href="incomingRequests.php">Incoming Tickets</a></li>
                 <li class="collapsible"><a href="#!">All Access Tickets</a></li>
                 <li class="collapsible"><a href="#!">Resolved Access Tickets</a></li>
               </ul>
             </div>
           </li>
         </ul>
      <?php } ?>

    </ul>
    <!-- End of slideout navigation  -->

  <!-- Hamburger menu icon when screen resized -->
  <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
</div>
<!-- End of Side Navigation -->
