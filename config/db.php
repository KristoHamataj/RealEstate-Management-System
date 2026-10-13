<?php
$conn = new mysqli("localhost", "root", "", "phoenix_real_estate");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>