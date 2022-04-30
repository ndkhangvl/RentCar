<?php
if(isset($_GET["limit"], $_GET["start"]))
    {
        require 'connection.php';          
                $query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid ORDER BY c.typeid DESC LIMIT ".$_GET["start"].", ".$_GET["limit"]."";   
                $result = $conn->query($query) or die("Query failed: ".$conn->error);
                while ($row = $result->fetch_assoc()){
                echo "<div class=\"car-info\">
                                <img class=\"carImg\" src='imgLoad.php?name=$row[carID]'>
                                <b>LOẠI XE	: </b>$row[typeName]<br>
                                <b>SỐ CHỖ 	: </b>$row[seatNum]<br>
                                <b>BIỂN SỐ	: </b>$row[carNumPlate]<br>
                                <b>GIÁ THUÊ	: </b>$row[price] VNĐ/ngày<br>
                                <a class=\"detail\" href=\"car.php?name=$row[carNumPlate]\">Xem chi tiết</a>
                            </div>";
            }
        }
?>