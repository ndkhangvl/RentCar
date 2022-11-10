<?php
    if(isset($_REQUEST['id'])){
        require "connection.php";
        $sqldel = "delete from booking where dateid = $_REQUEST[id]";
        $resultdel = $conn->query($sqldel) or die("Delete failed: ".$conn->error);
        header("Location: user.php");
        exit();
    }
?>