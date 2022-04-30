<?php
    session_start();
	$_SESSION['start_price'] = 0;
	$_SESSION['end_price'] = 0;
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
<?php
	if(isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1){
		echo "<div class=\"function\">
			<a class=\"addcar\" href=\"addcar.php\">Thêm Xe</a>
		</div>";
	}
?>
<?php 
	if(isset($_SESSION['user_login'])){
		include('filter.php');
	} else  {
		include('filter-unlogin.php');
	}
?>
	<div id="container">
		<div id="car-list">
			<?php
				
			?>
		</div>
		<p class="spacer"> </p>
</body>
</html>