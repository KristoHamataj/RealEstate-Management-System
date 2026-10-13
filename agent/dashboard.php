<?php
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'agent') {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Agent Dashboard</title>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Poppins', sans-serif;
    background: linear-gradient(135deg, #0a0a0a, #141414, #1b1b1b);
    min-height:100vh;
    color:white;
    overflow-x:hidden;
}

.dashboard-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:40px 20px;
}

.dashboard-card{
    width:100%;
    max-width:1100px;
    background: rgba(20,20,20,0.95);
    border:1px solid rgba(255,215,0,0.2);
    border-radius:28px;
    padding:50px;
    box-shadow:
        0 0 30px rgba(255,215,0,0.08),
        0 10px 40px rgba(0,0,0,0.7);
    position:relative;
    overflow:hidden;
}

.dashboard-card::before{
    content:'';
    position:absolute;
    top:-100px;
    right:-100px;
    width:300px;
    height:300px;
    background: radial-gradient(circle, rgba(255,215,0,0.15), transparent 70%);
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:50px;
}

.brand{
    font-size:32px;
    font-weight:700;
    color:#FFD700;
    letter-spacing:1px;
}

.welcome-text h1{
    font-size:42px;
    font-weight:700;
    margin-bottom:10px;
}

.welcome-text span{
    color:#FFD700;
}

.welcome-text p{
    color:#bdbdbd;
    font-size:16px;
}

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit, minmax(250px,1fr));
    gap:25px;
    margin-top:40px;
}

.dashboard-box{
    background:#111;
    border:1px solid rgba(255,215,0,0.15);
    border-radius:22px;
    padding:30px;
    transition:0.3s ease;
    position:relative;
    overflow:hidden;
}

.dashboard-box:hover{
    transform:translateY(-8px);
    border-color:#FFD700;
    box-shadow:0 0 25px rgba(255,215,0,0.12);
}

.dashboard-box h3{
    color:#FFD700;
    margin-bottom:15px;
    font-size:22px;
    font-weight:600;
}

.dashboard-box p{
    color:#cfcfcf;
    margin-bottom:25px;
    font-size:15px;
}

.custom-btn{
    border:none;
    border-radius:14px;
    padding:12px 22px;
    font-weight:600;
    text-decoration:none;
    display:inline-block;
    transition:0.3s;
}

.btn-gold{
    background:#FFD700;
    color:black;
}

.btn-gold:hover{
    background:#ffcc00;
    transform:scale(1.03);
}

.btn-darkgold{
    background:#1f1f1f;
    color:#FFD700;
    border:1px solid #FFD700;
}

.btn-darkgold:hover{
    background:#FFD700;
    color:black;
}

.logout-btn{
    background:#8b0000;
    color:white;
}

.logout-btn:hover{
    background:#c40000;
    color:white;
}

.footer-text{
    margin-top:50px;
    text-align:center;
    color:#777;
    font-size:14px;
}

@media(max-width:768px){

    .dashboard-card{
        padding:30px 20px;
    }

    .welcome-text h1{
        font-size:30px;
    }

    .topbar{
        flex-direction:column;
        align-items:flex-start;
    }
}

</style>
</head>

<body>

<div class="dashboard-wrapper">

    <div class="dashboard-card">

        <div class="topbar">
    <div class="brand">PHOENIX REAL ESTATE</div>

    <div style="z-index:999;">
        <a href="../auth/logout.php" class="custom-btn logout-btn">
            Logout
        </a>
    </div>
</div>

        <div class="welcome-text">
            <h1>
                Welcome back,
                <span><?php echo $_SESSION['name']; ?></span>
            </h1>

            <p>
                Manage your properties, listings, and real estate activity from your premium dashboard.
            </p>
        </div>

        <div class="cards">

            <div class="dashboard-box">
                <h3>Add Property</h3>

                <p>
                    Create and publish new luxury property listings quickly and easily.
                </p>

                <a href="add_property.php" class="custom-btn btn-gold">
                    Add Now
                </a>
            </div>

            <div class="dashboard-box">
                <h3>My Properties</h3>

                <p>
                    View, edit, and manage all the properties you have listed.
                </p>

                <a href="my_properties.php" class="custom-btn btn-darkgold">
                    View Properties
                </a>
            </div>

        </div>

        <div class="footer-text">
            © 2026 Phoenix Real Estate — Premium Agent Panel
        </div>

    </div>

</div>

</body>
</html>