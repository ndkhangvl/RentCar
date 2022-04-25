<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vn">
<head>
    <meta charset="UTF-8">
    <title>Thuê Xe</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
<?php include('header.php') ?>
	<div id="container">
		<div id="car-list">
			<?php
				require 'connection.php';
				$sw = "";
				if(isset($_GET['searchword'])){
					$sw = $_GET['searchword'];
				}
				$query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid 
					AND (ct.typename LIKE '%$sw%' OR ct.seatNum LIKE '%$sw%')
					ORDER BY c.typeid asc";
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
		</div>
		<p class="spacer"> </p>

		
</body>
</html>