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
    <button class="btn_create">create</button>
    <button id="btn_delete_all">delete all</button>
    <input class="create_input" id="input_title" placeholder="title">
    <input class="create_input" id="input_content" placeholder="content">
    <button class="create_input" id="send_create">send</button>

       <div class="todo_list" id="todo_list">
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
        function click_function(){
            $(document).on("click", '.btn_done',function(){
                console.log($(this).val())
                var target = $(this);
                $.ajax({
                    type: "POST",
                    dataType:"JSON",
                    url: 'api/todo/done',
                    headers: {"Authorization": "Bearer {{$token}}"},
                    data: {
                        id:$(this).val()
                    },
                    success:function(data){
                        console.log(data)
                        $('#span_t_'+target.val()).css('text-decoration','line-through');
                        $('#span_c_'+target.val()).css('text-decoration','line-through');
                        target.attr('disabled', true);
                        $('#div_'+target.val()+' .btn_upd').attr('disabled', true);
                    },
                    error: function (jqXHR, exception) {
                        console.log('error');
                        alert('授權失敗')
                        // Your error handling logic here..
                    }
                });
            })
            var upd_filter=1;
            $(document).on("click", '.btn_upd',function(){
                thisid=$(this).val();
                if(upd_filter==1){
                    console.log($(".btn_upd").val())
                    console.log('in')
                    var $input_t = $("<input>", {
                        val: $('#span_t_'+thisid).text(),
                        type: "text",
                        id:"span_t_"+$(this).val()
                    });
                    var $input_c = $("<input>", {
                        val: $('#span_c_'+thisid).text(),
                        type: "text",
                        id:"span_c_"+thisid
                    });
                    $('#span_t_'+thisid).replaceWith($input_t);
                    $('#span_c_'+thisid).replaceWith($input_c);
                    upd_filter=2;
                }
                else if(upd_filter==2){
                    var $span_t = $("<span>", {
                        text: $('#span_t_'+thisid).val(),
                        id:"span_t_"+thisid
                    });
                    var $span_c = $("<span>", {
                        text: $('#span_c_'+thisid).val(),
                        id:"span_c_"+thisid
                    });
                    $('#span_t_'+thisid).replaceWith($span_t);
                    $('#span_c_'+thisid).replaceWith($span_c);
                    upd_filter=1;
                    console.log($('#span_t_'+thisid).text())
                    console.log($('#span_c_'+thisid).text())
                    $.ajax({
                        type: "PUT",
                        dataType:"JSON",
                        url: 'api/todo/'+$(this).val(),
                        headers: {"Authorization": "Bearer {{$token}}"},
                        data:{
                            title:$('#span_t_'+thisid).text(),
                            content:$('#span_c_'+thisid).text(),
                        },
                        success:function(data){
                            console.log(data)
                        },
                        error: function (jqXHR, exception) {
                            console.log('error');
                            alert('授權失敗')
                            // Your error handling logic here..
                        }
                    });
                }
            });
            $(document).on("click", '.btn_del',function(){
                console.log($(this).val())
                var target = $(this);
                $.ajax({
                    type: "DELETE",
                    dataType:"JSON",
                    url: 'api/todo/'+$(this).val(),
                    headers: {"Authorization": "Bearer {{$token}}"},
                    success:function(data){
                        console.log(data)
                        $('#div_'+target.val()).remove();
                    },
                    error: function (jqXHR, exception) {
                        console.log('error');
                        alert('授權失敗')
                        // Your error handling logic here..
                    }
                });
            })
            $(document).on("click", '.btn_view',function(){
                console.log($(this).val())
                window.open('api/todo/view/'+$(this).val()+'?token={{$token}}','_blank');
            })
        }
        $('.btn_create').click(function(){
            $('.create_input').show();
        })
        $('#btn_delete_all').click(function(){
            $.ajax({
                type: "POST",
                dataType:"JSON",
                url: 'api/todo/delete_all',
                headers: {"Authorization": "Bearer {{$token}}"},

                success:function(data){
                    console.log(data)
                    $('#todo_list').html('');
                },
                error: function (jqXHR, exception) {
                    console.log('error');
                    alert('授權失敗')
                    // Your error handling logic here..
                }
            });
        })

        $('#send_create').click(function(){
            $.ajax({
             type: "POST",
             dataType:"JSON",
             url: 'api/todo',
             headers: {"Authorization": "Bearer {{$token}}"},
             data: {
             title:$("#input_title").val(),
             content:$("#input_content").val(),
             },
             success:function(data){
                console.log(data['data']['id']);
                 new_id=data['data']['id'];
                 var new_html='';

                 new_html='<div id="div_'+new_id+'">'+
                 '<span class="span" id="span_t_'+new_id+'">'+data['data']['title']+'</span>:<span class="span" id="span_c_'+new_id+'">'+data['data']['content']+'</span>'+
                         '<button class="btn_done" value="'+new_id+'">done</button>'+
                         '<button class="btn_upd" value="'+new_id+'">update</button>'+
                         '<button class="btn_del" value="'+new_id+'">delete</button>'+
                         '<button class="btn_view" value="'+new_id+'">view</button>'+
                         '</div>';
                 $( ".todo_list" ).append(new_html);
                 //click_function();
                 $('.create_input').hide();
                 $("#input_title").val('')
                 $("#input_content").val('')
             },
             error:function(){
             console.log('授權失敗')
             }
             });
        })

        function get_all_todo(){
            $.ajax({
                type: "GET",
                dataType:"JSON",
                url: 'api/todo',
                headers: {"Authorization": "Bearer {{$token}}"},
                success:function(data){
                   // console.log(data)
                    var todo_html='';
                    todo_list=data['todo'];
                    for(t in todo_list){
                        if(todo_list[t]['deleted_at']==null){
                            todo_html+='<div id="div_'+todo_list[t]['id']+'">';
                            if(todo_list[t]['done_at']==null){
                                todo_html+='<span class="span" id="span_t_'+todo_list[t]['id']+'">'+todo_list[t]['title']+'</span>:<span class="span" id="span_c_'+todo_list[t]['id']+'">'+todo_list[t]['content']+'</span><button class="btn_done" value="'+todo_list[t]['id']+'">done</button><button class="btn_upd" value="'+todo_list[t]['id']+'">update</button>';
                            }
                            else{
                                todo_html+='<span class="span" id="span_t_'+todo_list[t]['id']+'" style="text-decoration:line-through">'+todo_list[t]['title']+'</span>:<span class="span" id="span_c_'+todo_list[t]['id']+'" style="text-decoration:line-through">'+todo_list[t]['content']+'</span><button class="btn_done" value="'+todo_list[t]['id']+'" disabled>done</button><button class="btn_upd" value="'+todo_list[t]['id']+'" disabled>update</button>';
                            }
                            todo_html+='<button class="btn_del" value="'+todo_list[t]['id']+'">delete</button>'+'<button class="btn_view" value="'+todo_list[t]['id']+'">view</button></div>';
                        }
                    }
                    //console.log(todo_html)
                    $("#todo_list").html(todo_html)
                    click_function();
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
