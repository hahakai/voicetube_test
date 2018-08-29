<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf_token" content="{{ csrf_token() }}" />
    <title>Laravel</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">
</head>
<body>
<p>取得token</p>
<p id="token"></p>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    $.ajax({
        type: "POST",
        dataType:"JSON",
        url: 'api/auth/login',
        data: {
            email:'aa@aa.com',
            password:'123456',
        },
        success:function(data){
            console.log(data)
            $('#token').html(data['token']);
        },
        error:function(){
            console.log('授權失敗')
        }
    });
</script>
</body>
</html>
