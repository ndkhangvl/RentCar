<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="filter.css">
    <style>
        #load_data_message {
            text-align: center;
            padding: 0;
            margin: 0;
        }
        .btn-warning {
            background-color: yellow;
            font-size: 30px;
        }
    </style>
</head>
<body>
        <div id="load_data"></div>
        <div id="load_data_message"></div>

<script>
    $(document).ready(function() {
        var limit = 3;
        var start = 0;
        var action = 'inactive';
 function load_data(limit, start)
        {
            $.ajax({
            url:"fetch-unlogin.php",
            method:"GET",
            data:{limit:limit, start:start},
            cache:false,
            success:function(data)
        {
            $('#load_data').append(data);
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
        $(window).scroll(function(){
            if($(window).scrollTop() + $(window).height() > $("#load_data").height() && action == 'inactive')
                {
                    action = 'active';
                    start = start + limit;
                    setTimeout(function(){ load_data(limit, start);}, 1000);
                }
        });
 });
</script>
</body>
</html>