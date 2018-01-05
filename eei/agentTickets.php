<!DOCTYPE html>
<html>
  <head>
    <!--Import Google Icon Font-->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Import materialize.css-->
    <link type="text/css" rel="stylesheet" href="css/materialize.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" href="css/style.css"  media="screen,projection"/>
     <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--Let browser know website is optimized for mobile-->
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  </head>

  <body id="view-tickets-page">
    <!-- Navbar goes here -->
    <nav  class="blue-grey darken-4">
       <div class="nav-wrapper">
         <a href="#!" class="brand-logo"><img class="company_logo" src="img/eei.png"></p>
         <ul class="right hide-on-med-and-down">

            <li><a href="sass.html"><i class="small material-icons">notifications_none</i></a></li>
            <li><a class="dropdown-button" href="#!" data-activates="dropdown" data-beloworigin="true">April Hann Angelo<i class="mdi-navigation-arrow-drop-down right"></i></a></li>
         </ul>
       </div>
    </nav>
    <!-- Dropdown Structure -->
    <ul id="dropdown" class="dropdown-content collection">
        <li><a href="sass.html">My Profile</a></li>
    		<li><a href="sass.html">Log out</a></li>
    </ul>
  <!-- Page Layout here -->
  <div class="row">
    <div class="col s12 m12 l2"> <!-- Note that "m4 l3" was added -->
        <ul id="slide-out" class="side-nav fixed">
          <li><a href="index.html"><i class="tiny material-icons">home</i>Home</a></li>
            <ul class="collapsible collapsible-accordion">
              <li>
                <a class="collapsible-header" href="#!"><i class="tiny material-icons">view_list</i>View Tickets</a>
                <div class="collapsible-body">
                  <ul>
                    <li class="collapsible"><a href="#!">All Tickets</a></li>
                    <li class="collapsible"><a href="#!">In Progress</a></li>
                    <li class="collapsible"><a href="#!">Resolved</a></li>
                  </ul>
                </div>
              </li>
            </ul>
          <li><a href="#!"><i class="tiny material-icons">settings</i>Manage Users</a></li>
        </ul>
        <a href="#" data-activates="slide-out" class="button-collapse"><i class="material-icons">menu</i></a>
    </div>

    <div class="col s12 m12 l10" id="view-tickets-body"> <!-- Note that "m8 l9" was added -->
      <!--body-->
      <div class="top-panel">
        <div class="sub-container">
              <!-- Dropdown Trigger -->
            <!-- <a class='dropdown-button btn' href='#' data-activates='dropdown1'>Type</a> -->

            <!-- Dropdown Structure -->
            <!-- <ul id='dropdown1' class='dropdown-content'>
              <li><a href="#!">one</a></li>
              <li><a href="#!">two</a></li>
              <li class="divider"></li>
              <li><a href="#!">three</a></li>
              <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
              <li><a href="#!"><i class="material-icons">cloud</i>five</a></li>
            </ul> -->
          </div>
          <div class="material-table">
            <div class="table-header">
              <span class="table-title"><b>All Tickets</b></span>
              <div class="actions">
                <a href="#add_users" class="modal-trigger waves-effect btn-flat nopadding"><i class="material-icons">person_add</i></a>
                <a href="#" class="search-toggle waves-effect btn-flat nopadding"><i class="material-icons">search</i></a>
              </div>
            </div>
            <table id="datatable">
              <thead>
                <tr>
                  <th>Name</th>
                  <th>Position</th>
                  <th>Office</th>
                  <th>Age</th>
                  <th>Start date</th>
                  <th>Salary</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>Tiger Nixon</td>
                  <td>System Architect</td>
                  <td>Edinburgh</td>
                  <td>61</td>
                  <td>2011/04/25</td>
                  <td>$320,800</td>
                </tr>
                <tr>
                  <td>April Angelo</td>
                  <td>Developer</td>
                  <td>Edinburgh</td>
                  <td>61</td>
                  <td>2011/04/25</td>
                  <td>$320,800</td>
                </tr>
              </tbody>
            </table>
        </div>

        </div>


        </div>


  </div>
</div>

  </div>
      <!--Import jQuery before materialize.js-->
      <script type="text/javascript" src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
      <script type="text/javascript" src="js/materialize.min.js"></script>
    <script src='https://cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/materialize/0.97.0/js/materialize.min.js'></script>
    <script type="text/javascript" src="js/javascript.js"></script>

    </body>
</html>
