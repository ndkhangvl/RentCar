<?php
    session_start();
?>
<?php
    require "connection.php";
    $info = $typeerr = $plateerr = $fileerr ="";
    $type = $plate = $file = "";
    if (isset($_POST['cartype']) || isset($_POST['carplate']) || isset($_POST['carfile'])){

        if ($_POST['cartype'] == 0 || empty($_POST['cartype'])) {
            $typeerr = '*Please choose a type';
        } else {
            $type = $_POST['cartype'];
        }

        if (empty($_POST['carplate'])) {
            $plateerr = '*Please enter number plate';
        } else {
            $sqlchkcar = "select * from car where carNumPlate='$_POST[carplate]'";
            $resultchkcar = $conn->query($sqlchkcar) or die("Query failed: ".$conn->error);
            $rowchkcar = $resultchkcar->fetch_assoc();
            if($rowchkcar){
                $plateerr ="This number plate is exists!";
            }else
                $plate = $_POST['carplate'];
        }

        if (empty($_FILES['carfile']['name']) || getimagesize($_FILES['carfile']['tmp_name']) == false) {
            $fileerr = '*Please choose an image';
        } else if(isset($_FILES['carfile']['name']) && getimagesize($_FILES['carfile']['tmp_name']) != false) {
            $file = file_get_contents($_FILES['carfile']['tmp_name']);
            $file = addslashes($file);
            
        }

        if ($type != "" && $plate != "" && $file != ""){
            $sqlins = "insert into car(carNumPlate,typeID,carImg) values('$plate',$type,'$file')";
            $resultins = $conn->query($sqlins) or die("Query failed: ".$conn->error);
            $info ="Add car successful";
        } else $info ="Add car failed";
    }
    
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Car</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="style.css">
	<link rel="stylesheet" type="text/css" href="style-addcar.css">
</head>
<body>
    <?php include('header.php') ?>
    
    <div class="container-addcar">
        <?php
            require "connection.php";
            $sqltype = "select * from cartype";
            $resulttype = $conn->query($sqltype) or die("Query failed: ".$conn->error);
            if (isset($_SESSION['user_type'])){
                if($_SESSION['user_type'] != 1){
                    echo "<h1>You are not Staff</h1><br/>
                    Please login with Staff account to perform this function";
                }
                else {
                    
                    echo "<h1>Add Car</h1>";
                    echo "<form method=\"POST\" action=\"#\" enctype=\"multipart/form-data\">";
                        echo "<table id=\"addcar-fr\">
                            <tr>
                                <td class=\"col-1\"></td>
                                <td class=\"col-2\">Type: </td>
                                <td class=\"col-3\">
                                    <select id=\"cartype\" name=\"cartype\">
                                    <option value='0'>--Choose a Type--</option>";
                                        while($rowtype = $resulttype->fetch_assoc()){
                                            echo "<option value='$rowtype[typeID]'>$rowtype[typeName]</option>";
                                        }
                                    echo "</select>
                                </td>
                                <td class=\"col-4\">$typeerr</td>
                            </tr>
                            <tr>
                                <td class=\"col-1\"></td>
                                <td class=\"col-2\">Number Plate: </td>
                                <td class=\"col-3\"><input type=\"text\" placeholder=\"Enter number plate\" name=\"carplate\"></td>
                                <td class=\"col-4\">$plateerr</td>
                            </tr>
                            <tr>
                                <td class=\"col-1\"></td>
                                <td class=\"col-2\">Choose Image: </td>
                                <td class=\"col-3\"><input type=\"file\" name=\"carfile\"></td>
                                <td class=\"col-4\">$fileerr</td>
                            </tr>
                            <tr>
                                
                                <td class=\"col-1\" colspan=4><input type=\"submit\" value=\"Add Car\" class=\"addcar\"></td>
                                
                            </tr>
                        </table>";
                        echo "<div class=\"notification\">$info</div>";
                    echo "</form>";

                    echo "<hr><a href=\"insertcarImgform.php\">Change Image</a>";
                }
            }else echo "<h1>You are not Sign in</h1>";
        ?>
    </div>
</body>
</html>