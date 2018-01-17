<?php
  session_start();
  if(!isset($_SESSION['requestor_id'])){
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

    <!-- COL L10-->
      <div class="col s12 m12 l10">
        <div class="wrapper">
          <div class="main-container">
            <div class="main-body">
              <?php if($_SESSION['user_type'] == 'Administrator'){
                include 'templates/dashboard.php';
              } else { ?>

              <div class="search-bar"><h5 class="body-header">Hi, <b><?php echo $_SESSION['first_name'] ?></b>! How can we help you today?</h5>
                <div class="input-field col s12 m12 l10">
                    <form>
                      <input id="search" placeholder="Search knowledge base" type="search" required>
                      <label class="label-icon" for="search"><i class="material-icons">search</i></label>
                      <i class="material-icons">close</i>
                  </form>
                </div>
              </div>
              <br>

              <!-- KNOWLEDGE BASE -->
              <div class="search-bar"><h5 class="body-header">Knowledge Base</h5>
                <p><i>Need help on something? Try to search on our knowledge base first for simple solutions to your problems before submitting a ticket. </i></p>
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
            </div><!-- End of div main body -->

            <?php } ?>

      <!-- ****************************************************** -->
            <!-- HIDDEN FORMS -->
            <?php include 'templates/ticketforms.php'; ?>
          </div> <!-- End of main container of col 10 -->
        </div> <!-- End of wrapper of col l10 -->
      </div>
    <!-- END OF COL l10 -->
    <!-- ************** IMPORT JAVASCRIPT ************* -->

    <?php include 'templates/js_resources.php' ?>


    </body>
</html>
