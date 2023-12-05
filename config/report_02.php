<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="../css/styles.css">
  <script
src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js">
</script>
  <title>Report 02</title>
</head>
<body>

<?php include('../templates/header.html'); ?>
<?php include('../includes/navbar.php'); ?>
<div class="content">
    <div class="col-md-6">
    <div class="card ">
        <div class="header">
        <h4 class="title">Top 5 Students Town | City</h4>
        <p class="category">Town | City</p>
        </div>
        <div id="report02" class="reports-content">
        <canvas id="myChartTopFive"></canvas>
</div>


<?php
require('config.php');
require('db_conn.php');

$query04 = "SELECT town_city.name AS town_city, COUNT(*) AS order_count
            FROM student_details
            JOIN town_city ON student_details.town_city = town_city.id
            JOIN students ON student_details.student_id = students.id
            GROUP BY town_city.id
            ORDER BY order_count DESC, town_city.name
            LIMIT 5 ;";

$result04 = mysqli_query($conn, $query04);

if ($result04) {
    $order_count = array();
    $town_city = array();

    while ($row = mysqli_fetch_array($result04)) {
        $order_count[] = $row['order_count'];
        $town_city[] = $row['town_city'];
    }

    mysqli_free_result($result04);
    mysqli_close($conn);
} else {
    echo "Error executing the query: " . mysqli_error($conn);
}

?>

<script>

const label_barchart = <?php echo json_encode($town_city); ?>;
const data4 = {
    labels: label_barchart,
    datasets: [{
        label: 'Students Towm | City',
        data: <?php echo json_encode($order_count); ?>,
        backgroundColor: [
            'rgba(255, 99, 132, 0.2)',
            'rgba(54, 162, 235, 0.2)',
            'rgba(255, 206, 86, 0.2)',
            'rgba(75, 192, 192, 0.2)',
            'rgba(153, 102, 255, 0.2)',
            'rgba(255, 159, 64, 0.2)'
        ],
        borderColor: [
            'rgba(255, 99, 132, 1)',
            'rgba(54, 162, 235, 1)',
            'rgba(255, 206, 86, 1)',
            'rgba(75, 192, 192, 1)',
            'rgba(153, 102, 255, 1)',
            'rgba(255, 159, 64, 1)'
        ],
        borderWidth: 1
    }]
};

// <!-- config block -->
const config4 = {
    type: 'bar',
    data: data4,
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
};

// <!-- render block -->
const myChartTopFive = new Chart(
    document.getElementById('myChartTopFive'),
    config4
);
</script>
  
</body>
</html>