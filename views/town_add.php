<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php");




if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [    
    'name' => $_POST['name'],
    
    ];

    // Instantiate the Database and Student classes
    $database = new Database();
    $town_city = new TownCity($database);
    $id = $town_city->create($data);
    
    header("Location: town_view.php");



        
    
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">


    <title class="record-title">Add Town/City Data</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h1>Add Town | City Data</h1>
    <form action="" method="post" class="centered-form">
        

        <label for="name">Town | City Name:</label>
        <input type="text" name="name" id="name">

        <input type="submit" value="Add Town City">
    </form>
    </div>
    
    <?php include('../templates/footer.html'); ?>
</body>
</html>
