<?php
require "config.php";
require "PdoMysql.class.php";
session_start();
//模拟登录用户的id
$_SESSION['user_id']=2;
$pdo = new PdoMysql();
//获得url中的pid参数值(通过设置url模拟)
$pid = $_GET['pid'];
$table = 'imooc_pro';
$info = $pdo->find($table,'id='.$pid);
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>详细页-商品介绍</title>
	<link rel="stylesheet" href="css/meyer-reset.css">
	<link rel="stylesheet" href="css/main.css">
	<script src="scripts/jquery-1.12.3.min.js"></script>
	<script src="scripts/main.js"></script>
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
					<a href="cart.php" style="color:#fff" class="shop-car">购物车</a>
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
				<div class="info-img">
					<div class="img-big"><img src="images/pd-detail/pd_detail_big1.jpg" alt="ipad"></div>
					<ul class="info-img-list">
						<li class="list-item">
							<a href="#" class="list-item-link current"><img src="images/pd-detail/pd_detail_small1.jpg" alt="ipad"></a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link"><img src="images/pd-detail/pd_detail_small2.jpg" alt="ipad"></a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link"><img src="images/pd-detail/pd_detail_small3.jpg" alt="ipad"></a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link"><img src="images/pd-detail/pd_detail_small4.jpg" alt="ipad"></a>
						</li>
						<li class="list-item">
							<a href="#" class="list-item-link"><img src="images/pd-detail/pd_detail_small5.jpg" alt="ipad"></a>
						</li>
					</ul>
				</div>
				<div class="info-pd-box">
					<p class="info-pd-tit"><a href="#"><?php echo $info['pName'] ?></a></p>
					<ul class="info-pd-list">
						<li class="list-item"><span class="list-tit">市场价</span><div>
								<span class="price"><s>￥<?php echo $info['mPrice']?></s></span>
							</div></li>
						<li class="list-item"><span class="list-tit">慕课价</span><div>
							<span class="price">￥<?php echo $info['iPrice']?></span>
						</div></li>
						<li class="list-item"><span class="list-tit">优惠</span><div>
							<span class="preferential">购ipad加价优惠够配件或USB充电插座</span>
						</div></li>
						<li class="list-item"><span class="list-tit">送到</span><div>
							<a href="#" class="select-box">日照市 东港区 大学城<i></i></a><span class="other">有货，可当日出库</span>
						</div></li>
						<li class="list-item"><span class="list-tit">选择颜色</span><div>
							<span class="color"><a href="#" class="current">白色</a><a href="#">灰色</a><a href="#">黑色</a></span>
						</div></li>
						<li class="list-item">
							<span class="list-tit">选择规格</span>
							<div>
								<span class="size">
									<a href="javascript:void(0);" class="current">WIFI 16G</a>
									<a href="javascript:void(0);">WIFI 32G</a>
									<a href="javascript:void(0);">WIFI 64G</a>
									<a href="javascript:void(0);">WIFI Cellular 32G</a>
									<a href="javascript:void(0);">WIFI Cellular 64G</a>
									<a href="javascript:void(0);">WIFI Cellular 16G</a>
								</span>
							</div>
							
						</li>
						<li class="list-item"><span class="list-tit">数量</span>
							<div>
								<span class="num">
									<a href="javascript:void(0);" class="left" id="num-left-btn">-</a>
										<span id="pNum">1</span>
									<a href="javascript:void(0);" class="right" id="num-right-btn">+</a>
								</span>限购<span class="limit-num" id="limit-num"><?php echo $info['pNum'] ?></span>件
							</div>
						</li>
					</ul>
					<div class="pd-choice">已选择<a href="javascript:void(0);">“白色|WIFI 16G”</a></div>
					<div class="pd-buy">
						<a href="javascript:addCart(<?php echo $info['id'] ?>)" class="pd-add-shopCar" >加入购物车</a>
						<a href="javascript:void(0);" class="pd-buy-now">立即购买</a>
					</div>
					<span class="attention">注意：此商品可提供普通发票，不提供增值税发票。</span>
				</div>
			</div><!--dt-info结束-->
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