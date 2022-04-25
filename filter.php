<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
</head>
<body>
        <form action="" method="GET">
                <div class="row">
                    <div class="filter">
                            <label for="">Start Price</label>
                                <input type="text" name="start_price" value="<?php if(isset($_GET['start_price'])){echo $_GET['start_price']; }else{echo "";} ?>" class="form-control">
                    </div>
                        <div class="filter">
                            <label for="">End Price</label>
                                <input type="text" name="end_price" value="<?php if(isset($_GET['end_price'])){echo $_GET['end_price']; }else{echo "";} ?>" class="form-control">
                        </div>
                        <div class="filter">
                                <button type="submit" class="btn btn-primary px-4">Filter</button>
                        </div>
                </div>
        </form>
<?php  
        require 'connection.php';
            if(isset($_GET['start_price']) && isset($_GET['end_price']))
                {
                    $startprice = $_GET['start_price'];
                    $endprice = $_GET['end_price'];
                    $query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid AND price BETWEEN $startprice AND $endprice 
                    ORDER BY c.typeid asc";
                } else {
                    $query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid";
                }
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
                                ?>
</body>
</html>