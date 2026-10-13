<?php
session_start();
include '../config/db.php';

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'agent'){
    header("Location: ../auth/login.php");
    exit();
}

$id = $_GET['id'];
$agent_id = $_SESSION['user_id'];

$sql = "UPDATE properties 
        SET status='sold' 
        WHERE id='$id' AND agent_id='$agent_id'";

$conn->query($sql);

header("Location: my_properties.php");
exit();
?>