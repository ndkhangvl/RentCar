<html>

<head>
    <link rel="stylesheet" href="header.css">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</head>

<body>
    <div id="web">
        <header>
            <div class="logo">
                <ion-icon name="car-sport-outline"></ion-icon>
            </div>
            <ul id="main-menu">
                <li class="item"><a href="../RentCar/main.php">Home</a></li>
                <li class="item"><a href="../RentCar/main.php">Product</a></li>
                <li class="item"><a href="../RentCar/main.php">Contact</a></li>
                <li class="item"><a href="../RentCar/main.php">About Us</a></li>
            </ul>
            <div class="usernameA-test">
				<?php
					if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
						echo "Hello, " . $_SESSION['user_login'];
				?>
			</div>
			<div class="logout-test">
				<?php
                    if(!isset($_SESSION['user_login']))
                    echo "<a class=\"logout\" href=\"login.php\">Đăng Nhập</a>";

					if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
					echo "<a class=\"logout\" href=\"logout.php\">Log Out</a>";
				?>
			</div>
        </header>
    </div>
</body>

</html>