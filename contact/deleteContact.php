<?php
include "..\db_conn.php";

$id = $_GET['id'];
$sql = "DELETE FROM `contact` WHERE id=$id";
$result = mysqli_query($conn, $sql);

if ($result) {
    header("Location: index.php?msg=Contact Deleted");
}
