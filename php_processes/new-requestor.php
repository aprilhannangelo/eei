<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");


$userid = mysqli_real_escape_string($db, $_POST['userid']);
$fname = mysqli_real_escape_string($db, $_POST['fname']);
$lname = mysqli_real_escape_string($db, $_POST['lname']);
$password = mysqli_real_escape_string($db, $_POST['password']);
$email = mysqli_real_escape_string($db, $_POST['email']);
$type = mysqli_real_escape_string($db, $_POST['type']);
// $request_details = mysqli_real_escape_string($db, $_POST['request_details']);
$latest_id = mysqli_insert_id($db);

$query = "INSERT INTO requestor_t (requestor_id,userid,first_name,last_name,password,email_address,user_type) VALUES (DEFAULT,'$userid','$fname','$lname',MD5('$password'),'$email','$type')";

if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

$errorMsg = mysqli_error($db);
$latest_id = mysqli_insert_id($db);
// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }
$query4 = "SELECT CONCAT(first_name, ' ', last_name) as requestor_name from requestor_t where requestor_id = '$latest_id'";

$result = mysqli_query($db, $query4);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

echo json_encode($row['requestor_name']);

mysqli_close($db);
?>
