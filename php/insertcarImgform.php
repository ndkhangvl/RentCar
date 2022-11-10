<?php
session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Change Image</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" type="text/css" href="../css/style.css">
        <link rel="stylesheet" type="text/css" href="../css/style-addcar.css">
    </head>
    <body>
        <?php include('header.php') ?>
        <div class="container-changeImg">
            <?php
                 echo "<h1>Change Car Image</h1>";
                if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
                    echo "<form method=\"POST\" action=\"insertcarImg.php\" enctype=\"multipart/form-data\">
                    <input type=\"file\" name=\"img_file\"><br/>
                    <input type=\"text\" name=\"carPlate\" placeholder=\"Enter car number plate\"><br/>
                    <input class=\"changeImg-input\" type=\"submit\" value=\"upload\">
                </form>";
                }
                else echo "You are not Staff";
            ?>
        </div>
    </body>
</html>