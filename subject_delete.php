<?php
    include 'connect.php';

    if(isset($_GET['sub_delete_id']))
    {
        $sub_id = $_GET['sub_delete_id'];

        $subject_delete = $conn->prepare("DELETE FROM subject WHERE sub_id=(?)");
        $subject_delete->bind_param('i',$sub_id);
        if($subject_delete->execute())
        {
            ?><script>alert("Delete Success");window.location.href="subject.php";</script><?php
        }
        else
        {
            ?><script>alert("Unexpected Error occurred! Please try again later");history.back();</script><?php
        }
    }

?>