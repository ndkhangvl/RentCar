<html>

<head>
    <link rel="stylesheet" href="testmain.css">
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
                <li class="item">Home</li>
                <li class="item">Product</li>
                <li class="item">Pricing</li>
                <li class="item">Contact</li>
            </ul>
            <div class="login-test">
				<?php
					if(!isset($_SESSION['user_login']))
						echo "<a href=\"login.php\">Đăng Nhập</a>";
				?>
			</div>
            <div class="usernameA-test">
				<?php
					if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
						echo "Hello, " . $_SESSION['user_login'];
				?>
			</div>

			<div class="login-test">
				<?php
					if(isset($_SESSION['user_login']) && $_SESSION['user_login'])
					echo "<a href=\"logout.php\">Log Out</a>";
				?>
			</div>
        </header>
    </div>
</body>

</html>