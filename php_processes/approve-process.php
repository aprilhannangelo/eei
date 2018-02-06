<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


$ticketID = mysqli_real_escape_string($db, $_POST['ticketID']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);


$query = "UPDATE user_access_ticket_t SET isApproved = true WHERE ticket_id = $ticketID";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

// $errorMsg = mysqli_error($db);

$query2 = "UPDATE ticket_t SET ticket_status = '3' WHERE ticket_id  = $ticketID";

if (!mysqli_query($db, $query2))
{
  die('Error' . mysqli_error($db));
}

// $errorMsg = mysqli_error($db);

// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }


mysqli_close($db);
?>
