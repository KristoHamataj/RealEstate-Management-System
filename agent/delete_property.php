<?php
session_start();
include '../config/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'agent') {
    header("Location: ../auth/login.php");
    exit();
}

if (!isset($_GET['id'])) {
    header("Location: my_properties.php");
    exit();
}

$id = $_GET['id'];
$agent_id = $_SESSION['user_id'];

/* Ensure property belongs to logged-in agent */
$sql = "SELECT * FROM properties WHERE id='$id' AND agent_id='$agent_id'";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    die("Unauthorized or property not found");
}

/* Delete image from folder (optional but recommended) */
$property = $result->fetch_assoc();
$imagePath = "../assets/uploads/" . $property['image'];

if (file_exists($imagePath)) {
    unlink($imagePath);
}

/* Delete from database */
$delete = "DELETE FROM properties WHERE id='$id' AND agent_id='$agent_id'";

if ($conn->query($delete)) {
    header("Location: my_properties.php");
    exit();
} else {
    echo "Error deleting property";
}
?>