<!DOCTYPE html>
<html>
<head>
  <title>Report 01</title>
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
  <script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
</script>

</head>
<body>

    <?php include('../templates/header.html')?>
    <?php include('../includes/navbar.php')?>
    <div class="content">
        <div class="reports">
            <div class="row">
            <div class="col-md-4">
                <div class="card">
                <div class="header">
                    <h4 class="title">Gender Statistics</h4>
                    <p class="category">Total Average of Students Gender</p>     
                </div>
                <div class="reports-content">
                <canvas id="chartShippers"></canvas>
        </div>
    </div>



<?php
require('config.php');
require('db_conn.php');

$query01 = "SELECT
students.gender as gender,
(COUNT(*) / (SELECT COUNT(*) FROM students WHERE id <> 0) * 100) as count_students
FROM students
GROUP BY students.gender;";

$result01 = mysqli_query($conn, $query01);

if(mysqli_num_rows($result01) > 0){
    $count_students = array();
    $gender = array();

    while ($row = mysqli_fetch_array($result01)){
        $count_students[] = $row['count_students'];
        $gender[] = $row['gender'];
    }

    mysqli_free_result($result01);
    mysqli_close($conn);
} else {
    echo "No records matching your query were found.";
}
?>

<script>
    // <!-- setup block -->
    const count_students = <?php echo json_encode($count_students); ?>;
    const gender = <?php echo json_encode($gender); ?>;
    const data1 = {
        labels: gender,
        datasets: [{
            label: 'Gender Datasets',
            data: count_students,
            backgroundColor: [
                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)'
            ],
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)'
            ],
            borderWidth: 1,
            hoverOffset: 4
        }]
    };
    // <!-- config block -->
    const config = {
        type: 'pie',
        data: data1,
    };
    // <!-- render block -->
    const chartShippers = new Chart(
        document.getElementById('chartShippers'),
        config
    );
</script>



</body>
</html>