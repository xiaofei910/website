<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>广告-有点</title>
    <link rel="stylesheet" type="text/css" href="/css/css.css" />
    <script type="text/javascript" src="/js/jquery.min.js"></script>
    <!-- <script type="text/javascript" src="/js/page.js" ></script> -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style type="text/css">
        .paging{
            width: 100%;
            height: 80px;
            padding-top: 10px;
            text-align: center;
        }
        ul li{
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            margin-left: 15px;
        }
    </style>
</head>

<body>
<div id="pageAll">
    <div class="pageTop">
        <div class="page">
            <img src="/img/coin02.png" /><span><a href="#">首页</a>&nbsp;-&nbsp;<a
                        href="#">导航栏管理</a>&nbsp;-</span>&nbsp;查看管理
        </div>
    </div>
    <div class="page">
        <!-- banner页面样式 -->
        <div class="banner">
            <div class="add">
                <a class="addA" href="/admin/nav">添加导航&nbsp;&nbsp;+</a>
            </div>
            <!-- banner 表格 显示 -->
            <div class="banShow">
                <table border="1" cellspacing="0" cellpadding="0">
                    <tr>
                        <td width="66px" class="tdColor tdC">序号</td>
                        <td width="315px" class="tdColor">导航名称</td>
                        <td width="308px" class="tdColor">链接地址</td>
                        <td width="215px" class="tdColor">是否显示</td>
                        <td width="180px" class="tdColor">排序</td>
                        <td width="125px" class="tdColor">操作</td>
                    </tr>
                    @foreach($info as $k=>$v)
                    <tr nav_id="{{$v->id}}">
                        <td>{{$v->id}}</td>
                        <td>{{$v->name}}</td>
                        <td><a class="bsA" href="#">{{$v->url}}</a></td>
                        <td>
                            <span class="is_show">
                                @if($v->hidden == 1)
                                    是
                                @else
                                    否
                                @endif
                            </span>
                        </td>
                        <td><span class="sorts">{{$v->sorts}}</span><input type="text" value="{{$v->sorts}}" class="editsorts" style="display:none" nav_id="{{$v->id}}"></td>
                        <td><a href="/admin/updnav/{{$v->id}}"><img class="operation"
                                                          src="/img/update.png"></a> <img class="operation delban"
                                                                                         src="/img/delete.png" data-id="{{$v->id}}"></td>
                    </tr>
                    @endforeach
                </table>
                <div class="paging">{{$info->links()}}</div>
            </div>
            <!-- banner 表格 显示 end-->
        </div>
        <!-- banner页面样式end -->
    </div>

</div>


<!-- 删除弹出框 -->
<div class="banDel">
    <div class="delete">
        <div class="close">
            <a class="ok no"><img src="/img/shanchu.png" /></a>
        </div>
        <p class="delP1">你确定要删除此条记录吗？</p>
        <p class="delP2">
            <a href="#" class="ok yes" onclick="del()">确定</a><a class="ok no">取消</a>
        </p>
    </div>
</div>
<!-- 删除弹出框  end-->
</body>

<script type="text/javascript">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
//    $(document).ready(function(){
//        $(document).on('click','.delban',function(){
//            var id = $(this).data('id');
//            if(confirm('你确定要删除此条记录吗？')){
//                var url = '/admin/delnav';
//                var data={id:id};
//                $.ajax({
//                    url:url,
//                    data:data,
//                    type:'post',
//                    dataType:'json',
//                    success:function(res){
//                        if(res.code == 00000){
//                            window.location.href=res.url;
//                        }
//                    }
//                })
//            }
//        })
//    })
    $(document).ready(function(){
        $(".delban").click(function(){
            $(".banDel").show();
        });
        $(".yes").click(function(){
            var id=$(".delban").data("id");
            var url = '/admin/delnav';
//            console.log(id);
//            return false;
            var data={id:id};
            $.ajax({
                url:url,
                data:data,
                type:'post',
                dataType:'json',
                success:function(res){
                    if(res.code == 00000){
                        window.location.href=res.url;
                    }
                }
            })
        });
        $(".no").click(function(){
            $(".banDel").hide();
        });

        $(document).on('click','.sorts',function(){
            $(this).hide();
            $(this).next('input').show();

        })
        $(document).on('blur','.editsorts',function(){
            var info = $(this).val();
            var id = $(this).attr('nav_id');
//            console.log(info);return false;
            var url = '/admin/editsorts';
            var data = {info:info,id:id};
            $.ajax({
                url:url,
                data:data,
                type:'post',
                dataType:'json',
                success:function(res){
                    if(res.code == 00000){
                        window.location.href=res.url;
                    }
                }
            })
        })
        $(document).on('click','.is_show',function(){
            var info = $(this).html();
            var info = $.trim(info);
            if(info == '是'){
                var val=1;
            }else{
                var val=2;
            }
            var id = $(this).parents('tr').attr('nav_id');
            var url = '/admin/edithidden';
            var data = {val:val,id:id};
//            console.log(data);return false;
            $.ajax({
                url:url,
                data:data,
                type:'post',
                dataType:'json',
                success:function(res){
//                    console.log(res);
                    if(res.code == 00000){
                        window.location.href=res.url;

                    }
                }
            })
        })
    })
    function del(){
        var input=document.getElementsByName("check[]");
        for(var i=input.length-1; i>=0;i--){
            if(input[i].checked==true){
                //获取td节点
                var td=input[i].parentNode;
                //获取tr节点
                var tr=td.parentNode;
                //获取table
                var table=tr.parentNode;
                //移除子节点
                table.removeChild(tr);
            }
        }
    }
</script>
</html>