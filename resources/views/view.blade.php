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
    <style>
        .create_input{
            display: none;
        }
    </style>
</head>
<body>
<div id="todo_list">
    {{-- <div class="">
         <span class="span" id="span_1">第一件事</span>
         <button class="btn_done" value="1">done</button>
         <button class="btn_upd" value="1">update</button>
         <button class="btn_del" value="1">delete</button>
     </div>
     <div class="">
         <span class="span" id="span_2">第2件事</span>
         <button class="btn_done" value="2">done</button>
         <button class="btn_upd" value="2">update</button>
         <button class="btn_del" value="2">delete</button>
     </div>--}}
</div>
<?PHP
$token='';
if(isset($_GET['token'])){
    $token=$_GET['token'];
}?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script>
    get_all_todo();
    function get_all_todo(){
        $.ajax({
            type: "GET",
            dataType:"JSON",
            url: '/api/todo/{{$id}}',
            headers: {"Authorization": "Bearer {{$token}}"},
            success:function(data){
                console.log(data)
                todo_html='<p><span>title:</span>'+data['todo']['title']+'</p><p><span>content:</span>'+data['todo']['content']+'</p>';
                $('#todo_list').html(todo_html)

            },
            error: function (jqXHR, exception) {
                console.log('error');
                alert('授權失敗')
                // Your error handling logic here..
            }
        });
    }
</script>
</body>
</html>
