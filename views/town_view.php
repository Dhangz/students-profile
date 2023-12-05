<?php
include_once("../db.php");
include_once("../town_city.php");

$db = new Database();
$connection = $db->getConnection();
$town_city = new TownCity($db);

?>
<!DOCTYPE html>
<html>
<head>
    <title>Town | City Records</title>
    <link rel="stylesheet" type="text/css" href="../css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">

</head>
<body>
    <!-- Include the header -->
    <?php include('../templates/header.html'); ?>
    <?php include('../includes/navbar.php'); ?>

    <div class="content">
    <h2 class="record-title">Town | City Records</h2>
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
            $results = $town_city->displayAll(); 
            foreach ($results as $result) {
            ?>
            <tr>
                <td><?php echo $result['name']; ?></td>
                
                <td>
                    <a class="edit-button" href="town_edit.php?id=<?php echo $result['id']; ?>">Edit</a>
                    
                    <a class="delete-button" href="town_delete.php?id=<?php echo $result['id']; ?>">Delete</a>
                </td>
            </tr>
        <?php } ?>

           
        </tbody>
    </table>
        
    <a class="button-link" href="town_add.php">Add New Record</a>

        </div>
        
        <!-- Include the header -->
  
    <?php include('../templates/footer.html'); ?>


s
</body>
</html>
