<?php 
    if(isset($_REQUEST['name'])){
        $servername ="localhost";
        $username = "root";
        $password ="";
        $dbname ="rentCar";
        $conn = new mysqli($servername,$username,$password,$dbname)
            or die("Connect failed " . $conn->connect_error);
        
        $query = "SELECT * FROM car WHERE carID='$_REQUEST[name]'";
        $result = $conn->query($query)
            or die("Data retrieval failed" . $conn->conenct_error);
        $row = $result->fetch_assoc();
        if($row){
            header("Content-type: image/jpeg");
            echo $row['carImg'];
        }
        else echo "Image '$_REQUEST[name]' is not found"; 
    }
    else echo "Image name is required"
?>