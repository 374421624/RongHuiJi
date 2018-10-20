<!DOCTYPE html>
<html lang="zh-CN">

<?PHP
include("head.php");

$q = Request("q");
$p = RequestInt("p", 1);
$prep = $p-1;
$nextp = $p+1;

# 读取接口数据
$size = 10;
$url = $search_url."/search?keyword=".urlencode($q)."&limit=$size&page=".($p);
$data = json_decode(file_get_contents($url), true);


$total = $data["count"];

?>
<body>
<div class="container">
	<div class="row">
		<div class="col-lg-10 col-md-offset-1">
		
			<div class="jumbotron">
				<form action="search.php" method="get" role="form" name="form1">
					<div class="form-group">
						<div class="input-group">
							<input type="text" class="form-control" size="50" name="q" value="<?=$q?>">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" onclick="form1.submit();">查询</button>
								</span>
						</div>
					</div>
					<div>
						<span class="label label-primary">共 <?=$total?> 条结果</span>
					</div>
				</form>
			</div>
			
			<?PHP
            for ($i = 0; $i < count($data["result"]); $i++) {
            	$id = $data["result"][$i][0];
            	$name = $data["result"][$i][1];
            	$shareholder = $data["result"][$i][2];
            	$logo = $data["result"][$i][3];
            ?>
            
            <!-- 生成搜索结果 -->
            <div class="media">
            	<div class="media-left">
            		<a href="detail.php?id=<?=$id?>">
                      <img class="media-object" src="images/logo_demo.png" alt="公司Logo">
                    </a>
            	</div>
            	<div class="media-body">
            		<h4 class="media-heading"><a href="detail.php?id=<?=$id?>"><?=$name?></a></h4>
            		<p>
            			法人：<?=$shareholder?><br>
            			公司简介：这是一个公司
            		</p>
            		
            	</div>
            </div>
            
            <?PHP
            }
            ?>
            
            <!-- 分页 -->
            <div class="pages text-center">
            	<nav aria-label="Page navigation">
            		<ul class="pagination">
                        <?PHP
                        $pages = ceil($total/$size);
                        if ($p == 1) {
                            echo "<li class=\"disabled\">
                                     <span><span aria-hidden=\"true\">&laquo</span></span>";
                        }
                        else echo "<li>
                        	      <a href=\"?q=$q&p=$prep\" aria-label=\"Next\">
                        		     <span aria-hidden=\"true\">&laquo;</span>
                        	      </a>
                              </li>";
                        echo "<li><a href=\"?q=$q\">首页</a></li>";
                        $start = $p - 4;
                        if ($start < 1) $start = 1;
                        for ($i = $start; $i < $p; $i++) {
                        	echo "<li><a href=\"?q=$q&p=$i\">$i</a></li>";
                        }
                        echo "<li class=\"active\"><span>$p<span class=\"sr-only\">(current)</span></span></li>";
                        $end = $p + 4;
                        if ($end > $pages) $end = $pages;
                        for ($i = $p+1; $i <= $end; $i++) {
                        	echo "<li><a href=\"?q=$q&p=$i\">$i</a></li>";
                        }
                        echo "<li><a href=\"?q=$q&p=$pages\">尾页</a></li>";
                        if ($p == $pages) {
                            echo "<li class=\"disabled\">
                                     <span><span aria-hidden=\"true\">&raquo</span></span>";
                        }
                        else echo "<li>
                        	      <a href=\"?q=$q&p=$nextp\" aria-label=\"Next\">
                        		     <span aria-hidden=\"true\">&raquo;</span>
                        	      </a>
                              </li>";
                        ?>
                    </ul>
                </nav>
            </div>
            
		</div>
	</div>
</div>

<?PHP
include("foot.php");
?>

<script src="master.js"></script>
</body>
</html>
