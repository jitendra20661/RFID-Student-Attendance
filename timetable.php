

<?php
    include_once "connect.php";
    $reg_success = 0;
    $sub_exist = 0;

//if any login cookie, check here

//any form submit logicSS
    if(isset($_POST['timetable_create_btn']))
    {                   
        $class_id = $_POST['class_id'];       
        $sub_id = $_POST['sub_id'];                    
        $day = $_POST['day'];                    
        $start_time = $_POST['start_time'];                    
        $end_time = $_POST['end_time'];

            $tt_insert = $conn->prepare("INSERT INTO timetable (class_id,sub_id,day,start_time,end_time) VALUES (?,?,?,?,?)");
            $tt_insert->bind_param('iiiss',$class_id,$sub_id,$day,$start_time,$end_time);
            if($tt_insert->execute())
            {
                ?><script>alert("Timetable added Success.");</script><?php
            }
            else{
                ?><script>alert("Unexpected Error.");history.back();</script><?php

            }
    }

//select queries
                     
    //pre-populate class dropdown
    $fetch_class = $conn->prepare("SELECT * FROM classroom");
    $fetch_class->execute();
    $fetch_class_res = $fetch_class->get_result();

    //fetch all subjects for sub
    $fetch_sub = $conn->prepare("SELECT subject.*,classroom.class_name FROM subject JOIN classroom ON subject.class_id = classroom.class_id");
    $fetch_sub->execute();
    $fetch_sub_res = $fetch_sub->get_result();

    //find timetable for distinct class 
    $distinct_class = $conn->prepare("SELECT DISTINCT class_id from timetable");
    $distinct_class = $conn->prepare("SELECT DISTINCT timetable.class_id,classroom.class_name from timetable JOIN classroom ON timetable.class_id = classroom.class_id");
    $distinct_class->execute();
    $distinct_class_res = $distinct_class->get_result();  
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Student Attendance</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

    
</head>

<body>
  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="class.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Admin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">




      <li class="nav-item">
        <a class="nav-link collapsed" href="class.php">
          <i class="bi bi-question-circle"></i>
          <span>Class</span>
        </a>
      </li><!-- End F.A.Q Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="subject.php">
          <i class="bi bi-question-circle"></i>
          <span>Subject</span>
        </a>
      </li><!-- End Subject Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="student.php">
          <i class="bi bi-envelope"></i>
          <span>Student</span>
        </a>
      </li><!-- End Contact Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="timetable.php">
          <i class="bi bi-card-list"></i>
          <span>Timetable</span>
        </a>
      </li><!-- End Register Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="student.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Attendance</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->


  <main id="main" class="main">
  <?php
if ($sub_exist) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Subject Already Exists !</strong> Subject Repetition not allowed.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>

    <div class="pagetitle">
      <h1>Manage Timetable</h1>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Create Timetable to Class</h5>

              <!-- Add Students form -->
              <form method="post" onchange="this.form.submit()">
                  
                <!-- Dropdown for Class Prepopulated -->
                <div class="form-group my-3">
                    <small>Class:</small>
                    <select class="form-control" id="class_id" name="class_id" required onchange="getSubjects()">
                        <option disabled selected>--Select Class--</option>
                        <?php
                        while($fetch_class_row = $fetch_class_res->fetch_assoc()) {
                            echo "<option value='".$fetch_class_row['class_id']."'>".$fetch_class_row['class_name']."</option>";
                        }
                        ?>
                    </select>
                </div>

                <!-- Dropdown for Subject Prepopulated -->
                <div class="form-group my-3">
                    <small>Subject:</small>
                    <select class="form-control" id="sub_id" name="sub_id" required>
                        <option disabled selected>--Select Subject--</option>
                    </select>
                </div>

                <!-- Dropdown for Day -->
                <div class="form-group my-3">
                      <small>Day</small>
                      <select class="form-control" id="day" name="day" required>
                          <option disabled selected>--Select a Day--</option>
                          <option value="1">Mon</option>
                          <option value="2">Tue</option>
                          <option value="3">Wed</option>
                          <option value="4">Thur</option>
                          <option value="5">Fri</option>
                          <option value="6">Sat</option>
                    </select>
                </div>

                <div class="form-group my-3">
                    <small>Start Time:</small>
                    <input type="time" class="form-control" id="start_time" aria-describedby="emailHelp" name="start_time" required>
                </div>
                <div class="form-group my-3">
                    <small>End Time:</small>
                    <input type="time" class="form-control" id="end_time" aria-describedby="emailHelp" name="end_time" required>
                </div>

                <div class="form-group my-2">
                    <button type="submit" class="btn btn-primary" name="timetable_create_btn">Submit</button>
                </div>
              </form>
            </div>
          </div>

        </div>

        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Time Table</h5>
                <?php 

                  //for each class 
                    while($distinct_class_row = $distinct_class_res->fetch_assoc())
                    {
                        $temp_class_id = $distinct_class_row['class_id'];
                        echo '<h2>'.$distinct_class_row['class_name'].' - Timetable </h2>';

                        echo '<table class="table datatable">
                                <thead>
                                  <tr>
                                      <th scope="col">Day</th>
                                      <th scope="col">Subject</th>
                                      <th scope="col">Start Time</th>
                                      <th scope="col">End Time</th>
                                      <th scope="col">Delete</th>
                                  </tr>
                                </thead>
                                <tbody>';
                                  $sql = $conn->prepare("SELECT timetable.*,classroom.class_name FROM timetable JOIN classroom ON timetable.class_id = classroom.class_id WHERE timetable.class_id = ".$temp_class_id." ORDER BY day ASC");
                                  $sql->execute();
                                  $res = $sql->get_result();

                                    while ($row = $res->fetch_assoc())
                                      { 
                                        $sub_name = $conn->prepare('SELECT sub_name FROM subject WHERE sub_id = '.$row['sub_id'].'');
                                        $sub_name->execute();
                                        $sub_name_res = $sub_name->get_result();
                                        $sub_name_row = $sub_name_res->fetch_assoc();
                                          echo "<tr>
                                                  <td>".$row['day']."</td>
                                                  <td>".$sub_name_row['sub_name']."</td>
                                                  <td>".date('g:i a', strtotime($row['start_time']))."</td>
                                                  <td>".date('g:i a', strtotime($row['end_time']))."</td>
                                                  <td>
                                                      <a class='btn btn-danger' href='timetable_delete.php?delete_t_id=".$row['t_id']."'>Delete</a>
                                                  </td>
                                                </tr>";
                  
                                      }
                        echo '</tbody></table>';
                        }
                    

                ?>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>APV</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

  <script src="jquery.main.js" type="text/javascript"></script>
  <script type="text/javascript">
    function getSubjects() {
        var classId = $('#class_id').val(); // Get the selected class ID
        $.ajax({
            type: 'POST',
            url: 'get_subjects.php', // Create a separate PHP file to handle the AJAX request
            data: { class_id: classId },
            success: function(response) {
                $('#sub_id').html(response); // Populate the subject dropdown with the retrieved options
            }
        });
    }
</script>


</body>

</html>