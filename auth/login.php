<?php
session_start();
include '../config/db.php';

if(isset($_POST['login'])) {

    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    $sql = "SELECT * FROM users WHERE email='$email'";
    $result = $conn->query($sql);

    if($result->num_rows > 0) {

        $user = $result->fetch_assoc();

        if(password_verify($password, $user['password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['name'] = $user['name'];

            if($user['role'] == 'admin') {
                header("Location: ../admin/dashboard.php");
            } else {
                header("Location: ../agent/dashboard.php");
            }

            exit();

        } else {
            $error = "Invalid password";
        }

    } else {
        $error = "User not found";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Phoenix Real Estate</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    height:100vh;
    background:
    linear-gradient(
        135deg,
        #000000,
        #0f0f0f,
        #1a1a1a
    );

    display:flex;
    justify-content:center;
    align-items:center;
    font-family:'Segoe UI', sans-serif;
    overflow:hidden;
}

/* GOLD GLOW BACKGROUND */
body::before{
    content:'';
    position:absolute;
    width:500px;
    height:500px;
    background:rgba(255, 215, 0, 0.08);
    border-radius:50%;
    top:-150px;
    right:-150px;
    filter:blur(100px);
}

body::after{
    content:'';
    position:absolute;
    width:400px;
    height:400px;
    background:rgba(255, 215, 0, 0.05);
    border-radius:50%;
    bottom:-120px;
    left:-120px;
    filter:blur(90px);
}

.login-container{
    width:100%;
    max-width:430px;
    padding:20px;
    position:relative;
    z-index:2;
}

.login-card{

    background:rgba(15,15,15,0.92);

    border:1px solid rgba(255,215,0,0.15);

    border-radius:28px;

    padding:42px;

    box-shadow:
    0 10px 40px rgba(0,0,0,0.6),
    0 0 25px rgba(255,215,0,0.08);

    color:white;

    backdrop-filter:blur(12px);

    animation:fadeIn 0.8s ease;
}

/* LOGO */

.logo-circle{

    width:90px;
    height:90px;

    background:
    linear-gradient(
        135deg,
        #FFD700,
        #D4AF37,
        #B8860B
    );

    border-radius:50%;

    display:flex;
    justify-content:center;
    align-items:center;

    margin:0 auto 22px;

    font-size:36px;

    color:black;

    box-shadow:
    0 5px 25px rgba(255,215,0,0.35);
}

/* TITLES */

.login-title{
    text-align:center;
    font-size:32px;
    font-weight:700;
    margin-bottom:8px;
    color:#FFD700;
}

.login-subtitle{
    text-align:center;
    color:#c9c9c9;
    margin-bottom:35px;
    font-size:14px;
    letter-spacing:1px;
}

/* INPUTS */

.input-group{
    position:relative;
    margin-bottom:22px;
}

.input-group i{
    position:absolute;
    top:18px;
    left:16px;
    color:#FFD700;
    z-index:10;
    font-size:15px;
}

.form-control{

    height:56px;

    border-radius:15px;

    background:#111111;

    border:1px solid #2d2d2d;

    color:white;

    padding-left:48px;

    transition:0.3s;
}

.form-control::placeholder{
    color:#888;
}

.form-control:focus{

    background:#151515;

    color:white;

    border:1px solid #FFD700;

    box-shadow:
    0 0 12px rgba(255,215,0,0.25);

    outline:none;
}

/* BUTTON */

.btn-login{

    height:56px;

    border:none;

    border-radius:15px;

    background:
    linear-gradient(
        135deg,
        #FFD700,
        #D4AF37,
        #B8860B
    );

    color:black;

    font-size:16px;

    font-weight:700;

    transition:0.35s ease;
}

.btn-login:hover{

    transform:translateY(-3px);

    box-shadow:
    0 10px 30px rgba(255,215,0,0.35);

    color:black;
}

/* ALERT */

.alert{
    border-radius:14px;
    border:none;
    font-size:14px;
}

/* FOOTER */

.footer-text{
    text-align:center;
    margin-top:22px;
    color:#999;
    font-size:13px;
}

/* ANIMATION */

@keyframes fadeIn{

    from{
        opacity:0;
        transform:translateY(20px);
    }

    to{
        opacity:1;
        transform:translateY(0);
    }
}

</style>


</head>

<body>

<div class="login-container">

    <div class="login-card">

        <div class="logo-circle">
            <i class="fa-solid fa-building"></i>
        </div>

        <h2 class="login-title">Phoenix Real Estate</h2>

        <p class="login-subtitle">
            Property Management System
        </p>

        <?php if(isset($error)) { ?>

            <div class="alert alert-danger">
                <?php echo $error; ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="input-group">
                <i class="fa-solid fa-envelope"></i>

                <input
                    type="email"
                    name="email"
                    class="form-control"
                    placeholder="Enter your email"
                    required
                >
            </div>

            <div class="input-group">
                <i class="fa-solid fa-lock"></i>

                <input
                    type="password"
                    name="password"
                    class="form-control"
                    placeholder="Enter your password"
                    required
                >
            </div>

            <button
                type="submit"
                name="login"
                class="btn btn-primary btn-login w-100"
            >
                <i class="fa-solid fa-right-to-bracket me-2"></i>
                Login
            </button>

        </form>

        <div class="footer-text">
            © <?php echo date('Y'); ?> Phoenix Real Estate
        </div>

    </div>

</div>

</body>
</html>