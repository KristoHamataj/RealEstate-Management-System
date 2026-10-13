<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'agent') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$agent_id = $_SESSION['user_id'];

$sql = "SELECT * FROM properties WHERE agent_id='$agent_id' ORDER BY id DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>My Properties</title>

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
    background: linear-gradient(135deg, #0a0a0a, #141414, #1d1d1d);
    font-family:'Poppins', sans-serif;
    color:white;
    min-height:100vh;
}

.container-custom{
    width:100%;
    max-width:1400px;
    margin:auto;
    padding:50px 20px;
}

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    gap:20px;
    margin-bottom:50px;
}

.page-title{
    font-size:40px;
    font-weight:700;
    color:#FFD700;
}

.dashboard-btn{
    text-decoration:none;
    background:#FFD700;
    color:black;
    padding:12px 24px;
    border-radius:14px;
    font-weight:600;
    transition:0.3s;
}

.dashboard-btn:hover{
    background:#ffcc00;
    transform:translateY(-2px);
    color:black;
}

.property-card{
    background:#111;
    border:1px solid rgba(255,215,0,0.15);
    border-radius:24px;
    overflow:hidden;
    transition:0.3s ease;
    height:100%;
    box-shadow:0 10px 25px rgba(0,0,0,0.5);
}

.property-card:hover{
    transform:translateY(-8px);
    border-color:#FFD700;
    box-shadow:0 0 30px rgba(255,215,0,0.12);
}

.property-img{
    width:100%;
    height:260px;
    object-fit:cover;
}

.card-content{
    padding:25px;
}

.property-title{
    font-size:24px;
    font-weight:600;
    margin-bottom:10px;
    color:white;
}

.property-location{
    color:#bdbdbd;
    margin-bottom:15px;
    font-size:15px;
}

.property-price{
    color:#FFD700;
    font-size:28px;
    font-weight:700;
    margin-bottom:15px;
}

.status-badge{
    display:inline-block;
    padding:8px 16px;
    border-radius:50px;
    font-size:13px;
    font-weight:600;
    margin-bottom:25px;
}

.status-sale{
    background:#1e5128;
    color:#7dff99;
}

.status-sold{
    background:#5c1a1a;
    color:#ff8b8b;
}

.btn-group-custom{
    display:flex;
    gap:10px;
    flex-wrap:wrap;
}

.custom-btn{
    border:none;
    padding:10px 18px;
    border-radius:12px;
    font-size:14px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
}

.edit-btn{
    background:#FFD700;
    color:black;
}

.edit-btn:hover{
    background:#ffcc00;
    color:black;
}

.delete-btn{
    background:#8b0000;
    color:white;
}

.delete-btn:hover{
    background:#c40000;
    color:white;
}

.sold-btn{
    background:#222;
    border:1px solid #FFD700;
    color:#FFD700;
}

.sold-btn:hover{
    background:#FFD700;
    color:black;
}

.empty-box{
    background:#111;
    border:1px solid rgba(255,215,0,0.2);
    border-radius:24px;
    padding:60px 30px;
    text-align:center;
}

.empty-box h2{
    color:#FFD700;
    margin-bottom:15px;
}

.empty-box p{
    color:#aaa;
}

@media(max-width:768px){

    .page-title{
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

<div class="container-custom">

    <div class="topbar">

        <h1 class="page-title">
            My Properties
        </h1>

        <a href="dashboard.php" class="dashboard-btn">
            Back to Dashboard
        </a>

    </div>

    <?php if($result->num_rows > 0) { ?>

    <div class="row g-4">

        <?php while($row = $result->fetch_assoc()) { ?>

        <div class="col-lg-4 col-md-6">

            <div class="property-card">

                <img 
                    src="../assets/uploads/<?php echo $row['image']; ?>" 
                    class="property-img"
                >

                <div class="card-content">

                    <h3 class="property-title">
                        <?php echo $row['title']; ?>
                    </h3>

                    <p class="property-location">
                        📍 <?php echo $row['location']; ?>
                    </p>

                    <div class="property-price">
                        $<?php echo number_format($row['price']); ?>
                    </div>

                    <div class="status-badge <?php echo ($row['status'] == 'sold') ? 'status-sold' : 'status-sale'; ?>">
                        <?php echo ucfirst($row['status']); ?>
                    </div>

                    <div class="btn-group-custom">

                        <a 
                            href="edit_property.php?id=<?php echo $row['id']; ?>" 
                            class="custom-btn edit-btn"
                        >
                            Edit
                        </a>

                        <a 
                            href="delete_property.php?id=<?php echo $row['id']; ?>" 
                            class="custom-btn delete-btn"
                            onclick="return confirm('Delete property?')"
                        >
                            Delete
                        </a>

                        <?php if($row['status'] != 'sold') { ?>

                        <a 
                            href="mark_sold.php?id=<?php echo $row['id']; ?>" 
                            class="custom-btn sold-btn"
                            onclick="return confirm('Mark as sold?')"
                        >
                            Mark Sold
                        </a>

                        <?php } ?>

                    </div>

                </div>

            </div>

        </div>

        <?php } ?>

    </div>

    <?php } else { ?>

    <div class="empty-box">

        <h2>No Properties Found</h2>

        <p>
            You haven’t added any properties yet.
        </p>

    </div>

    <?php } ?>

</div>

</body>
</html>