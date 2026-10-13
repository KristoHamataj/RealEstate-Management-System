<?php
session_start();

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'agent') {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db.php';

$id = $_GET['id'];
$agent_id = $_SESSION['user_id'];

$sql = "SELECT * FROM properties
        WHERE id='$id' AND agent_id='$agent_id'";

$result = $conn->query($sql);

if($result->num_rows == 0) {
    die("Property not found");
}

$property = $result->fetch_assoc();

if(isset($_POST['update'])) {

    $title = $_POST['title'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $location = $_POST['location'];
    $status = $_POST['status'];

    if(!empty($_FILES['image']['name'])) {

        $image = $_FILES['image']['name'];
        $tmp = $_FILES['image']['tmp_name'];

        move_uploaded_file($tmp, '../assets/uploads/' . $image);

        $update = "UPDATE properties SET
                    title='$title',
                    description='$description',
                    price='$price',
                    location='$location',
                    status='$status',
                    image='$image'
                    WHERE id='$id'";

    } else {

        $update = "UPDATE properties SET
                    title='$title',
                    description='$description',
                    price='$price',
                    location='$location',
                    status='$status'
                    WHERE id='$id'";
    }

    if($conn->query($update)) {
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

<title>Edit Property</title>

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
}

.page-title{
    font-size:38px;
    font-weight:700;
    color:#FFD700;
    margin-bottom:35px;
}

.form-label{
    color:#FFD700;
    font-weight:500;
    margin-bottom:8px;
}

.form-control,
.form-select{
    background:#1a1a1a;
    border:1px solid rgba(255,215,0,0.2);
    color:white;
    border-radius:14px;
    padding:14px;
    margin-bottom:22px;
}

.form-control:focus,
.form-select:focus{
    background:#1f1f1f;
    color:white;
    border-color:#FFD700;
    box-shadow:0 0 10px rgba(255,215,0,0.2);
}

textarea.form-control{
    resize:none;
}

.preview-image{
    width:100%;
    max-height:320px;
    object-fit:cover;
    border-radius:18px;
    border:2px solid rgba(255,215,0,0.2);
    margin-bottom:25px;
}

.btn-group-custom{
    display:flex;
    gap:15px;
    flex-wrap:wrap;
    margin-top:10px;
}

.custom-btn{
    border:none;
    padding:14px 24px;
    border-radius:14px;
    font-weight:600;
    text-decoration:none;
    transition:0.3s;
}

.update-btn{
    background:#FFD700;
    color:black;
}

.update-btn:hover{
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
            Edit Property
        </h1>

        <form method="POST" enctype="multipart/form-data">

            <label class="form-label">
                Property Title
            </label>

            <input 
                type="text"
                name="title"
                class="form-control"
                value="<?php echo $property['title']; ?>"
                required
            >

            <label class="form-label">
                Description
            </label>

            <textarea 
                name="description"
                class="form-control"
                rows="5"
            ><?php echo $property['description']; ?></textarea>

            <label class="form-label">
                Price
            </label>

            <input 
                type="number"
                name="price"
                class="form-control"
                value="<?php echo $property['price']; ?>"
                required
            >

            <label class="form-label">
                Location
            </label>

            <input 
                type="text"
                name="location"
                class="form-control"
                value="<?php echo $property['location']; ?>"
                required
            >

            <label class="form-label">
                Status
            </label>

            <select name="status" class="form-select">

                <option value="available"
                    <?php if($property['status']=='available') echo 'selected'; ?>>
                    Available
                </option>

                <option value="sold"
                    <?php if($property['status']=='sold') echo 'selected'; ?>>
                    Sold
                </option>

                <option value="rented"
                    <?php if($property['status']=='rented') echo 'selected'; ?>>
                    Rented
                </option>

            </select>

            <label class="form-label">
                Current Image
            </label>

            <img 
                src="../assets/uploads/<?php echo $property['image']; ?>"
                class="preview-image"
            >

            <label class="form-label">
                Upload New Image
            </label>

            <input 
                type="file" 
                name="image" 
                class="form-control"
            >

            <div class="btn-group-custom">

                <button name="update" class="custom-btn update-btn">
                    Update Property
                </button>

                <a href="my_properties.php" class="custom-btn back-btn">
                    Back
                </a>

            </div>

        </form>

    </div>

</div>

</body>
</html>