<?php
session_start();
if(isset($_GET["limit"], $_GET["start"]))
    {
        require 'connection.php';
        $startprice=$_SESSION['start_price'];
        $endprice=$_SESSION['end_price'];
        if(!empty($startprice) && !empty($endprice))
                {
                    $query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid AND ct.price BETWEEN $startprice AND $endprice ORDER BY c.typeid DESC LIMIT ".$_GET["start"].", ".$_GET["limit"]."";        
            } else {           
                $query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid ORDER BY c.typeid DESC LIMIT ".$_GET["start"].", ".$_GET["limit"]."";
            }    
                $result = $conn->query($query) or die("Query failed: ".$conn->error);
                while ($row = $result->fetch_assoc()){
                echo "<div class=\"car-info\">
                                <img class=\"carImg\" src='imgLoad.php?name=$row[carID]'>
                                <b>TYPE     : </b>$row[typeName]<br>
                                <b>SEATS 	: </b>$row[seatNum]<br>
                                <b>NUMBER PLATE	: </b>$row[carNumPlate]<br>
                                <b>PRICE	: </b>$row[price] VND/day<br>
                                <a class=\"detail\" href=\"car.php?name=$row[carNumPlate]\">Detail>></a>
                            </div>";
            }
        }
    //error_reporting(E_ALL);
?>