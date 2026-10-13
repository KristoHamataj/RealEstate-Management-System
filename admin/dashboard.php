<?php
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

if (!$conn) {
    die("Database connection failed.");
}

$properties = 0;
$agents = 0;

// Count properties
$result1 = mysqli_query($conn, "SELECT * FROM properties");

if ($result1) {
    $properties = mysqli_num_rows($result1);
} else {
    die("Properties query failed: " . mysqli_error($conn));
}

// Count agents
$result2 = mysqli_query($conn, "SELECT * FROM users WHERE role='agent'");

if ($result2) {
    $agents = mysqli_num_rows($result2);
} else {
    die("Agents query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Phoenix Real Estate Dashboard</title>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{
    font-family:'Inter',sans-serif;
    background:#0b0b0b;
    color:#ffffff;
    min-height:100vh;
    display:flex;
}

/* SIDEBAR */

.sidebar{
    width:280px;
    height:100vh;
    position:fixed;
    left:0;
    top:0;
    background:linear-gradient(180deg,#111111,#050505);
    border-right:1px solid rgba(212,175,55,0.15);
    padding:30px 20px;
    display:flex;
    flex-direction:column;
    justify-content:space-between;
    box-shadow:8px 0 25px rgba(0,0,0,0.4);
}

.logo h2{
    font-size:30px;
    font-weight:700;
    color:#d4af37;
    letter-spacing:1px;
    margin-bottom:40px;
}

.menu a{
    display:flex;
    align-items:center;
    text-decoration:none;
    color:#a1a1aa;
    padding:16px 18px;
    margin-bottom:12px;
    border-radius:16px;
    transition:all .3s ease;
    font-weight:500;
    border:1px solid transparent;
}

.menu a:hover{
    background:rgba(212,175,55,0.08);
    color:#d4af37;
    border:1px solid rgba(212,175,55,0.2);
    transform:translateX(6px);
}

.menu a.active{
    background:linear-gradient(135deg,#d4af37,#f4d03f);
    color:#000;
    font-weight:600;
    box-shadow:0 10px 30px rgba(212,175,55,0.25);
}

/* MAIN */

.main{
    margin-left:280px;
    width:100%;
    padding:40px;
    background:radial-gradient(circle at top right,#1a1a1a,#0b0b0b 60%);
}

/* TOPBAR */

.topbar{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:40px;
}

.topbar h1{
    font-size:36px;
    font-weight:700;
    color:#ffffff;
}

.profile{
    display:flex;
    align-items:center;
    gap:14px;
    background:#111111;
    border:1px solid rgba(212,175,55,0.15);
    padding:12px 18px;
    border-radius:18px;
    box-shadow:0 8px 25px rgba(0,0,0,0.35);
}

.profile img{
    width:48px;
    height:48px;
    border-radius:50%;
    border:2px solid #d4af37;
}

/* CARDS */

.cards{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:25px;
}

.card{
    background:linear-gradient(145deg,#111111,#1a1a1a);
    border:1px solid rgba(212,175,55,0.12);
    border-radius:24px;
    padding:28px;
    box-shadow:0 15px 35px rgba(0,0,0,0.35);
    transition:all .35s ease;
    position:relative;
    overflow:hidden;
}

.card:hover{
    transform:translateY(-8px);
    border-color:rgba(212,175,55,0.35);
    box-shadow:0 20px 40px rgba(212,175,55,0.08);
}

.card::before{
    content:'';
    position:absolute;
    top:-60px;
    right:-60px;
    width:140px;
    height:140px;
    border-radius:50%;
    background:rgba(212,175,55,0.08);
}

.card h3{
    color:#888;
    font-size:17px;
    margin-bottom:18px;
}

.number{
    font-size:50px;
    font-weight:700;
    color:#d4af37;
}

/* EXTRA STATS */

.stats{
    margin-top:35px;
    display:grid;
    grid-template-columns:2fr 1fr;
    gap:25px;
}

.chart-card,
.activity-card{
    background:#111111;
    border:1px solid rgba(212,175,55,0.12);
    border-radius:24px;
    padding:25px;
    box-shadow:0 10px 30px rgba(0,0,0,0.3);
}

.chart-card h2,
.activity-card h2{
    color:#d4af37;
    margin-bottom:15px;
}

.chart-placeholder{
    height:300px;
    border-radius:18px;
    background:linear-gradient(135deg,#1a1a1a,#101010);
    border:1px dashed rgba(212,175,55,0.2);
    display:flex;
    align-items:center;
    justify-content:center;
    color:#d4af37;
    font-weight:600;
}

/* ACTIVITY */

.activity-item{
    padding:16px 0;
    border-bottom:1px solid rgba(255,255,255,0.06);
}

.activity-item:last-child{
    border-bottom:none;
}

.activity-item strong{
    color:#fff;
}

.activity-item p{
    color:#888;
    font-size:14px;
}

/* RESPONSIVE */

@media(max-width:900px){

    .sidebar{
        width:90px;
        padding:20px 10px;
    }

    .logo h2{
        font-size:18px;
        text-align:center;
    }

    .menu a span{
        display:none;
    }

    .main{
        margin-left:90px;
        padding:25px;
    }

    .stats{
        grid-template-columns:1fr;
    }
}
</style>
</head>

<body>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// LIVE CHART
const ctx = document.getElementById('salesChart').getContext('2d');

let labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'];
let dataValues = [12, 19, 14, 25, 22, 30];

const salesChart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: labels,
        datasets: [{
            label: 'Property Sales',
            data: dataValues,
            borderColor: '#d4af37',
            backgroundColor: 'rgba(212,175,55,0.1)',
            tension: 0.4,
            fill: true,
            borderWidth: 3,
            pointBackgroundColor: '#d4af37'
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                labels: {
                    color: 'white'
                }
            }
        },
        scales: {
            x: {
                ticks: { color: 'white' },
                grid: { color: 'rgba(255,255,255,0.05)' }
            },
            y: {
                ticks: { color: 'white' },
                grid: { color: 'rgba(255,255,255,0.05)' }
            }
        }
    }
});

// UPDATE CHART EVERY 3 SECONDS
setInterval(() => {
    dataValues.shift();
    dataValues.push(Math.floor(Math.random() * 40) + 10);
    salesChart.update();
}, 3000);


// REAL-TIME ACTIVITY FEED
const activities = [
    "New Property Added",
    "Agent Updated Profile",
    "Property Sold",
    "New User Registered",
    "Property Deleted",
    "New Inquiry Received"
];

function addActivity() {
    const feed = document.getElementById("activityFeed");

    const item = document.createElement("div");
    item.className = "activity-item";

    const randomActivity = activities[Math.floor(Math.random() * activities.length)];

    item.innerHTML = `
        <strong>${randomActivity}</strong>
        <p>Just now</p>
    `;

    feed.prepend(item);

    if (feed.children.length > 6) {
        feed.removeChild(feed.lastChild);
    }
}

// ADD NEW ACTIVITY EVERY 5 SECONDS
setInterval(addActivity, 5000);
</script>
<!-- SIDEBAR -->
<div class="sidebar">

    <div>

        <div class="logo">
            <h2>Phoenix Real Estate</h2>
        </div>

        <div class="menu">

            <a href="dashboard.php" class="active">
                <span>Dashboard</span>
            </a>

            <a href="properties.php">
                <span>Properties</span>
            </a>

            <a href="agents.php">
                <span>Agents</span>
            </a>

            <a href="delete_property.php">
                <span>Delete Property</span>
            </a>

            <a href="../auth/logout.php">
                <span>Logout</span>
            </a>

        </div>

    </div>

</div>

<!-- MAIN -->
<div class="main">

    <!-- TOPBAR -->
    <div class="topbar">

        <h1>Admin Dashboard</h1>

        <div class="profile">
            <img src="https://i.pravatar.cc/100" alt="">
            <div>
                <strong>Admin</strong><br>
                <small>Administrator</small>
            </div>
        </div>

    </div>

    <!-- CARDS -->
    <div class="cards">

        <div class="card">
            <h3>Total Properties</h3>
            <div class="number">
                <?php echo $properties; ?>
            </div>
        </div>

        <div class="card">
            <h3>Total Agents</h3>
            <div class="number">
                <?php echo $agents; ?>
            </div>
        </div>

       <?php
$sales = 0;

$result3 = mysqli_query($conn, "SELECT * FROM properties WHERE status='sold'");

if($result3){
    $sales = mysqli_num_rows($result3);
}
?>

<div class="card">
    <h3>Total Sales</h3>
    <div class="number">
        <?php echo $sales; ?>
    </div>
</div>

    </div>

    <!-- EXTRA SECTION -->
    <div class="stats">

        <div class="chart-card">

            <h2>Analytics</h2>

            <canvas id="salesChart" height="120"></canvas>

        </div>

       <div class="activity-card">
    <h2>Recent Activity</h2>

    <div id="activityFeed">

        <div class="activity-item">
            <strong>System Started</strong>
            <p>Just now</p>
        </div>

    </div>
</div>

        </div>

    </div>

</div>

</body>
</html>