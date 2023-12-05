<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['name'],
    
    ];

    // Instantiate the Database and Student classes
    $database = new Database();
    $province = new Province($database);
    $id = $province->create($data);
    
    header("Location: province_view.php");



        
    
}
?>


<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title>Add Province Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1 class="record-title">Add Province Data</h1>
    <form action="" method="post" class="centered-form">
        

        <label for="name">Province Name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="Add Province">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
