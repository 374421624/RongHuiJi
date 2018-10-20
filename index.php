<!DOCTYPE html>
<html lang="zh-CN">

<?PHP
include("head.php");
?>

<body>

<div id="page1">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-md-offset-1">
                <div class="jumbotron">
                    <h2 class="text-center" style="margin-top: 0px">融汇吉，融资信息一目了然</h2>
                    <div class="submain">
                        <span class="line"></span>
                        <span class="txt">RONG HUI JI</span>
                        <span class="line"></span>
                    </div>
                    <form action="search.php" method="get" role="form" name="form1">
                        <div class="form-group">
                            <div class="input-group">
                                <input type="text" class="form-control" size="50" name="q" placeholder="请输入内容(企业关键词）">
                                <span class="input-group-btn">
    									<button class="btn btn-default" type="button"
                                                onclick="form1.submit();">查询</button>
    								</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="page2">
    <div class="container">
        <div class = "text-center">
            <h2>新闻资讯</h2>
            <h2>————————————</h2>
        </div>
        <div class="row">
            <div class="col-lg-10 col-md-offset-1">
                <div class="col-lg-4">
                    <div class="img-box text-center">
                        <a href="#">
                            <div class="thumbnail">
                                <img src="images/1.jpg" alt="...">
                                <div class="caption">
                                    <h3>炉石要出新卡包了！</h3>
                                    <p>不信点进来看</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="img-box text-center">
                        <a href="#">
                            <div class="thumbnail">
                                <img src="images/1.jpg" alt="...">
                                <div class="caption">
                                    <h3>炉石要出新卡包了！</h3>
                                    <p>不信点进来看</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="img-box text-center">
                        <a href="#">
                            <div class="thumbnail">
                                <img src="images/1.jpg" alt="...">
                                <div class="caption">
                                    <h3>炉石要出新卡包了！</h3>
                                    <p>不信点进来看</p>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center">
            <button type="button" class="btn btn-default btn-lg text-center">
                <span class="glyphicon glyphicon-hand-right" aria-hidden="true"></span> 更多资讯
            </button>
        </div>
    </div>
</div>

<?PHP
include("foot.php");
?>


<script src="master.js"></script>
</body>
</html>