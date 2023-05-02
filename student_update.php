<?php
    include_once "connect.php";
    $student_update = 0;

//if any login cookie, check here

//any form submit logicSS
if(isset($_GET['student_update_id']))
{
    $id = $_GET['student_update_id'];
    
    //fetch all student and their resp class_name to pre-populate
    $fetch_student = $conn->prepare("SELECT student.*, classroom.class_name FROM student JOIN classroom ON student.class_id = classroom.class_id WHERE student.id=(?)");
    $fetch_student->bind_param('i', $id);
    $fetch_student->execute();
    $fetch_student_res = $fetch_student->get_result();
    $fetch_student_row = $fetch_student_res->fetch_assoc();

    // Fetch all classes for dropdown
    $fetch_classes = $conn->prepare("SELECT * FROM classroom");
    $fetch_classes->execute();
    $fetch_classes_res = $fetch_classes->get_result();


    if(isset($_POST['update_Student_btn']))
    {  
        $student_id = $_POST['student_id'];                    
        $student_name = $_POST['student_name'];                    
        $class_id = $_POST['class_id'];       
        
            // $student_insert = $conn->prepare("INSERT INTO student (student_id,student_name,class_id) VALUES (?,?,?)");
            $student_insert = $conn->prepare("UPDATE student SET student_id =(?),student_name =(?),class_id =(?)  WHERE id =(?)");
            $student_insert->bind_param('ssii',$student_id,$student_name,$class_id,$id);
            if($student_insert->execute())
            {
                ?><script>alert("Student Updated.");window.location.href="student.php";</script><?php
            }
            else{
                ?><script>alert("Unexpected Error.");history.back();</script><?php

            }

    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Components / Accordion - NiceAdmin Bootstrap Template</title>
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
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">NiceAdmin</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <img src="assets/img/profile-img.jpg" alt="Profile" class="rounded-circle">
            <span class="d-none d-md-block dropdown-toggle ps-2">K. Anderson</span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6>Kevin Anderson</h6>
              <span>Web Designer</span>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-person"></i>
                <span>My Profile</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="users-profile.html">
                <i class="bi bi-gear"></i>
                <span>Account Settings</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="pages-faq.html">
                <i class="bi bi-question-circle"></i>
                <span>Need Help?</span>
              </a>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>

            <li>
              <a class="dropdown-item d-flex align-items-center" href="#">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sign Out</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="index.html">
          <i class="bi bi-grid"></i>
          <span>Home</span>
        </a>
      </li><!-- End Home Nav -->


      <li class="nav-item">
        <a class="nav-link collapsed" href="class.php">
          <i class="bi bi-question-circle"></i>
          <span>Class</span>
        </a>
      </li><!-- End Manage Class Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="student.php">
          <i class="bi bi-envelope"></i>
          <span>Student</span>
        </a>
      </li><!-- End Manage Student Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="timetable.php">
          <i class="bi bi-card-list"></i>
          <span>Timetable</span>
        </a>
      </li><!-- End Manage Timetable Page Nav -->

      <li class="nav-item">
        <a class="nav-link collapsed" href="attendance.php">
          <i class="bi bi-box-arrow-in-right"></i>
          <span>Attendance</span>
        </a>
      </li><!-- End Login Page Nav -->

    </ul>

  </aside><!-- End Sidebar-->


  <main id="main" class="main">
  <?php
if ($student_update) {
    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Student Exists !</strong> Card already assigned. Retry using a different Card.
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>';
}
?>

    <div class="pagetitle">
      <h1>Manage Studends</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="#">Home</a></li>
          <li class="breadcrumb-item">Pages</li>
          <li class="breadcrumb-item active">Blank</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Update Student</h5>

              <!-- Update Students form -->
              <form method="post">

                <div class="form-group">
                  <label for="student_id">Student Card UID:</label>
                  <input type="text" class="form-control" id="student_id" aria-describedby="emailHelp" name="student_id" value="<?php echo $fetch_student_row['student_id']; ?>" required>
                </div>
                <div class="form-group my-3">
                  <label for="student_name">Student Name:</label>
                  <input type="text" class="form-control" id="student_name" aria-describedby="emailHelp" placeholder="Enter Student name" name="student_name" value="<?php echo $fetch_student_row['student_name']; ?>"required>
                </div>
                
                <!-- Dropdown for Class Prepopulated -->
                <div class="form-group my-3">
                  <label for="class_id">Select Class:</label>
                  <select class="form-control" id="class_id" name="class_id" required>
                      <?php
                        while ($fetch_class_row = $fetch_classes_res->fetch_assoc()) {
                            $class_id = $fetch_class_row['class_id'];
                            $class_name = $fetch_class_row['class_name'];

                            $selected = ($class_id == $fetch_student_row['class_id']) ? 'selected' : '';

                            echo "<option value='$class_id' $selected>$class_name</option>";
                        }
                    ?>
                  </select>
                </div>
                <div class="form-group my-2">
                    <button type="submit" class="btn btn-primary" name="update_Student_btn">Update</button>
                </div>
              </form>
            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>NiceAdmin</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
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

</body>

</html>