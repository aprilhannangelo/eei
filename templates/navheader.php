<!-- Header Navbar goes here -->
<header class="page-topbar">
  <nav  class="color">
     <div class="nav-wrapper">
       <a href="#!" class="brand-logo"><img class="company_logo" src="img/eei.png"></a><span class="name">EEI Corporation's Help Desk</span>
       <ul class="right hide-on-med-and-down">
          <!-- Dropdown Trigger for New Ticket -->
          <li><a class="dropdown-button btn-invert" data-activates="dropdown2" data-beloworigin="true">New Ticket<i class="tiny material-icons" id="add-ticket">add</i></a></li>
          <!-- Dropdown Structure -->
          <ul id="dropdown2" class="dropdown-content collection">
              <li><a class="service"> Service Request</a></li>
              <li><a class="access">Access Request</a></li>
          </ul>

          <!-- Notification Bell Button -->
          <li><a href="#!"><i class="small material-icons">notifications_none</i></a></li>

          <!-- Dropdown Trigger for My Profile -->
          <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true"><i class="medium material-icons" style="margin-right: 10px">person_pin</i><?php echo $_SESSION['first_name'] . ' '. $_SESSION['last_name'] ?><i class="right tiny material-icons" id="profile">keyboard_arrow_down</i></a></li>
          <!-- Dropdown Structure -->
          <ul id="dropdown" class="dropdown-content collection">
              <li><a href="myprofile.php">My Profile</a></li>
              <li><a href="php_processes/logout.php">Log out</a></li>
          </ul>
       </ul>
     </div>
  </nav>
</header>
