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
<?php include('testmain.php') ?>
	<div id="container">
		<div id="title">
			<div id="top-title-left">
			<a href="../RentCar/main.php">RENT CAR KD</a>
			</div>
			<div id="search-title">
				<form method="GET" action="main.php">
					<input type="search" size="50" name="searchword"></input>
					<input type="submit" value="Tìm kiếm">
				</form>
			</div>
			<!--
				<div id="top-title-right">
					Đăng Tin 
				</div>
			-->
			<div id="login">
				<?php
					if(!isset($_SESSION['user_login']))
						echo "<a href=\"login.php\">Đăng Nhập</a>";
				?>
			</div>
			<div id="usernameA">
				<?php
					if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
						echo "Hello, " . $_SESSION['user_login'];
				?>
			</div>

			<div id="logout">
				<?php
					if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
					echo "<a href=\"logout.php\">Log Out</a>";
				?>
			</div>
		</div>

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
					</div>";
				}
			?>
		</div>
		<p class="spacer"> </p>

		
</body>
</html>