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
<div id="container">
    <div id="title">
		<div id="top-title-left">
			Thuê Xe KD
        </div>
        <div id="search-title">
            <input type="search" size="50"></input>
        </div>
		<div id="top-title-right">
			Đăng Tin 
        </div>
        <div id="login">
			<?php
				if(!isset($_SESSION['user_login']))
					echo "<a href=\"login.php\">Đăng Nhập</a>";
			?>
        </div>
		<div id="usernameA">
			<?php
				if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
					echo $_SESSION['user_login'];
			?>
        </div>

		<div id="logout">
			<?php
				if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
				echo "<a href=\"logout.php\">Đăng xuất</a>";
			?>
		</div>
    </div>

	<div id="car-list">
		<?php
			$servername = "localhost";
			$username = "root";
			$password = "";
			$dbname = "rentCar";
			$conn = new mysqli($servername, $username,$password, $dbname)
				or die ("Connection failed " . $conn->connect_error);
			
			$query = "SELECT * FROM car c JOIN carType ct WHERE c.typeid=ct.typeid ORDER BY c.typeid asc";
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

	<p>
		Last updated: 2/2014
	</p>
</body>
</html>