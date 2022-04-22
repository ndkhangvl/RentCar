<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "rentCar";
    $conn = new mysqli($servername, $username,$password, $dbname)
        or die ("Connection failed " . $conn->connect_error);

        if(isset($_POST["username"]) && isset($_POST["password"])
        && isset($_POST["name"]) && isset($_POST["e-mail"])) {
            $accPhone = $_POST["username"];
            $accPasswd = $_POST["password"];
            $accPasswd=md5($_POST['password']);
            $accName = $_POST["name"];
            $accMail = $_POST["e-mail"];
            if('password' === 're-password') {
            $query = "INSERT INTO accounts(accPhone,accPasswd,accName,accMail,accType) 
                        VALUES ('$accPhone','$accPasswd','$accName','$accMail','1')";
            $result = $conn->query($query)
                or die("Query failed: " . $conn->error);
            } else {
                $error = 'Password not match';
                echo "<span id='error'>". $error ."</span>";
            }
        }       
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style-login.css">
</head>
<body>
	<div class="container-register">
    <h1>Rent Car KD</h1>
	<!-- <img src="image/login.png"/> -->
		<form method="POST" action="#">
			<div class="form-input">
				<input type="text" name="username" id="username" placeholder="Enter the User Name"/>	
			</div>
            <div class="form-input">
				<input type="password" name="password" id="password" placeholder="Enter the Password"/>	
			</div>
            <div class="form-input">
				<input type="password" name="re-password" id="re-password" placeholder="Enter the Re-password"/>	
			</div>
            <div class="form-input">
				<input type="text" name="name" placeholder="Enter Name Customer"/>	
			</div>
			<div class="form-input">
				<input type="text" name="e-mail" placeholder="Enter Email"/>
			</div>
            <span id="error"></span>
			<input type="submit" onclick="validate()" type="submit" value="Register" class="btn-login"/>
		</form>
	</div>
    <!-- <script src="check.js"></script> -->
</body>
</html>