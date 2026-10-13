<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$sql = "SELECT properties.*, users.name AS agent_name
        FROM properties
        JOIN users ON properties.agent_id = users.id
        ORDER BY properties.id DESC";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Properties</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *{
            margin:0;
            padding:0;
            box-sizing:border-box;
        }

        body{
            font-family:'Inter',sans-serif;
            background:linear-gradient(135deg,#050505,#111111);
            color:white;
            min-height:100vh;
        }

        .container{
            max-width:1450px;
        }

        /* TOPBAR */

        .topbar{
            display:flex;
            justify-content:space-between;
            align-items:center;
            margin-bottom:50px;
            padding-bottom:20px;
            border-bottom:1px solid rgba(212,175,55,0.12);
        }

        .topbar h1{
            font-size:42px;
            font-weight:800;
            color:#d4af37;
            margin-bottom:5px;
        }

        .subtitle{
            color:#7c7c7c;
            font-size:15px;
        }

        .dashboard-btn{
            background:linear-gradient(135deg,#d4af37,#f4d03f);
            color:black;
            text-decoration:none;
            padding:14px 24px;
            border-radius:14px;
            font-weight:700;
            transition:0.3s ease;
            box-shadow:0 10px 25px rgba(212,175,55,0.18);
        }

        .dashboard-btn:hover{
            transform:translateY(-3px);
            color:black;
        }

        /* PROPERTY CARD */

        .property-card{
            background:linear-gradient(145deg,#121212,#1a1a1a);
            border:1px solid rgba(212,175,55,0.12);
            border-radius:24px;
            overflow:hidden;
            transition:0.35s ease;
            box-shadow:0 18px 35px rgba(0,0,0,0.35);
            height:100%;
        }

        .property-card:hover{
            transform:translateY(-8px);
            border-color:rgba(212,175,55,0.35);
            box-shadow:0 25px 45px rgba(212,175,55,0.08);
        }

        .property-image{
            width:100%;
            height:260px;
            object-fit:cover;
            border-bottom:1px solid rgba(212,175,55,0.08);
        }

        .card-body{
            padding:25px;
        }

        .property-title{
            font-size:22px;
            font-weight:700;
            color:white;
            margin-bottom:8px;
        }

        .property-location{
            color:#9ca3af;
            font-size:14px;
            margin-bottom:12px;
        }

        .property-description{
            color:#7c7c7c;
            font-size:14px;
            line-height:1.6;
            margin-bottom:15px;
        }

        .property-price{
            font-size:28px;
            font-weight:800;
            color:#d4af37;
            margin-bottom:15px;
        }

        .badge{
            padding:9px 14px;
            border-radius:12px;
            font-size:13px;
            font-weight:700;
            margin-bottom:15px;
        }

        .agent-info{
            color:#d1d5db;
            margin-bottom:18px;
        }

        .agent-info strong{
            color:#d4af37;
        }

        .delete-btn{
            width:100%;
            background:#991b1b;
            border:none;
            padding:12px;
            border-radius:12px;
            color:white;
            font-weight:600;
            text-decoration:none;
            display:block;
            text-align:center;
            transition:0.3s ease;
        }

        .delete-btn:hover{
            background:#b91c1c;
            transform:translateY(-2px);
            color:white;
        }

        /* STATUS COLORS */

        .available{
            background:#15803d;
            color:white;
        }

        .sold{
            background:linear-gradient(135deg,#d4af37,#f4d03f);
            color:black;
        }

    </style>
</head>
<body>

<div class="container py-5">

    <div class="topbar">
        <div>
            <h1>Manage Properties</h1>
            <p class="subtitle">Premium real estate admin management panel</p>
        </div>

        <a href="dashboard.php" class="dashboard-btn">
            Dashboard
        </a>
    </div>

    <div class="row">

        <?php while($row = $result->fetch_assoc()) { ?>

        <div class="col-lg-4 col-md-6 mb-4">

            <div class="property-card">

                <img src="../assets/uploads/<?php echo $row['image']; ?>"
                     class="property-image">

                <div class="card-body">

                    <h4 class="property-title">
                        <?php echo $row['title']; ?>
                    </h4>

                    <p class="property-location">
                        📍 <?php echo $row['location']; ?>
                    </p>

                    <p class="property-description">
                        <?php echo substr($row['description'], 0, 120); ?>...
                    </p>

                    <div class="property-price">
                        $<?php echo number_format($row['price']); ?>
                    </div>

                    <span class="badge <?php echo ($row['status'] == 'sold') ? 'sold' : 'available'; ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </span>

                    <p class="agent-info">
                        <strong>Agent:</strong>
                        <?php echo $row['agent_name']; ?>
                    </p>

                    <a href="delete_property.php?id=<?php echo $row['id']; ?>"
                       class="delete-btn"
                       onclick="return confirm('Delete this property?')">
                        Delete Property
                    </a>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

</div>

</body>
</html>
