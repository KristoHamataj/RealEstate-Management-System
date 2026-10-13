<?php
session_start();
include '../config/db.php';

if(isset($_POST['add'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];

    $image = $_FILES['image']['name'];
    $tmp = $_FILES['image']['tmp_name'];

    move_uploaded_file($tmp, '../assets/uploads/'.$image);

    $agent_id = $_SESSION['user_id'];

    $sql = "INSERT INTO properties(agent_id,title,description,price,location,image)
            VALUES('$agent_id','$title','$description','$price','$location','$image')";

    if($conn->query($sql)) {
        header("Location: my_properties.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Add Property</title>

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

.page-wrapper{
    min-height:100vh;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:50px 20px;
}

.form-card{
    width:100%;
    max-width:850px;
    background:#111;
    border:1px solid rgba(255,215,0,0.15);
    border-radius:28px;
    padding:45px;
    box-shadow:
        0 10px 30px rgba(0,0,0,0.7),
        0 0 25px rgba(255,215,0,0.06);
    position:relative;
    overflow:hidden;
}

.form-card::before{
    content:'';
    position:absolute;
    top:-120px;
    right:-120px;
    width:300px;
    height:300px;
    background: radial-gradient(circle, rgba(255,215,0,0.12), transparent 70%);
}

.page-title{
    font-size:38px;
    font-weight:700;
    color:#FFD700;
    margin-bottom:10px;
    position:relative;
    z-index:2;
}

.page-subtitle{
    color:#bdbdbd;
    margin-bottom:35px;
    position:relative;
    z-index:2;
}

.form-label{
    color:#FFD700;
    font-weight:500;
    margin-bottom:8px;
}

.form-control{
    background:#1a1a1a;
    border:1px solid rgba(255,215,0,0.2);
    color:white;
    border-radius:14px;
    padding:14px;
    margin-bottom:22px;
    position:relative;
    z-index:2;
}

.form-control:focus{
    background:#1f1f1f;
    color:white;
    border-color:#FFD700;
    box-shadow:0 0 10px rgba(255,215,0,0.2);
}

textarea.form-control{
    resize:none;
}

input[type="file"]::file-selector-button{
    background:#FFD700;
    color:black;
    border:none;
    padding:10px 18px;
    border-radius:10px;
    cursor:pointer;
    margin-right:15px;
    font-weight:600;
}

.btn-group-custom{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-top:10px;
    position:relative;
    z-index:2;
}

.custom-btn{
    border:none;
    padding:14px 26px;
    border-radius:14px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
}

.add-btn{
    background:#FFD700;
    color:black;
}

.add-btn:hover{
    background:#ffcc00;
    transform:translateY(-2px);
}

.back-btn{
    background:#1f1f1f;
    border:1px solid #FFD700;
    color:#FFD700;
}

.back-btn:hover{
    background:#FFD700;
    color:black;
}

@media(max-width:768px){

    .form-card{
        padding:30px 22px;
    }

    .page-title{
        font-size:30px;
    }
}

</style>

</head>

<body>

<div class="page-wrapper">

    <div class="form-card">

        <h1 class="page-title">
            Add Property
        </h1>

        <p class="page-subtitle">
            Create a new luxury property listing for your clients.
        </p>

        <form method="POST" enctype="multipart/form-data">

            <label class="form-label">
                Property Title
            </label>

            <input 
                type="text" 
                name="title" 
                class="form-control" 
                placeholder="Enter property title"
                required
            >

            <label class="form-label">
                Description
            </label>

            <textarea 
                name="description" 
                class="form-control" 
                rows="5"
                placeholder="Enter property description"
            ></textarea>

            <label class="form-label">
                Price
            </label>

            <input 
                type="number" 
                name="price" 
                class="form-control" 
                placeholder="Enter property price"
                required
            >

            <label class="form-label">
                Location
            </label>

            <input 
                type="text" 
                name="location" 
                class="form-control" 
                placeholder="Enter property location"
                required
            >

            <label class="form-label">
                Property Image
            </label>

            <input 
                type="file" 
                name="image" 
                class="form-control" 
                required
            >

            <div class="btn-group-custom">

                <button name="add" class="custom-btn add-btn">
                    Add Property
                </button>

                <a href="dashboard.php" class="custom-btn back-btn">
                    Back to Dashboard
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>