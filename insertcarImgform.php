<html>
    <a href="main.php">Return Home</a>
    <?php
        session_start();
        if (isset($_SESSION['user_type']) && $_SESSION['user_type'] == 1) {
            echo "<form method=\"POST\" action=\"insertcarImg.php\" enctype=\"multipart/form-data\">
            <input type=\"file\" name=\"img_file\"><br/>
            <input type=\"text\" name=\"carPlate\" placeholder=\"Enter car number plate\"><br/>
            <input type=\"submit\" value=\"upload\">
        </form>";
        }
        else echo "You are not Staff";
    ?>
</html>