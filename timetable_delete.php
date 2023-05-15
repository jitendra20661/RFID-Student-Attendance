<?php
    include 'connect.php';

    if(isset($_GET['delete_t_id']))
    {
        $t_id = $_GET['delete_t_id'];

        $timetable_del = $conn->prepare("DELETE FROM timetable WHERE t_id=(?)");
        $timetable_del->bind_param('i',$t_id);
        if($timetable_del->execute())
        {
            ?><script>alert("Delete Success");window.location.href="timetable.php";</script><?php
        }
        else
        {
            ?><script>alert("Unexpected Error occurred! Please try again later");history.back();</script><?php
        }
    }

?>