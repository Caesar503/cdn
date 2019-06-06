<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <title>商品添加</title>
</head>
<body>
    <h3>商品添加</h3>
    <hr>
    <form action="/g/" method="post" enctype="multipart/form-data">
        @csrf
        <input type="text" name="goods_name" placeholder="请输入商品名称">
        <br>
        <textarea name="goods_desc" placeholder="请输入商品简介"></textarea>
        <br>
        <input type="file" name="goods_img">
        <br>
        <input type="submit">
    </form>
</body>
</html>