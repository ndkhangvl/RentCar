<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
	<title>Thông tin user</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style-user.css">
    
</head>
<body>
    <?php include "header.php" ?>
	<div class="container-login">
        
        <?php
                $oldErr = $newErr = $confirmErr = "";
                $oldPass = $newPass = $Confirm = "";
                if(isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['confirm'])){
                    require "connection.php";
                    $oldPass = $_POST['oldpass'];
                    $newPass = $_POST['newpass'];
                    $Confirm = $_POST['confirm'];
                    if (empty($oldPass)) {
                        $oldErr = '* Old pass is required';
                    } else {
                        $oldPass = md5($oldPass);
                    }
                    if (empty($newPass)) {
                        $newErr = "* New pass is required";
                    } else {
                        $newPass = md5($newPass);
                    }
                    if (empty($Confirm)) {
                        $comfirmErr = '* Confirm is required';
                    } else {
                        $Confirm = md5($Confirm);
                    }
                }
            if(isset($_SESSION['user_login'])){
                require "connection.php";
                $sql = "select * from accounts where accPhone='".$_SESSION['user_login']."'";
                $result = $conn->query($sql);
                $row=$result->fetch_assoc();
                if($_SESSION['user_type'] == 1) {
                    echo "<h1>Thông tin nhân viên</h1><br/>";
                }
                else if($_SESSION['user_type'] == 2) {
                    echo "<h1>Thông tin khách hàng</h1><br/>";
                }
                echo "<div>
                    <table class=\"user-info\">
                        <tr>
                            <td class=\"left\">Họ tên: </td>
                            <td class=\"right\">$row[accName]</td>
                        </tr>
                        <tr>
                            <td class=\"left\">Số điện thoại: </td>
                            <td class=\"right\">$row[accPhone]</td>
                        </tr>
                        <tr>
                            <td class=\"left\">Email: </td>
                            <td class=\"right\">$row[accMail]</td>
                        </tr>
                        <tr>
                            <td class=\"center\" colspan=\"2\"><br/><hr><br/></td>
                        </tr>
                    </table>
                    <table class=\"user-info\">
                        <form method=\"POST\" action=\"#\">
                            <tr>
                                <td>Mật khẩu cũ: </td>
                                <td><input type=\"password\" id=\"oldpass\" name=\"oldpass\" placeholder=\"\"/></td>
                                <td><span class=\"error\"><?php echo $oldErr; ?></span></td>
                            </tr>
                            <tr>
                                <td>Mật khẩu mới: </td>
                                <td><input type=\"password\" id=\"newpass\" name=\"newpass\" placeholder=\"\"/></td>
                                <td><span class=\"error\"><?php echo $newErr; ?></span></td>
                            </tr>
                            <tr>
                                <td>Xác nhận mật khẩu mới: </td>
                                <td><input type=\"password\" id=\"confirm\" name=\"confirm\" placeholder=\"\"/></td>
                                <td><span class=\"error\"><?php echo $confirmErr; ?></span></td>
                            </tr>
                            <tr>
                                <td class=\"center\" colspan=\"3\"><input type=\"submit\" value=\"Đổi mật khẩu\" class=\"btn-change\"/></td>
                            </tr>
                            </form>
                    </table>
                </div>";
            } else echo "<h1>Bạn chưa đăng nhập</h1>";
            
            
        ?>
	</div>
</body>
</html>