<?PHP
require_once("config.php");
require_once("utils.php");
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>融汇吉，融资信息一目了然</title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<link rel="icon" href="">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="bootstrap-3.3.7-dist/css/bootstrap-theme.min.css">
	<link rel="stylesheet" href="css/bootstrap-table.min.css">
	<link rel="stylesheet" href="master.css">
	<script src="jquery-3.3.1.min.js"></script>
    <script src="bootstrap-3.3.7-dist/js/bootstrap.min.js"></script>
    <script src="js/bootstrap-table.min.js"></script>
    <script src="master.js"></script>
	<script src="echarts.js"></script>
</head>
<body>
	<nav class="navbar navbar-default navbar-fixed-top" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<a class="navbar-brand" href="index.php">
					<img alt="Brand" style="max-width:35px; margin-top:-7px" src="images/brand_demo.png">
				</a>
			</div>
			<div id="navbar" class="collapse navbar-collapse">
				<ul class="nav navbar-nav navbar-right">
					<li><a href="#" data-toggle="modal" data-target="#register">
						<span class="glyphicon glyphicon-user"></span> 注册</a>
					</li>
					<li><a href="#" data-toggle="modal" data-target="#login">
						<span class="glyphicon glyphicon-log-in"></span> 登陆</a>
					</li>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="ture" aria-expanded="false">
						中文版
						<span class="caret"></span>
						</a>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#">英文版</a></li>
						</ul>
					</li>
					<li><a href="#" id="app" data-toggle="popover" data-placement="bottom">APP下载</a></li>
					<li><a href="#" id="wechatOA" data-toggle="popover" data-placement="bottom">公众号</a></li>
				</ul>
			</div>
		</div>
	</nav>

	<div class="modal fade" id="login" aria-labelledby="loginLabel">
		<div class="modal-dialog">
			<div class="modal-content">
        		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal">
        				<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        			</button>
        			<h3 class="modal-title" id="loginLabel">登陆</h3>
        		</div>
        		<div class="modal-body">
	                <form role="form" action="" method="post" class="registration-form">
	                    <div class="form-group">
							<label for="">用户名</label>
							<input type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label for="">密码</label>
							<input type="password" class="form-control" placeholder="">
						</div>
						<div class="text-right">
							<a href="">忘记密码？</a>
						</div>
						<br>
						<button class="btn btn-primary btn-block" type="submit">登陆</button>
	                   </form>
        		</div>
        	</div>
		</div>
	</div>

	<div class="modal fade" id="register" tabindex="-1" aria-labelledby="registerLabel">
		<div class="modal-dialog">
			<div class="modal-content">
        		<div class="modal-header">
        			<button type="button" class="close" data-dismiss="modal">
        				<span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
        			</button>
        			<h3 class="modal-title" id="registerLabel">注册</h3>
        		</div>
        		<div class="modal-body">
	                <form role="form" action="" method="post" class="registration-form">
	                    <div class="form-group">
							<label for="">用户名</label>
							<input type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label for="">密码</label>
							<input type="password" class="form-control" placeholder="">
						</div>
						<div class="text-right">
							<a href="">已有账号？点我登陆</a>
						</div>
						<br>
						<button class="btn btn-primary btn-block" type="submit">注册</button>
	                   </form>
        		</div>
        	</div>
		</div>
	</div>
	
</body>
</html>