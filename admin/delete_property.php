<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

if(isset($_GET['id'])) {

    $id = $_GET['id'];

    $getImage = $conn->query("SELECT image FROM properties WHERE id='$id'");

    if($getImage->num_rows > 0) {

        $img = $getImage->fetch_assoc();

        if(file_exists('../assets/uploads/' . $img['image'])) {
            unlink('../assets/uploads/' . $img['image']);
        }
    }

    $conn->query("DELETE FROM properties WHERE id='$id'");
}

header("Location: properties.php");
exit();
?>