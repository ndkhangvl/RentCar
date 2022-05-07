<?php session_start(); ?>
<?php 
    $oldErr = $newErr = $confirmErr = $success= "";
    $oldPass = $newPass = $Confirm = "";
    if(isset($_POST['oldpass']) && isset($_POST['newpass']) && isset($_POST['confirm'])){
        require "connection.php";
        $oldPass = $accoldpass = $_POST['oldpass'];
        $newPass = $accnewpass = $_POST['newpass'];
        $Confirm = $accconfirm = $_POST['confirm'];
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
            $confirmErr = '* Confirm is required';
        } else if ($accnewpass != $accconfirm){
            $confirmErr ='* Confirm is not same new password';
        }else $Confirm = md5($Confirm);

        if ($oldPass != "" && $newPass != "" && $Confirm != "" && $Confirm == $newPass){
            $sql = "select * from accounts where accPhone='".$_SESSION['user_login']."'AND accPasswd='".$oldPass."' limit 1";
            $result = $conn->query($sql) or die("Query failed: ".$conn->error);
            if(mysqli_num_rows($result) == 1 ) {
                $sql2 = "update accounts set accPasswd='".$newPass."' where accPhone='".$_SESSION['user_login']."'";
                $result2 = $conn->query($sql2) or die("Query failed: ".$conn->error);
                $success = 'Change password successful!';
            }else $oldErr = '* Old password is not valid';
            
        }
    }
    ?>
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
	<div class="container-user">
        
        <?php
            if(isset($_SESSION['user_login'])){
                require "connection.php";
                $sql = "select * from accounts where accPhone='".$_SESSION['user_login']."'";
                $result = $conn->query($sql);
                $row=$result->fetch_assoc();

                $sqlhistory = "select ROW_NUMBER() OVER (ORDER BY dateid) AS STT,carNumPlate,dateFrom,dateTo
                    from booking bk join car c on bk.carid=c.carid where custid=$_SESSION[user_id]";
                $resulthistory = $conn->query($sqlhistory);

                if($_SESSION['user_type'] == 1) {
                    echo "<h1>Thông tin nhân viên</h1><br/>";
                }
                else if($_SESSION['user_type'] == 2) {
                    echo "<h1>Thông tin khách hàng</h1><br/>";
                }
                echo "<div>
                    <table class=\"user-info-1\">
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
                    <table class=\"user-info-2\">
                        <form method=\"POST\" action=\"#\">
                            <tr>
                                <td class=\"left\">Mật khẩu cũ: </td>
                                <td class=\"center\"><input type=\"password\" id=\"oldpass\" name=\"oldpass\" placeholder=\"\"/></td>
                                <td class=\"right\"><span class=\"error\">$oldErr</span></td>
                            </tr>
                            <tr>
                                <td class=\"left\">Mật khẩu mới: </td>
                                <td class=\"center\"><input type=\"password\" id=\"newpass\" name=\"newpass\" placeholder=\"\"/></td>
                                <td class=\"right\"><span class=\"error\">$newErr</span></td>
                            </tr>
                            <tr>
                                <td class=\"left\">Xác nhận mật khẩu mới: </td>
                                <td class=\"center\"><input type=\"password\" id=\"confirm\" name=\"confirm\" placeholder=\"\"/></td>
                                <td class=\"right\"><span class=\"error\">$confirmErr</span></td>
                            </tr>
                            <tr>
                                <td class=\"center\" colspan=\"3\"><input type=\"submit\" value=\"Đổi mật khẩu\" class=\"btn-change\"/></td>
                            </tr>
                            </form>
                            <tr><td class=\"center\" colspan=\"3\"><span class=\"success\">$success</span></td></tr>
                    </table>";
                    if($_SESSION['user_type'] == 2) {
                        echo "<br/><hr/><br/>
                        <h1>Lịch sử thuê xe</h1>
                        <table class=\"user-info-3\">
                        <tr>
                            <th>STT</th>
                            <th>Xe</th>
                            <th>Ngày Thuê<br/>(YYYY-MM-DD)</th>
                            <th>Ngày Trả<br/>(YYYY-MM-DD)</th>
                        </tr>";
                        while ($rowhistory = $resulthistory->fetch_assoc()){
                            echo "<tr>
                                <td>$rowhistory[STT]</td>
                                <td><a class=\"seecar\" href=\"car.php?name=$rowhistory[carNumPlate]\">$rowhistory[carNumPlate]</a></td>
                                <td>$rowhistory[dateFrom]</td>
                                <td>$rowhistory[dateTo]</td>";
                                if($rowhistory['dateFrom'] > (date("Y-m-d"))){
                                    echo "<td><input type=\"button\" value=\"Xóa\"></td>";
                                }
                            echo "</tr>";
                        }
                        echo "</table><br/>";
                    }

                    

                echo "</div>";
            } else echo "<h1>Bạn chưa đăng nhập</h1>";
            
            
        ?>
	</div>
</body>
</html>