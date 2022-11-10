<?php
    require 'connection.php';
    
    if(isset($_FILES['img_file']['name']) && getimagesize($_FILES['img_file']['tmp_name']) != false){
        $image = file_get_contents($_FILES['img_file']['tmp_name']);
        $image = addslashes($image);
        //$imgname = $_FILES['img_file']['name'];
        $imgname=$_POST['carPlate'];
        $conn->query("UPDATE car SET carImg='$image' WHERE carNumPlate='$imgname'")
            or die("Cannot insert into DB: ". $conn->connect_error);
            header("Location: ./insertcarImgform.php");
    }
    
?>
