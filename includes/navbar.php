<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/students-profile/css/styles.css">
    <title>Your Page Title</title>
</head>
<body>
    <div class="toggle-btn" onclick="toggleSidebar()">☰</div>

    <div class="sidebar" id="sidebar">
        <div class="logo">
            <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;700&display=swap">
            <a href="https://www.facebook.com/photo/?fbid=1551680985635402&set=a.148788805924634"><img src="/students-profile\images\logo.jpg"  width="80" height="80" alt="Profile Pictures"></a>
            <h2>Obrien Troy D</h2>
        </div>
        <h1>Menu</h1>
        <ul>
            <li><a href="/students-profile/index.php">Home</a></li>
            <li><a href="/students-profile/views/students.view.php">Students</a></li>
            <li><a href="/students-profile/views/town_view.php">Town</a></li>
            <li><a href="/students-profile/views/province_view.php">Province</a></li>
            <li class="dropdown">
                <a href="#" class="dropbtn">Reports <span class="icon">&#9660;</span></a>
                <div class="dropdown-content">
                    <a href="/students-profile/config/report_01.php">Report 01</a>
                    <a href="/students-profile/config/report_02.php">Report 02</a>
                    <a href="/students-profile/config/report_03.php">Report 03</a>
                </div>
            </li>
        </ul>
    </div>

    <script>
        function toggleSidebar() {
          const sidebar = document.getElementById("sidebar");
          sidebar.style.left = sidebar.style.left === "0px" ? "-250px" : "0px";
        }
    </script>
</body>
</html>
