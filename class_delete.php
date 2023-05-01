<?php
    include 'connect.php';

    if(isset($_GET['class_delete_id']))
    {
        $class_id = $_GET['class_delete_id'];

        $class_delete = $conn->prepare("DELETE FROM classroom WHERE class_id=(?)");
        $class_delete->bind_param('i',$class_id);
        if($class_delete->execute())
        {
            ?><script>alert("Delete Success");window.location.href="class.php";</script><?php
        }
        else
        {
            ?><script>alert("Unexpected Error occurred! Please try again later");history.back();</script><?php
        }
    }

?>