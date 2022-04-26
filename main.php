<?php
    session_start();
?>
<!DOCTYPE html>
<html lang="vn">
<head>
    <meta charset="UTF-8">
    <title>Thuê Xe</title>
    <link rel="stylesheet" type="text/css" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
</head>
<body>
<?php include('header.php') ?>
<main id="kq" class="bg-warning" style="min-height: 10px"></main>
		<p class="spacer"> </p>	
<script>
$(document).ready(function(){
    $("a.item-a").click( function(){
        var url = this.href;
        $("main#kq").load(url);
        return false;  
    })
})
</script>
</body>
</html>