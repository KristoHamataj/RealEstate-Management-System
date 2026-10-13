<?php
include '../config/db.php';

if(isset($_POST['register'])) {

    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name,email,password,role)
            VALUES('$name','$email','$password','agent')";

    if($conn->query($sql)) {
        echo "Agent created";
    }
}
?>

<form method="POST">
<input type="text" name="name" placeholder="Name" required>
<input type="email" name="email" placeholder="Email" required>
<input type="password" name="password" placeholder="Password" required>
<button name="register">Create Agent</button>
</form>