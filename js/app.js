$(document).ready(function(){
  //hide forms on load
  $(".accesst").hide();
  $(".servicet").hide();

  //live searching for user access request form
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

  //initialize select dropdown for materialize [DO NOT REMOVE]
  $('select').material_select();

  // Clickable table row
  jQuery(document).ready(function($) {
  $(".clickable-row").click(function() {
      window.location = $(this).data("href");
  });


  //if service request from 'New Ticket' dropdown menu is clicked..
  $('.service').click(function(){
    $(".main-body").hide();
    $(".servicet").show();
    $(".accesst").hide();
    $(".requestort").hide();
  });

  //if access request from 'New Ticket' dropdown menu is clicked..
  $('.access').click(function(){
    $(".main-body").hide();
    $(".accesst").show();
    $(".servicet").hide();
    $(".requestort").hide();
  });

  $('.requestor').click(function(){
    $(".main-body").hide();
    $(".servicet").hide();
    $(".accesst").hide();
    $(".requestort").show();
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


  //initialize datepicker of materializecss
  $('.datepicker').pickadate({
     selectMonths: false, // Creates a dropdown to control month
     selectYears: false, // Creates a dropdown of 15 years to control year,
     // today: 'Today',
     today: 'Today',
     clear: 'Clear',
     close: 'Ok',
     closeOnSelect: false // Close upon selecting a date,
   });

 //set current date to field
  var now = new Date();
  var day = ("0" + now.getDate()).slice(-2);
  var month = ("0" + (now.getMonth() + 1)).slice(-2);
  var today = now.getFullYear()+"-"+(month)+"-"+(day) ;
  $('#date_prepared').val(today);
  $('#date_prepared2').val(today);



  // Sweet Alert
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


 $("#properties").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/updateType-Severity.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
         // assignee= JSON.parse(data);
          swal("Ticket Reviewed", " ", "success");
          $(".main-body").show();

      }
   })
   // history.back(); -- removed cos hindi lumalabas yung alert because of this.
 });

 $("#check").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/check-process.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
          swal("Ticket Checked", " ", "success");
      }
   })
   // history.back();
 });

 $("#approve").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/approve-process.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function()
      {
          swal("Ticket Approved", " ", "success");
      }
   })
   // history.back();
 });

 $("#assignee").submit(function(e) {
   e.preventDefault();
   $.ajax({
     url: 'php_processes/assign-ticket.php',
     type: 'POST',
     data: $(this).serialize(),
     success: function(data)
      {
        assignee= JSON.parse(data);
        swal({
           title: "Ticket Agent Assigned!",
           text: "Ticket agent is now " +assignee,
           type: "success",
           icon: "success"
       }).then(function(){
         window.location="incomingRequests.php";
       });
      }
     })
 });

 $('.edit-button').click(function () {
   for (i = 0; i < 5; i++) {
     document.getElementsByClassName('pflBody')[i].contentEditable = true;
   }
   });

  $(".cancel").click(function(){
   window.history.back();
   return false;
 });
});
});
