<!DOCTYPE html>
<html lang="en">
<head>
    
  <link rel="stylesheet" type="text/css" href="../css/styles.css">
  <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.7.1/chart.min.js"></script>
  <title>Student Province Distribution</title>

</head>
<body>
<?php include('../templates/header.html'); ?>
<?php include('../includes/navbar.php'); ?>
<div class="content">
  <div class="reports">
      <div class="col-md-8">
      <div class="card">
          <div class="header">
          <h4 class="title">Student Province Distribution</h4>
          <p class="category">Number of Students in Each Province</p>
          </div>
          <div class="reports-content">
          <canvas id="chartStudentProvince"></canvas>
  </div>
</div>

      <?php
      require('config.php');
      require('db_conn.php');

        $queryProvince = "SELECT province.name as province, COUNT(*) AS student_count
        FROM student_details
        INNER JOIN province ON student_details.province = province.id
        GROUP BY province.name";
      $resultProvince = mysqli_query($conn, $queryProvince);
      $provinces = array();
      $studentCounts = array();

      while ($row = mysqli_fetch_array($resultProvince)) {
        $provinces[] = $row['province'];
        $studentCounts[] = $row['student_count'];
      }

      mysqli_free_result($resultProvince);
      ?>

      <script>
        const provinces = <?php echo json_encode($provinces); ?>;
        const studentCounts = <?php echo json_encode($studentCounts); ?>;

        const dataProvince = {
          labels: provinces,
          datasets: [{
            data: studentCounts,
            backgroundColor: [

                'rgba(255, 99, 132, 0.2)',
                'rgba(54, 162, 235, 0.2)',
                'rgba(255, 165, 0, 0.2)',
                'rgba(75, 192, 192, 0.2)',
              // Add more colors as needed
            ],
            borderWidth: 1
          }]
        };

        const configProvince = {
          type: 'doughnut',
          data: dataProvince,
        };

        const chartStudentProvince = new Chart(document.getElementById('chartStudentProvince'), configProvince);
      </script>
    </div>
  </div>
</div>

</body>
</html>
