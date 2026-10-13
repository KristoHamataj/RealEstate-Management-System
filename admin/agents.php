
<?php
session_start();
include '../config/db.php';

$message = "";

if(isset($_POST['add_agent'])){

    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users(name, email, password, role)
            VALUES('$name', '$email', '$password', 'agent')";

    if(mysqli_query($conn, $sql)){
        $message = "Agent added successfully!";
    }else{
        $message = "Error: " . mysqli_error($conn);
    }
}

$agents = mysqli_query($conn, "SELECT * FROM users WHERE role='agent'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Agents Management</title>

<link rel="preconnect" href="https://fonts.googleapis.com">

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<link rel="stylesheet"
href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css"/>

<style>

*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

body{

    font-family:'Poppins',sans-serif;

    background:
    linear-gradient(
        135deg,
        #000000,
        #0f0f0f,
        #171717
    );

    min-height:100vh;

    color:white;

    padding:40px;

    overflow-x:hidden;
}

/* GOLD GLOW */

body::before{
    content:'';
    position:absolute;
    width:450px;
    height:450px;
    background:rgba(255,215,0,0.06);
    border-radius:50%;
    top:-150px;
    right:-150px;
    filter:blur(90px);
}

body::after{
    content:'';
    position:absolute;
    width:350px;
    height:350px;
    background:rgba(255,215,0,0.05);
    border-radius:50%;
    bottom:-120px;
    left:-120px;
    filter:blur(90px);
}

.container{
    max-width:1250px;
    margin:auto;
    position:relative;
    z-index:2;
}

/* HEADER */

.header{
    display:flex;
    justify-content:space-between;
    align-items:center;
    margin-bottom:35px;
}

.header h1{
    font-size:38px;
    font-weight:700;
    color:#FFD700;
    letter-spacing:1px;
}

/* GLASS CARD */

.card,
.table-card{

    background:rgba(18,18,18,0.92);

    border:1px solid rgba(255,215,0,0.12);

    border-radius:28px;

    padding:35px;

    backdrop-filter:blur(14px);

    box-shadow:
    0 10px 40px rgba(0,0,0,0.55),
    0 0 25px rgba(255,215,0,0.06);

    margin-bottom:35px;

    overflow:hidden;

    position:relative;
}

/* GOLD DECOR */

.card::before,
.table-card::before{
    content:'';
    position:absolute;
    width:220px;
    height:220px;
    background:
    linear-gradient(
        135deg,
        rgba(255,215,0,0.18),
        rgba(184,134,11,0.05)
    );

    border-radius:50%;

    top:-110px;
    right:-110px;
}

/* TITLES */

.card h2,
.table-card h2{
    margin-bottom:28px;
    font-size:30px;
    color:#FFD700;
    position:relative;
    z-index:2;
}

/* MESSAGE */

.msg{

    background:rgba(255,215,0,0.08);

    border:1px solid rgba(255,215,0,0.15);

    color:#FFD700;

    padding:15px 18px;

    border-radius:16px;

    margin-bottom:22px;

    font-weight:500;
}

/* FORM */

.form-grid{
    display:grid;
    grid-template-columns:repeat(auto-fit,minmax(260px,1fr));
    gap:22px;
    position:relative;
    z-index:2;
}

.input-group{
    display:flex;
    flex-direction:column;
}

.input-group label{
    margin-bottom:10px;
    font-size:14px;
    font-weight:600;
    color:#d4d4d4;
}

.input-box{
    position:relative;
}

.input-box i{
    position:absolute;
    top:18px;
    left:16px;
    color:#FFD700;
    font-size:15px;
}

input{

    width:100%;

    padding:16px 18px 16px 48px;

    border-radius:16px;

    border:1px solid #2b2b2b;

    background:#111111;

    color:white;

    font-size:15px;

    transition:0.3s ease;
}

input::placeholder{
    color:#777;
}

input:focus{

    outline:none;

    border:1px solid #FFD700;

    box-shadow:
    0 0 15px rgba(255,215,0,0.18);

    background:#151515;
}

/* BUTTON */

button{

    margin-top:28px;

    padding:16px 28px;

    border:none;

    border-radius:16px;

    background:
    linear-gradient(
        135deg,
        #FFD700,
        #D4AF37,
        #B8860B
    );

    color:black;

    font-size:15px;

    font-weight:700;

    cursor:pointer;

    transition:0.35s ease;

    box-shadow:
    0 10px 25px rgba(255,215,0,0.25);
}

button:hover{

    transform:translateY(-4px);

    box-shadow:
    0 15px 35px rgba(255,215,0,0.35);
}

/* TABLE */

table{
    width:100%;
    border-collapse:collapse;
    overflow:hidden;
    border-radius:18px;
}

table thead{

    background:
    linear-gradient(
        135deg,
        #FFD700,
        #B8860B
    );

    color:black;
}

table th{

    padding:18px;

    text-align:left;

    font-weight:700;

    font-size:14px;
}

table td{

    padding:18px;

    border-bottom:1px solid #222;

    background:#121212;

    color:#f5f5f5;
}

table tr:hover td{
    background:#1a1a1a;
}

/* BADGE */

.badge{

    display:inline-block;

    padding:9px 15px;

    border-radius:12px;

    background:rgba(255,215,0,0.1);

    border:1px solid rgba(255,215,0,0.18);

    color:#FFD700;

    font-size:13px;

    font-weight:600;
}

/* ID */

.agent-id{
    color:#FFD700;
    font-weight:600;
}

/* RESPONSIVE */

@media(max-width:768px){

    body{
        padding:20px;
    }

    .header{
        flex-direction:column;
        align-items:flex-start;
        gap:10px;
    }

    .header h1{
        font-size:30px;
    }

    table{
        display:block;
        overflow-x:auto;
    }

    .card,
    .table-card{
        padding:25px;
    }
}

</style>
</head>

<body>

<div class="container">

    <!-- HEADER -->

    <div class="header">
        <h1>
            <i class="fa-solid fa-users me-2"></i>
            Agents Management
        </h1>
    </div>

    <!-- ADD AGENT -->

    <div class="card">

        <h2>Add New Agent</h2>

        <?php if(!empty($message)){ ?>

            <div class="msg">
                <?php echo $message; ?>
            </div>

        <?php } ?>

        <form method="POST">

            <div class="form-grid">

                <!-- NAME -->

                <div class="input-group">

                    <label>Agent Name</label>

                    <div class="input-box">

                        <i class="fa-solid fa-user"></i>

                        <input
                            type="text"
                            name="name"
                            placeholder="Enter full name"
                            required
                        >

                    </div>

                </div>

                <!-- EMAIL -->

                <div class="input-group">

                    <label>Email Address</label>

                    <div class="input-box">

                        <i class="fa-solid fa-envelope"></i>

                        <input
                            type="email"
                            name="email"
                            placeholder="Enter email address"
                            required
                        >

                    </div>

                </div>

                <!-- PASSWORD -->

                <div class="input-group">

                    <label>Password</label>

                    <div class="input-box">

                        <i class="fa-solid fa-lock"></i>

                        <input
                            type="password"
                            name="password"
                            placeholder="Create password"
                            required
                        >

                    </div>

                </div>

            </div>

            <button type="submit" name="add_agent">

                <i class="fa-solid fa-plus me-2"></i>

                Add Agent

            </button>

        </form>

    </div>

    <!-- TABLE -->

    <div class="table-card">

        <h2>All Agents</h2>

        <table>

            <thead>

                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Status</th>
                </tr>

            </thead>

            <tbody>

            <?php while($row = mysqli_fetch_assoc($agents)){ ?>

                <tr>

                    <td class="agent-id">
                        #<?php echo $row['id']; ?>
                    </td>

                    <td>
                        <?php echo $row['name']; ?>
                    </td>

                    <td>
                        <?php echo $row['email']; ?>
                    </td>

                    <td>
                        <span class="badge">
                            Active
                        </span>
                    </td>

                </tr>

            <?php } ?>

            </tbody>

        </table>

    </div>

</div>

</body>
</html>

