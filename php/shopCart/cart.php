<?php
session_start();
require "config.php";
require "PdoMysql.class.php";
$userId = $_SESSION['user_id'];
$pdo = new PdoMysql();
$sql = "select c.pId,c.uId,c.num,c.price,p.pName,p.mPrice from imooc_pro_cart c left join imooc_pro p on c.pId = p.id where uId=".$userId;
$result = $pdo->fetchAll($sql);
$sql = "select sum(price*num) total from imooc_pro_cart where uId=".$userId;
$result1 = $pdo->getRow($sql);
?>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>购物车</title>
	<link rel="stylesheet" href="css/meyer-reset.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="scripts/jquery-1.12.3.min.js"></script>
	<script src="scripts/main.js"></script>
    <style>
        .title {
            height: 30px;
            background: #bbbbbb;
            padding-left: 5px;
            color: #333;
            line-height: 30px;
        }
        table {
            width:1000px;
        }
        table th {
            color:#666;
            text-align: center;
            border:1px solid #f1f1f1;

        }
        table td{
            font-size:14px;
            padding:10px 0;
            text-align: center;
            border:1px solid #f1f1f1;
        }
        .product-name{
            display: inline-block;
            width:160px;
            height:60px;
            overflow: hidden;
        }
        .num-text{
            width:40px;
            height:30px;
            border:1px solid #f1f1f1;
            text-align:center;
        }
        .cart-buttom{
            height:40px;
            font-size:14px;
            color:#666;
            line-height:40px;
            border:1px solid #f1f1f1;
            margin-top:10px;
            padding:0 10px;
        }
        .left{
            float: left;
        }
        .right{
            float: right;
        }
        .btn{
            margin-top:20px;
            padding:0 10px;
        }
        .button{
            width:80px;
            height:30px;
            background:#fff;
            font-size:14px;
            line-height:30px;
            text-align: center;
            color:#444;
            border-radius:5px;
        }
        .button:hover{
            background:#bbbbbb;
        }

    </style>
</head>
<body>
	<div id="show"></div>
	<header class="header">
		<div class="top">
			<div class="inner-center">
				<div class="top-left">
					<a href="#">收藏慕课</a>
				</div>
				<div class="top-right">
欢迎来到慕课！ <a href="#">[登入]</a><a href="#">[免费注册]</a>
				</div>
			</div>
		</div><!--top结束-->
		<div class="logo-search">
			<div class="inner-center">
				<div class="logo">
					<a href="#"><img src="images/img_logo.jpg" alt="慕课网"></a>
				</div>
				<div class="search">
					<input type="text" class="search-txt"><input type="text" class="search-btn" value="搜索">
				</div>
				<div class="shop">
					<span class="shop-car">购物车</span>
					<span class="shop-num">0</span>
				</div>
			</div>
		</div><!--logo-search结束-->
		<nav class="nav">
			<div class="inner-center">
				<div class="shop-class">
					<h1><a href="#">全部商品分类</a></h1>
				</div>
				<ul class="nav-list">
					<li><a href="#">数码城</a></li>
					<li><a href="#">天黑黑</a></li>
					<li><a href="#">团购</a></li>
					<li><a href="#">发现</a></li>
					<li><a href="#">二手特卖</a></li>
					<li><a href="#">名品会</a></li>
				</ul>
			</div>
		</nav><!--nav结束-->
	</header>
	<div class="detail-wrap">
		<div class="inner-center">
			<div class="detail-top"><a href="#">首页</a>&nbsp;&gt;&nbsp;<a href="#">平板电脑</a>&nbsp;&gt;&nbsp;<a href="#">平板电脑</a>&nbsp;&gt;&nbsp;<a href="#">Apple 苹果</a>&nbsp;&gt;&nbsp;<a href="#">MD531CH/A</a></div>
			    <div class="dt-info">
                    <div class="title">商品列表</div>
                        <table>
                            <thead>
                                <tr>
                                    <th width="20%">商品名称</th>
                                    <th>市场价格</th>
                                    <th>本店价格</th>
                                    <th>数量</th>
                                    <th>小计</th>
                                    <th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($result as $value): ?>
                                <tr id="product-<?php echo $value['pId'] ?>" class="product">
                                    <td ><span class="product-name" title="<?php echo $value['pName']?>"><?php echo $value['pName']?></span></td>
                                    <td>&yen;<?php echo $value['mPrice']?>元</td>
                                    <td>&yen;<span id="price-<?php echo $value['pId']?>"><?php echo $value['price'] ?></span>元</td>
                                    <td><input type="text" name="num" id="" value="<?php echo $value['num'] ?>" class="num-text"
                                               onblur="changeNum(<?php echo $value['pId']?>,this.value)"></td>
                                    <td>&yen;<span id="total-<?php echo $value['pId']?>"><?php echo $value['price']*$value['num'] ?></span>元</td>
                                    <td><a href="javascript:void(0);" onclick="delProduct(<?php echo $value['pId']?>)">删除</a></td>

                                </tr>
                                <?php endforeach ?>
                            </tbody>
                        </table>
                    <div class="cart-buttom"><span class="left">购物金额小计: &yen;<span id="allTotal"><?php echo $result1['total'] ?></span>元</span><span class="right"><a href="javascript:void(0)" onclick="delAll()">清空购物车</a></span></div>

                </div><!--dt-info结束-->
            <div class="btn"><div class="left button">继续购物</div> <div class="right button">结算中心</div></div>

        </div>
        </div>

<footer>
    <div class="inner-center">
        <p class="footer-nav">
            <a href="#">慕课简介</a> |
            <a href="#">慕课公告</a> |
            <a href="#">招纳贤士</a> |
            <a href="#">联系我们</a> |
            <span>客服热线：400-675-1234</span>
        </p>
        <p class="copyright">Copyright &copy; 2006 - 2014 慕课版权所有   京ICP备09037834号   京ICP证B1034-8373号   某市公安局XX分局备案编号：123456789123</p>

        <a href="#"><img src="images/icon_licence.jpg" alt="licence"></a>
        <a href="#"><img src="images/icon_licence.jpg" alt="licence"></a>
        <a href="#"><img src="images/icon_licence.jpg" alt="licence"></a>
        <a href="#"><img src="images/icon_licence.jpg" alt="licence"></a>

    </div>
</footer>
</body>
</html>