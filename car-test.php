<?php
    session_start();
?>
<?php
    $info = "";
    $numdate = "";
    $arrDate = [];
    $chk = 0;
    if(isset($_POST['from_date']) && isset($_POST['to_date'])){
        require "connection.php";
        if (empty($_POST['from_date']) || empty($_POST['to_date'])) {
            $info = '*Please choose both From and To date';
        } else {
            //// Tạo danh sách các ngày từ ngày thuê đến ngày trả
            // Ngày bắt đầu
            $datefrom = $_POST['from_date'];
            $datefrom = strtotime($datefrom); // Chuyển sang dạng UNIX timestamp
            // Ngày kết thúc
            $dateto = $_POST['to_date'];
            $dateto = strtotime($dateto); // Chuyển sang dạng UNIX timestamp
            // Dùng vòng lặp để xuất ra danh sách các ngày giữa 2 ngày
            for ($i=$datefrom; $i<=$dateto; $i+=86400) {
                if ($i == $datefrom) $cnt = 0;
                else $cnt++;
                $arrDate[$cnt] = date("Y-m-d", $i);
            }
            $numdate = count($arrDate);

            //// duyệt từng phần tử trong mảng các ngày
            for($i=0;$i<$numdate;$i++){
                //nếu có bất kì ngày nào trong mảng có tồn tại trong danh sách thông tin các lần thuê thì báo lỗi
                //echo "Ngay thu ".$i.": ".$arrDate[$i]."<br/>";
                //$cnt = 0;
                //// lấy danh sách thông tin các lần thuê của xe <>
                $sqlbooking = "select * from booking b join car c on b.carid=c.carid where c.carNumPlate = '$_REQUEST[name]'";
                $resultbooking = $conn->query($sqlbooking) or die("Data retrieval failed" . $conn->connect_error);
                while($rowbooking = $resultbooking->fetch_assoc()){
                    //$cnt++;
                    //echo "Lan thu: ".$cnt."<br/>";
                    $sqlchk = "select '$arrDate[$i]' between '$rowbooking[dateFrom]' and '$rowbooking[dateTo]' as tontai";
                    $resultchk = $conn->query($sqlchk) or die("Data retrieval failed" . $conn->connect_error);
                    $rowchk = $resultchk->fetch_assoc();
                    if ($rowchk['tontai'] == 1){
                        $chk = 1;
                        $i = $numdate;
                        break;
                    }
                }
            }
            if ($numdate == 0){
                $info ="Ngày không hợp lệ";
            }
            else if ($chk == 1){
                $info = "Thời gian này xe đã được thuê";
            }else {
                //Truy xuất id của car từ carnumplate
                $carid = "";
                $sqlid = "SELECT * FROM car c JOIN carType ct ON c.typeid=ct.typeid 
                    WHERE c.carNumPlate='$_REQUEST[name]'";
                $resultid = $conn->query($sqlid)
                    or die("Data retrieval failed" . $conn->connect_error);
                $rowid = $resultid->fetch_assoc();
                $carid = $rowid['carID'];

                //CHèn 1 lần thuê mới
                $sqlins = "INSERT INTO booking(dateFrom, custID, carID, dateTo) VALUES
                ('$_POST[from_date]', $_SESSION[user_id], $carid, '$_POST[to_date]')";
                $resultins = $conn->query($sqlins) or die("Data retrieval failed" . $conn->connect_error);
                
                $info = "Thuê thành công";
                
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