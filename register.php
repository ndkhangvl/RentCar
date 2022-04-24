<!-- if else chua duoc :)) -->
<?php
    require 'connection.php';
    $usernameErr = $passwordErr = $repasswordErr = $nameErr = $emailErr = "";
    $accPhone = $accPasswd = $accRePasswd = $accName = $accMail = "";
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["re-password"])
    && isset($_POST["name"]) && isset($_POST["e-mail"])) {
        $accPhone = $_POST["username"];
        $accPasswd = $_POST['password'];
        $accPasswd=md5($accPasswd);
        $accRePasswd = $_POST['re-password'];
        $accRePasswd = md5($accRePasswd);
        $accName = $_POST["name"];
        $accMail = $_POST["e-mail"];
        
        $phone = mysqli_real_escape_string($conn, $_POST['username']);
        $passwd = mysqli_real_escape_string($conn, $_POST['password']);
        $rePasswd = mysqli_real_escape_string($conn, $_POST['re-password']);
        $name= mysqli_real_escape_string($conn, $_POST['name']);
        $email = mysqli_real_escape_string($conn, $_POST['e-mail']);
              
        if (empty($_POST["username"])) {
            $usernameErr = '* Username is required';
        } else {
                    // Kiểm tra xem số điện thoại đã đúng định dạng hay chưa 
            if (!preg_match("/^[0-9]*$/", $phone)) {
                $usernameErr = "Bạn chỉ được nhập giá trị số.";
            }
                    //Kiểm tra độ dài của số điện thoại 
            if (strlen($phone) != 10) {
                $usernameErr = "Số điện thoại phải là 10 ký tự.";
            }
        }

        if (empty($_POST["password"])) {
            $passwordErr = '* Password is required';
        } else {
            $accPasswd = mysqli_real_escape_string($conn, $_POST['password']);
            $accPasswd=md5($accPasswd);
        }

        if (empty($_POST["re-password"])) {
            $repasswordErr = '* Re-Password is required';
        } else if($passwd != $rePasswd) {
            $repasswordErr = '* Re-Password is not same Password';
            $accRePasswd ="";
        }else {
            $accRePasswd=md5($accRePasswd);
        }

        if (empty($_POST["name"])) {
            $nameErr = "Name là trường bắt buộc.";
        } else {
            $name = $_POST["name"];
                    // Kiểm tra và chỉ cho phép nhập chữ và khoảng trắng 
            if (!preg_match("/^[a-zA-Z ]*$/",$name)) {
                $nameErr = "Bạn chỉ được nhập chữ cái và khoảng trắng.";
                $accName = "";
            }
        }

        if (empty($_POST["e-mail"])) {
            $emailErr = "Email là trường bắt buộc.";
        } else {
            $email = $_POST["e-mail"];
                    // Kiểm tra email có đúng định dạng hay không 
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $emailErr = "Email không đúng định dạng.";
                $accMail = "";
            }
        }
        if($accPhone !="" && $accPasswd != "" && $accRePasswd != "" && $accName != "" && $accMail !="") {
            $query = "INSERT INTO accounts(accPhone,accPasswd,accName,accMail,accType) 
            VALUES ('$accPhone','$accPasswd','$accName','$accMail','2')";
            $result = $conn->query($query)
            or die("Query failed: " . $conn->error);
        }   
    }
?>
<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" type="text/css" href="style-register.css">
</head>
<body>
	<div class="container-register">
    <h1>Rent Car KD</h1>
	<!-- <img src="image/login.png"/> -->
		<form method="POST" action="#">
			<div class="form-input">
                <table>
                    <tr>
				        <td><input type="text" name="username" id="username" placeholder="Enter the User Name"/></td>
                        <td><span class="error"><?php echo $usernameErr; ?></span></td>
                    </tr>
                </table>
			</div>
            <div class="form-input">
                <table>
                    <tr>
                        <td><input type="password" name="password" id="password" placeholder="Enter the Password"/></td>
                        <td><span class="error"><?php echo $passwordErr; ?></span></td>
                </table>
			</div>
            <div class="form-input">
                <table>
                    <tr>
				        <td><input type="password" name="re-password" id="re-password" placeholder="Enter the Re-password"/></td>
                        <td><span class="error"><?php echo $repasswordErr; ?></span></td>
                    </tr>
                </table>	
			</div>
            <div class="form-input">
                <table>
                    <tr>
				        <td><input type="text" name="name" placeholder="Enter Name Customer"/></td>
                        <td><span class="error"><?php echo $nameErr; ?></span></td>
                    </tr>
                </table>	
			</div>
			<div class="form-input">
                <table>
                    <tr>
                        <td><input type="text" name="e-mail" placeholder="Enter Email"/></td>
                        <td><span class="error"><?php echo $emailErr; ?></span></td>
                    </tr>
                </table>
			</div>
			<input type="submit" onclick="validate()" type="submit" value="Register" class="btn-login"/>
		</form>
	</div>
    <!-- <script src="check.js"></script> -->
</body>
</html>