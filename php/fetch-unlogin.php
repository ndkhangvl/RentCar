<?php
if(isset($_GET["limit"], $_GET["start"]))
    {
        require 'connection.php';          
                $query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid ORDER BY c.typeid DESC LIMIT ".$_GET["start"].", ".$_GET["limit"]."";   
                $result = $conn->query($query) or die("Query failed: ".$conn->error);
                while ($row = $result->fetch_assoc()){
                echo "<div class=\"car-info-card\">
                                <img class=\"carImg-card\" src='imgLoad.php?name=$row[carID]'><br>
                                <b>TYPE     : </b>$row[typeName]<br>
                                <b>SEATS 	: </b>$row[seatNum]<br>
                                <b>NUMBER PLATE	: </b>$row[carNumPlate]<br>
                                <b>PRICE	: </b>$row[price] VND/day<br>
                                <a class=\"detail\" href=\"car.php?name=$row[carNumPlate]\">Detail>></a>
                            </div>";
            }
        }
?>