<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$category = mysqli_real_escape_string($db, $_POST['category']);
$id = mysqli_real_escape_string($db, $_POST['id']);
$severity= mysqli_real_escape_string($db,$_POST['severity']);
//get id of latest row inserted

//UPDATE TICKET_NUMBER since form should be submitted first para may id na icoconcat
$query = "UPDATE ticket_t SET ticket_category='$category', severity_level='$severity' WHERE ticket_id = $id";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}


$result = mysqli_query($db, $query);
//else{
//   // header("Location: ..\home.php");
// }

// if(mysqli_query($db, $query1)){
//   echo "Record added successfully.";
//   header("Location: ..\home.php");
// } else{
//   echo "ERROR: could not execute $query." . mysqli_error($db);
//
// }
if ($category=='Technicals') {
    $query3 = "SELECT requestor_id from requestor_t where user_type = 'Technicals Group Manager'";
    $result = mysqli_query($db, $query3);
    $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
    $mgrId= $row['requestor_id'];
  $query2 = "UPDATE ticket_t SET it_group_manager_id= '$mgrId' WHERE ticket_id = $id";
    $row2=mysqli_query($db, $query2);
}
elseif ($category=='Access') {
  $query3 = "SELECT requestor_id from requestor_t where user_type = 'Access Group Manager'";
  $result = mysqli_query($db, $query3);
  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  $mgrId= $row['requestor_id'];
$query2 = "UPDATE ticket_t SET it_group_manager_id= '$mgrId' WHERE ticket_id = $id";
  $row2=mysqli_query($db, $query2);
}
elseif ($category=='Network') {
  $query3 = "SELECT requestor_id from requestor_t where user_type = 'Network Group Manager'";
  $result = mysqli_query($db, $query3);
  $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
  $mgrId= $row['requestor_id'];
  $query2 = "UPDATE ticket_t SET it_group_manager_id= '$mgrId' WHERE ticket_id = $id";
  $row2=mysqli_query($db, $query2);
}

mysqli_close($db);
?>
