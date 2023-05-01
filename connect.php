<?php
  // Connect to the MySQL database
  $servername = "localhost";
  $username = "root";
  $password = "";
  $dbname = "student_attendance";

  $conn = mysqli_connect($servername, $username, $password, $dbname);

  // Check for connection errors
  if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
  }

//   mysqli_close($conn);
?>
