<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rentCar";
    $conn = new mysqli($servername, $username,$password, $dbname)
        or die ("Connection failed " . $conn->connect_error);

    if(isset($_POST['username'])) {
        $custPhone=$_POST['username'];
        $custPasswd=$_POST['password'];
        $custPasswd=md5($_POST['password']);

        $sql="select * from customer where custPhone='".$custPhone."'AND custPasswd='".$custPasswd."' limit 1";
        $result = $conn->query($sql);

        if(mysqli_num_rows($result) == 1) {
            header("Location: ../RentCar/main.php");
            exit();
        }
        else {
            echo "Incorred Password or Username";
            exit();
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style-login.css">
</head>
<body>
	<div class="container-login">
    <h1>Rent Car KD</h1>
	<!-- <img src="image/login.png"/> -->
		<form method="POST" action="#">
			<div class="form-input">
				<input type="text" name="username" placeholder="Enter the User Name"/>	
			</div>
			<div class="form-input">
				<input type="password" name="password" placeholder="Password"/>
			</div>
            <span id="error"></span>
			<input type="submit" type="submit" value="LOGIN" class="btn-login"/>
		</form>
	</div>
</body>
</html>