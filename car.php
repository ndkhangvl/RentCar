<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vn">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Xe</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style-car.css">
</head>
<body>
    <?php include('header.php') ?>
	<div id="container">
        <?php
            if(isset($_REQUEST['name'])){
                require "connection.php";
                $query = "SELECT * FROM car c JOIN carType ct ON c.typeid=ct.typeid 
                    WHERE c.carNumPlate='$_REQUEST[name]'";
                $result = $conn->query($query)
                    or die("Data retrieval failed" . $conn->conenct_error);
                $row = $result->fetch_assoc();
                 if($row){
                    echo "<div class=\"car-info\">
                        <table id=\"frame\">
                            <tr>
                                <td id=\"fr-left\" align=\"right\"><img class=\"carImg\" src='imgLoad.php?name=$row[carID]'></td>
                                <td id=\"fr-right\">
                                    <b>LOẠI XE	: </b>$row[typeName]<br>
                                    <b>SỐ CHỖ 	: </b>$row[seatNum]<br>
                                    <b>BIỂN SỐ	: </b>$row[carNumPlate]<br>
                                    <b>GIÁ THUÊ	: </b>$row[price] VNĐ/ngày<br>";
                                    if(isset($_SESSION['user_login']) && $_SESSION['user_type'] == 2){
                                        echo "<a class=\"rent\" href=\"\">Thuê Xe</a>";
                                    }
                                echo "</td>
                            </tr>
                        </table>
                    </div>";
                }
            }
        ?>
	</div>

		
</body>
</html>