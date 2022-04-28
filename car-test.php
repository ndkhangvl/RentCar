<?php
    session_start();
?>
<?php
    $info = "";
    $chkfrom = $chkto = 0;
    $posfrom = $posto = 0;
    if(isset($_POST['from_date']) && isset($_POST['to_date'])){
        require "connection.php";
        if (empty($_POST['from_date']) || empty($_POST['to_date'])) {
            $info = '*Please choose both From and To date';
        } else {
            $sql1 = $sql2 = "select * from booking b join car c on b.carid=c.carid where c.carNumPlate = '$_REQUEST[name]'";
            $resultsql1 = $conn->query($sql1) or die("Data retrieval failed" . $conn->connect_error);
            
            while ($rowsql1 = $resultsql1->fetch_assoc()){
                $sqlfrom = "select '$_POST[from_date]' between '$rowsql1[dateFrom]' and '$rowsql1[dateTo]' as tontai";
                $resultfrom = $conn->query($sqlfrom) or die("Data retrieval failed" . $conn->connect_error);
                $rowfrom = $resultfrom->fetch_assoc();
                if ($rowfrom['tontai'] == 1) {
                    $chkfrom = 1;
                    $posfrom = $rowsql1['bookid'];
                    break;
                }
            }
            $resultsql2 = $conn->query($sql2) or die("Data retrieval failed" . $conn->connect_error);
            while ($rowsql2 = $resultsql2->fetch_assoc()){
                $sqlto = "select '$_POST[to_date]' between '$rowsql2[dateFrom]' and '$rowsql2[dateTo]' as tontai";
                $resultto = $conn->query($sqlto) or die("Data retrieval failed" . $conn->connect_error);
                $rowto = $resultto->fetch_assoc();
                if ($rowto['tontai'] == 1) {
                    $chkto = 1;
                    $posto = $rowsql2['bookid'];
                    break;
                }
            }
            /*echo $chkfrom. "    ".$chkto."<br/>";
            echo $posfrom. "    ".$posto;*/
            if (($posfrom == $posto || $posfrom!=0 || $posto!=0) && ($chkfrom == 1 || $chkto == 1)){
                $info = "Xe đã được thuê thời gian này";
            } else if ($chkfrom == 0 && $chkto == 0 && $posfrom == 0 && $posto ==0){
                $info ="Thue thanh cong";
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="vn">
<head>
    <meta charset="UTF-8">
    <title>Thông Tin Xe</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" type="text/css" href="style-car-test.css">
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
                    or die("Data retrieval failed" . $conn->connect_error);
                $row = $result->fetch_assoc();
                $query2 = "select ROW_NUMBER() OVER (ORDER BY dateFrom) AS STT, dateFrom,dateTo,c.carid,b.custid
                    from booking b join car c on b.carid=c.carid where c.carNumPlate ='$_REQUEST[name]'";
                $result2 = $conn->query($query2)
                    or die("Data retrieval failed" . $conn->connect_error);
                 if($row){
                    echo "<div class=\"car-info\">
                        <table id=\"frame\">
                            <tr>
                                <td id=\"fr-left\" align=\"right\"><img class=\"carImg\" src='imgLoad.php?name=$row[carID]'></td>
                                <td id=\"fr-center\">
                                    <b>LOẠI XE	: </b>$row[typeName]<br>
                                    <b>SỐ CHỖ 	: </b>$row[seatNum]<br>
                                    <b>BIỂN SỐ	: </b>$row[carNumPlate]<br>
                                    <b>GIÁ THUÊ	: </b>$row[price] VNĐ/ngày<br>";
                                    if(isset($_SESSION['user_login']) && $_SESSION['user_type'] == 2){
                                        //echo "<a class=\"rent\" href=\"\">Thuê Xe</a>";
                                        
                                        echo "<br/><br/><hr>";
                                        echo "<form action=\"#\" method=\"POST\" id=\"form-rent\">
                                            <label for=\"from\">From:</label>
                                            <input type=\"date\" name=\"from_date\">
                                            <label for=\"to\">To:</label>
                                            <input type=\"date\" name=\"to_date\"><br/>
                                            <input type=\"submit\" value=\"Thuê Xe\"><br/>";
                                            echo "<span id=\"notification\">$info</span>
                                        </form>";
                                    }
                                echo "</td>
                                <td id=\"fr-right\">";
                                echo "Ghi nhận thuê xe";
                                    echo "<table id=\"tbl-renttime\">
                                        <tr>
                                            <th>STT</th>
                                            <th>Ngày Thuê<br/>(YYYY/MM/DD)</th>
                                            <th>Ngày Trả<br/>(YYYY/MM/DD)</th>
                                        </tr>";
                                    while($row2 = $result2->fetch_assoc()){
                                        echo "<tr>
                                            <td>$row2[STT]</td>
                                            <td>$row2[dateFrom]</td>
                                            <td>$row2[dateTo]</td>
                                        </tr>";
                                    }
                                    
                                echo "</table>
                                </td>
                            </tr>
                        </table>
                    </div>";
                }
            }
        ?>
	</div>

		
</body>
</html>