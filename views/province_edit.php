<?php
include_once("../db.php"); // Include the Database class file
include_once("../province.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Fetch student data by ID from the database
    $db = new Database();
    $province = new Province($db);
    $provinceData = $province->read($id); // Implement the read method in the Student class

    if ($provinceData) {
        // The student data is retrieved, and you can pre-fill the edit form with this data.
    } else {
        echo "Province not found.";
    }
} else {
    echo "Province ID not provided.";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'id' => $_POST['id'],
        'name' => $_POST['name']      
    ];

    $db = new Database();
    $province = new Province($db);

    // Call the edit method to update the student data
    if ($province->update($id, $data)) {
        echo "Record updated successfully.";
    } else {
        echo "Failed to update the record.";
    }
    header("Location: province_view.php");
}
?>
<!DOCTYPE html>
<html>
<head>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">

    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <title class="record-title">Edit Province</title>
</head>
<body>
    <!-- Include the header and navbar -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2>Edit Province Information</h2>
    <form action="" method="post">
        <input type="hidden" name="id" value="<?php echo $provinceData['id']; ?>">
        
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" value="<?php echo $provinceData['name']; ?>">

        
        <input type="submit" value="Update">
    </form>
    </div>
    <?php include('../templates/footer.html'); ?>
</body>
</html>
