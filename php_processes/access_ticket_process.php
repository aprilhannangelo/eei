<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$request_title = mysqli_real_escape_string($db, $_POST['title']);
$company = mysqli_real_escape_string($db, $_POST['company']);
$dp = mysqli_real_escape_string($db, $_POST['dp']);
$rc = mysqli_real_escape_string($db, $_POST['rc_no']);
$names = mysqli_real_escape_string($db, $_POST['names']);
$access_request = mysqli_real_escape_string($db, $_POST['access_request']);
// $expiry_date = mysqli_real_escape_string($db, $_POST['expiry_date']);
$approver = mysqli_real_escape_string($db, $_POST['approver']);
$checker = mysqli_real_escape_string($db, $_POST['checker']);


$query1 = "INSERT INTO ticket_t (ticket_id, ticket_title, ticket_type, date_prepared, ticket_status, user_id) VALUES(DEFAULT, '$request_title', 'User Access', CURDATE(), '1', '{$_SESSION['user_id']}')";

if (!mysqli_query($db, $query1))
{
  die('Error' . mysqli_error($db));
}

$latest_id = mysqli_insert_id($db);


$query2 = "UPDATE ticket_t SET ticket_number= CONCAT(EXTRACT(YEAR FROM date_prepared), ticket_id)  WHERE ticket_id = '$latest_id'";
if (!mysqli_query($db, $query2))
{
  die('Error' . mysqli_error($db));
}

$query5= "SELECT user_id from user_t WHERE CONCAT(first_name,' ',last_name)='$approver'";
$result2=mysqli_query($db, $query5);
$row2 = mysqli_fetch_array($result2,MYSQLI_ASSOC);
$approverID= $row2['user_id'];

$query6= "SELECT user_id from user_t WHERE CONCAT(first_name,' ',last_name)='$checker'";
$result3=mysqli_query($db, $query6);
$row3= mysqli_fetch_array($result3,MYSQLI_ASSOC);
$checkerID= $row3['user_id'];

$query3 = "INSERT INTO user_access_ticket_t (ticket_id, company, dept_proj, rc_no, name, access_requested,  approver, checker) VALUES('$latest_id', '$company', '$dp', '$rc', '$names', '$access_request', '$approverID', '$checkerID')";

if (!mysqli_query($db, $query3))
{
  die('Error' . mysqli_error($db));
}

// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }

$query4 = "SELECT ticket_number from ticket_t where ticket_id = '$latest_id'";

$result = mysqli_query($db, $query4);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

echo json_encode($row['ticket_number']);

mysqli_close($db);
?>
