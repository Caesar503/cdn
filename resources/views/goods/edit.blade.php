<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品修改</title>
</head>
<body>
    <h3>商品信息修改</h3>
    <hr>
    <form action="/g/{{$res['id']}}" method="post" enctype="multipart/form-data">
        @method('PUT')
        <input type="text" name="goods_name" value="{{$res['goods_name']}}">
        <br>
        <textarea name="goods_desc" value="{{$res['goods_desc']}}"></textarea>
        <br>
        <input type="file" name="goods_img"><img src="/{{$res['goods_img']}}" height="40px">
        <br>
        <input type="submit">
    </form>
</body>
</html>