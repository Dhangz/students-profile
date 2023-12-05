<?php
include_once("../db.php"); // Include the Database class file
include_once("../town_city.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student data by ID from the database
    $db = new Database();
    $town_city = new TownCity($db);
    $town_cityData = $town_city->read($id); // Implement the read method in the Student class

    if ($town_cityData) {
        // The student data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "Town City not found.";
    }
} else {
    echo "Town City ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name']      
    ];

    $db = new Database();
    $town_city = new TownCity($db);

    // Call the edit method to update the student data
    if ($town_city->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
    header("Location: town_view.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">

    <title class="record-title">Edit Town | City</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Town | City Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $town_cityData['id']; ?>">
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $town_cityData['name']; ?>">

        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
