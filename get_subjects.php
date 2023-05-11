<?php
include_once "connect.php";

if (isset($_POST['class_id'])) {
    $classId = $_POST['class_id'];

    $fetch_sub = $conn->prepare("SELECT * FROM subject WHERE class_id = ?");
    $fetch_sub->bind_param('i', $classId);
    $fetch_sub->execute();
    $fetch_sub_res = $fetch_sub->get_result();

    $options = '<option disabled selected>--Select Subject--</option>';
    while ($fetch_sub_row = $fetch_sub_res->fetch_assoc()) {
        $options .= '<option value="'.$fetch_sub_row['sub_id'].'">'.$fetch_sub_row['sub_name'].'</option>';
    }

    echo $options;
}
?>
