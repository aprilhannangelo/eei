<?php
// include "../templates/dbconfig.php";
session_start();
$db = mysqli_connect("localhost", "root", "", "eei_db");

$a = mysqli_real_escape_string($db, $_POST['assignee']);
$id = mysqli_real_escape_string($db, $_POST['id']);


$query = "UPDATE ticket_t SET ticket_agent_id = '$a' WHERE ticket_id = $id";
if (!mysqli_query($db, $query))
{
  die('Error' . mysqli_error($db));
}

//for swal ticket number display
$query2 = "SELECT CONCAT(r.first_name, ' ', r.last_name) AS assignee FROM requestor_t r LEFT JOIN ticket_t t on r.requestor_id=t.ticket_agent_id WHERE ticket_id = $id";

$result = mysqli_query($db, $query2);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);

echo json_encode($row['assignee']);





mysqli_close($db);
?>
