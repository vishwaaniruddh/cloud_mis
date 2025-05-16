<?php
include("config.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];

    if ($action == 'delete') {
        $id = intval($_POST['id']);
        mysqli_query($con, "DELETE FROM mis_subcomponent WHERE id = $id");
        echo "deleted";
    }

    if ($action == 'update') {
        $id = intval($_POST['id']);
        $name = mysqli_real_escape_string($con, $_POST['name']);
        mysqli_query($con, "UPDATE mis_subcomponent SET name='$name' WHERE id = $id");
        echo "updated";
    }
}
?>
