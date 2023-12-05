<?php
include_once("../db.php");
include_once("../student.php");
include_once("../student_details.php");
include_once("../town_city.php");
include_once("../province.php");

$db = new Database();
$connection = $db->getConnection();
$student = new Student($db);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Student Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2 class="record-title">Student Records</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Student Number</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Gender</th>
                <th>Birthdate</th>
                <th>Contact Number</th>
                <th>Street</th>
                <th>Town City</th>
                <th>Province</th>
                <th>Zip Code</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
       
            
            
            <?php
            $results = $student->displayAll(); 
            foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['student_number']; ?></td>
                <td><?php echo $result['first_name']; ?></td>
                <td><?php echo $result['middle_name']; ?></td>
                <td><?php echo $result['last_name']; ?></td>
                <td><?php echo $result['gender']; ?></td>
                <td><?php echo date('M j, Y', strtotime($result['birthday'])); ?></td>   
                
                
                <td><?php echo $result['contact_number']; ?></td>
                <td><?php echo $result['street']; ?></td>
                <td><?php echo $result['town_city']; ?></td>
                <td><?php echo $result['province']; ?></td>
                <td><?php echo $result['zip_code']; ?></td>
                <td>
                    <a class="edit-button" href="student_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    
                    <a class="delete-button" href="student_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="student_add.php">Add New Record</a>

        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


    <p></p>
</body>
</html>
