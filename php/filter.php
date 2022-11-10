<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../css/filter.css">
    <script src="../js/onTop.js"></script>
    <style>
        #load_data_message {
            text-align: center;
            padding: 0;
            margin: 0;
        }
        .btn-warning {
            border-radius: 4px;
            background-color: #f4511e;
            border: none;
            color: #FFFFFF;
            text-align: center;
            font-size: 28px;
            padding: 10px;
            width: 250px;
            height: 70px;
        }

        .btn-load {
            border-radius: 4px;
            background-color: #f4511e;
            border: none;
            color: #FFFFFF;
            text-align: center;
            font-size: 28px;
            padding: 10px;
            width: 250px;
            height: 70px;
        }
    </style>
</head>
<body>
    <!-- <button onclick="topFunction()" id="myBtn-top" title="Go to top">Top</button> -->
        <form action="" method="GET">
                <div class="filter-row">
                    <div class="filter">
                            <label for="">Start Price</label>
                                <input type="text" name="start_price" value="<?php if(isset($_GET['start_price'])){
                                                                                $startprice = $_GET['start_price'];
                                                                                $_SESSION['start_price']=$startprice; }else{echo "";} ?>" class="form-control">
                    </div>
                        <div class="filter">
                            <label for="">End Price</label>
                                <input type="text" name="end_price" value="<?php if(isset($_GET['end_price'])){
                                                                                 $endprice = $_GET['end_price'];
                                                                                $_SESSION['end_price']=$endprice; }else{echo "";} ?>" class="form-control">
                        </div>
                        <div class="filter">
                                <button type="submit" class="btn-filter">Filter</button>
                        </div>
                </div>
        </form>
        <div id="load_data"></div>
        <div id="load_data_message"></div>
<script>
    $(document).ready(function() {
        var limit = 3;
        var start = 0;
        var action = 'inactive';
 function load_data(limit, start)
        {
            $.ajax({ //Gui Ajax
            url:"fetch.php",
            method:"GET",
            data:{limit:limit, start:start},
            cache:false,
            success:function(data)
        {
            $('#load_data').append(data); //Neu ajax thuc hien xong neu co du lieu thi cho con khong thi khong tim thay du lieu moi
            if(data == '')
                {
                    $('#load_data_message').html("<button type='button' class='btn-load'>No Data Found</button>");
                    action = 'active';
                }
            else
                {
                    $('#load_data_message').html("<button type='button' class='btn-warning'>Please Wait</button>");
                    action = 'inactive';
                }
            
        }
        });
 }
    if(action == 'inactive')
    {
        action = 'active';
        load_data(limit, start);
    }
        $(window).scroll(function(){ //Khi keo scroll thi xu ly
            //Neu man hinh dang o duoi cung cuoi the thi thuc hien AJAX
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
                {
                    action = 'active';
                    start = start + limit;
                    setTimeout(function(){ load_data(limit, start);}, 1000); //Thoi gian doi load trang la 1s 
                }
        });
 });
</script>
</body>
</html>