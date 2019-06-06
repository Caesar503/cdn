<!doctype html>
<html >
<head>
    <meta charset="UTF-8">
    <title>商品列表</title>
</head>
<body>
    <h3>商品展示</h3>
    <hr>
    <table>
        @method('DELETE')
        <tr>
            <td>商品id</td>
            <td>商品名称</td>
            <td>商品详情</td>
            <td>商品图片展示</td>
            <td>操作</td>
        </tr>
        @foreach($res as $k=>$v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['goods_name']}}</td>
                <td>{{$v['goods_desc']}}</td>
                <td><img src="/{{$v['goods_img']}}" height="60px"></td>
                <td><button id="tail" goods_id="{{$v['id']}}">查看详情</button>
                    <button id="delete" goods_id="{{$v['id']}}">删除</button>
                    <a href="/g/{{$v['id']}}/edit">修改</a></td>
            </tr>
            @endforeach
    </table>
</body>
<script src="/js/jquery-1.12.4.min.js"></script>
<script>
    $(function(){
        //点击详情
        $('#tail').on('click',function(){
            var id= $(this).attr('goods_id');
            $.ajax({
                url:"/g/"+id,
                method:"get",
                success:function(d){
                    console.log(d);
                }
            })
        })
        //点击删除
        $('#delete').on('click',function(){
            var id= $(this).attr('goods_id');
            $.ajax({
                url:"/g/"+id,
                {{--data:{token:"{{$token}}}"},--}}
                method:"delete",
                success:function(d){
                    console.log(d);
                }
            })
        })
    })
</script>
</html>