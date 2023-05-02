<?php
    include 'connect.php';

    if(isset($_GET['student_delete_id']))
    {
        $id = $_GET['student_delete_id'];

        $student_delete = $conn->prepare("DELETE FROM student WHERE id=(?)");
        $student_delete->bind_param('i',$id);
        if($student_delete->execute())
        {
            ?><script>alert("Delete Success");window.location.href="student.php";</script><?php
        }
        else
        {
            ?><script>alert("Unexpected Error occurred! Please try again later");history.back();</script><?php
        }
    }

?>