<?php
include_once("../db.php");
include_once("../province.php");

$db = new Database();
$connection = $db->getConnection();
$province = new Province($db);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Province Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">

</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2 class="record-title">Province Records</h2>
    <table class="orange-theme">
        <thead>
            <tr>
                <th>Name</th>  
                <th>Action</th>   
            </tr>
        </thead>
        <tbody>
            <!-- You'll need to dynamically generate these rows with data from your database -->
       
            
            
            <?php
            $results = $province->displayAll(); 
            foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['name']; ?></td>
                
                <td>
                    <a class="edit-button" href="province_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    
                    <a class="delete-button" href="province_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="province_add.php">Add New Record</a>

        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>



</body>
</html>
