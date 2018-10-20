<!DOCTYPE html>
<html lang="zh-CN">

<?PHP
	include("head.php");

	$id = Request("id");

	# 读取接口数据
	$url_baseinfo = $base_url."/api1/baseinfo?c_id=$id";
	$url_holders = $base_url."/api1/holders?c_id=$id";
	$url_managers = $base_url."/api1/managers?c_id=$id";
	$url_financingInfo = $base_url."/api1/financing_info_0729?c_id=$id";
	$url_changeinfo = $base_url."/api1/changeinfo?c_id=$id";
	$url_business_info = $base_url."/api1/business?c_id=$id";

	$baseinfo_data = json_decode(file_get_contents($url_baseinfo), true);
	$holder_data = json_decode(file_get_contents($url_holders), true);
	$manager_data = json_decode(file_get_contents($url_managers), true);
	$financingInfo_data = json_decode(file_get_contents($url_financingInfo), true);
	$changeinfo_data = json_decode(file_get_contents($url_changeinfo), true);
	$business_info_data = json_decode(file_get_contents($url_business_info), true);

	$gid = $financingInfo_data["g_id"];
	$url_financingGroupInfo = $base_url."/api1/financing_group_info_0729?g_id=$gid";
	$financingGroupInfo_data = json_decode(file_get_contents($url_financingGroupInfo), true);
?>

<head>
	<style type="text/css">
	#myScrollspy ul.nav-tabs{
        width: 140px;
        margin-top: 20px;
        border-radius: 4px;
        border: 1px solid #ddd;
        box-shadow: 0 1px 4px rgba(0, 0, 0, 0.067);
    }
    #myScrollspy ul.nav-tabs li{
        margin: 0;
        border-top: 1px solid #ddd;
    }
    #myScrollspy ul.nav-tabs li:first-child{
        border-top: none;
    }
    #myScrollspy ul.nav-tabs li a{
        margin: 0;
        padding: 8px 16px;
        border-radius: 0;
    }
    #myScrollspy ul.nav-tabs li.active a, ul.nav-tabs li.active a:hover{
        color: #fff;
        background: #0088cc;
        border: 1px solid #0088cc;
    }
    #myScrollspy ul.nav-tabs li:first-child a{
        border-radius: 4px 4px 0 0;
    }
    #myScrollspy ul.nav-tabs li:last-child a{
        border-radius: 0 0 4px 4px;
    }
    #myScrollspy ul.nav-tabs.affix{
        top: 50px; /* Set the top position of pinned element */
    }
	.anchor {
		/*display: block;
		position: relative;
		top: 10px;
		visibility: hidden;*/
		padding-top: 60px;
	}
	</style>
</head>

<body data-spy="scroll" data-target="#myScrollspy">

<div class="container">
	<div class="page-header" style="margin-top: 0px">
		<h1>公司详情</h1>
	</div>
	
	<div class="row"> 
        
        <!-- Nav tabs -->
        <ul class="nav nav-tabs" role="tablist">
          <li role="presentation" class="active"><a href="#redian" aria-controls="redian" role="tab" data-toggle="tab">热点</a></li>
          <li role="presentation"><a href="#ronghuiku" aria-controls="ronghuiku" role="tab" data-toggle="tab">融汇库</a></li>
          <li role="presentation"><a href="#shiyongban" aria-controls="shiyongban" role="tab" data-toggle="tab">企业试用版</a></li>
          <li role="presentation"><a href="#baoliao" aria-controls="baoliao" role="tab" data-toggle="tab">我要爆料</a></li>
        </ul>
        
        <!-- Tab panes -->
        <div class="tab-content">
         	<div role="tabpanel" class="tab-pane active" id="redian">	
        	  	
        	</div>
          	<div role="tabpanel" class="tab-pane" id="ronghuiku">	
        		
        	</div>
          	<div role="tabpanel" class="tab-pane" id="shiyongban">
              	<div class="col-lg-10">
              		<div class="anchor" id="introduction">
              			<h2>公司简介</h2>
                		<p>公司名称：<?=$baseinfo_data["name"]?></p>
                		<p>地址：<?=$baseinfo_data["reg_address"]?></p>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseIntroduction">详情</button>
                		<div class="collapse" id="collapseIntroduction">
                            <div class="well">
                                ...
                            </div>
                        </div>
            		</div>
            		
            		<div class="anchor" id="shareholder">
            			<h2>股东信息</h2>	
            			<p>第一大股东：<?=$holder_data["holder"]["name"]?></p>
            			<p>占比：<?=$holder_data["holder"]["rate"]?></p>


                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseShareholder">详情</button>
                		<div class="collapse" id="collapseShareholder">
                            <div class="well">
							<div id="main" style="width: 900px; height:400px;"></div>
            			<script type="text/javascript">
            				// 基于准备好的dom，初始化echarts实例
            				var myChart = echarts.init(document.getElementById('main'));
            
            				
            				// 指定图表的配置项和数据
            				var data = genData(50);
            
            				option = {
            					title : {
            						text: '所有股东投资占比',
            						x:'center'
            					},
            					tooltip : {
            						trigger: 'item',
            						formatter: "{a} <br/>{b} : {d}%"
            					},
            					legend: {
            						type: 'scroll',
            						right: 10,
            						top: 20,
            						bottom: 20,
            						data: data.legendData,
            					},
            					series : [
            						{
            							name: '股东',
            							type: 'pie',
            							radius : '55%',
            							center: ['40%', '50%'],
            							data: data.seriesData,
            							itemStyle: {
            								emphasis: {
            									shadowBlur: 10,
            									shadowOffsetX: 0,
            									shadowColor: 'rgba(0, 0, 0, 0.5)'
            								}
            							}
            						}
            					]
            				};
            
            
            
            
            				function genData(count) {
            					var holder_data_local = <?= json_encode($holder_data); ?>;
            					var legendData = [];
            					var seriesData = [];
            					var total = 0;
            					for (var i = 0; i < holder_data_local["holders"].length; i++) {
            						name = holder_data_local["holders"][i]["name"];
            						legendData.push(name);
            						seriesData.push({
            							name: name,
            							value: valueConv(holder_data_local["holders"][i]["rate"])
            						});
            						total += valueConv(holder_data_local["holders"][i]["rate"]);
            					}
            					if(total != 1){
            						seriesData.push({
            							name: "其它",
            							value: 1- total
            						});
            					}
            
            					return {
            						legendData: legendData,
            						seriesData: seriesData,
            					};
            
            					function valueConv(valueOri) {
            						var value = parseFloat(valueOri.replace("%", "")) / 100;
            						return value;
            					}
            				}
            
            				// 使用刚指定的配置项和数据显示图表。
            				myChart.setOption(option);
            			</script>
            			
            			<div id="table_1" class="table-responsive">
            				<table class = "table table-striped table-hover">
            					<tr>
            						<th>序号</th>
            						<th>股东名称</th>
            						<th>企业类型</th>
            						<th>股权占比</th>
            					</tr>
            					<?php 
            					for ($i = 0; $i < count($holder_data["holders"]); $i++) {
            					    $name = $holder_data["holders"][$i]["name"];
            					    $rate = $holder_data["holders"][$i]["rate"];
            					?>
            					
            					<tr>
            						<td><?=$i+1?></td>
            						<td><?=$name?></td>
            						<td>-</td>
            						<td><?=$rate?></td>
            					</tr>
            					
            					<?php	
            					}
            				    ?>
            				</table>
            			</div>
            			
            		</div>

                            </div>
                        </div>
            
            
            		<div class="anchor" id="history">
            			<h2>历史沿革</h2>
            			<p>公司成立于：<?=$baseinfo_data["estab_date"]?></p>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseHistory">详情</button>
                		<div class="collapse" id="collapseHistory">
                            <div class="well">
							<p>变更信息：<br>
								<?php
								$num = count($changeinfo_data["changeinfos"]);
								for($i = 0;$i<$num;$i++){
									$changedate = $changeinfo_data['changeinfos'][$i]['time'];
									echo "变更时间：",$changedate;
									?>
									<p>—————————————————————————————————</p>
									<?php
									$item = $changeinfo_data['changeinfos'][$i]['item'];
									echo "变更类型：",$item;
									?>
									<br>
									<?php
									$before = $changeinfo_data['changeinfos'][$i]['before'];
									echo "变更前:";?><br><?php
									echo $before;
									?><br><?php
									$after = $changeinfo_data['changeinfos'][$i]['after'];
									echo "变更后：";?><br><?php
									echo $after;?><br><br><?php
								}
								?>
						</p>

                            </div>
                        </div>
            		</div>
            
            
            		<div class="anchor" id="manager">
            			<h2>高管信息</h2>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseManager">详情</button>
                		<div class="collapse" id="collapseManager">
                            <div class="well">
							<p>
            				<?php 
            					for ($i = 0; $i < count($manager_data["managers"]); $i++) {
									$name = $manager_data["managers"][$i]["name"];
									echo "高管：",$name;
									?>
									<br>
									<?php
									$post = $manager_data["managers"][$i]["post"];
									echo "职位：",$post;?>
									<p>——————————————————————————————————</p>
									<?php
									$abstract = $manager_data["managers"][$i]["abstract"];
									if($abstract == ''){
										echo "简介：无。";
									}
										else{
										echo "简介：".$abstract;
									}
									?>
									<br><br>
									<?php
            						/*echo "$name";
            						if ($i != count($manager_data["managers"])-1){
            							echo "、";
            						}*/
            					}
            				?>
            			</p>

                            </div>
                        </div>
            		</div>
            
            
            		<div class="anchor" id="operate">
            			<h2>生产经营情况</h2>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseOperate">详情</button>
                		<div class="collapse" id="collapseOperate">
                            <div class="well">
							<?php
							//最近一期
							$last_deadline = $business_info_data["year"];
							$last_operate_rev_YOY = $business_info_data["operate_rev_YOY"];
							$last_operate_rev = $business_info_data["operate_rev"];
							$last_profit = $business_info_data["profit"];
							$last_profit_YOY = $business_info_data["profit_YOY"];
							$num = count($business_info_data['key_business_3_year'][0]['data']);
							//按比例判断最大主营业务
							$max_profit = $business_info_data['key_business_3_year'][0]['data'][0][4];
							echo "公司主营业务分为";
							//产品业务输出
							for($j = 0;$j<count($business_info_data['key_business_3_year'][0]['data']);$j++){
								if($business_info_data['key_business_3_year'][0]['data'][$j][1]=="产品"){
									echo $business_info_data['key_business_3_year'][0]['data'][$j][2],"，";
									//查找最大主营业务编号
									$select_max = $business_info_data['key_business_3_year'][0]['data'][$j][4];
									if($select_max>$max_profit){
										$max = $j;
										
									}
								}	
							}
							echo "等几个板块，",$last_deadline,"年实现了营业额",$last_operate_rev,"元人民币，同比增长",$last_operate_rev_YOY,"，实现了利润总额",$last_profit,"元人民币。同比增长",$last_profit_YOY,"，主营业务中",$business_info_data['key_business_3_year'][0]['data'][$max][2],"占比较大的业务板块。占比",$business_info_data['key_business_3_year'][0]['data'][$max][4],"。";
						?>

						<h3 style = 'color:red;text-align:center'>根据地区划分前三年生产经营情况</h3>


							<div id="main2" style="width: 900px; height:400px;"></div>
							<script type="text/javascript">
								// 基于准备好的dom，初始化echarts实例
								var myChart = echarts.init(document.getElementById('main2'));
								// 指定图表的配置项和数据
								var data = genData(50);

								option = {
									title : {
										text: '按地区前三年情况',
										x:'center'
									},
									tooltip : {
										trigger: 'item',
										formatter: "{a} <br/>{b} : {d}%"
									},
									legend: {
										type: 'scroll',
										//orient: 'vertical',
										right: 10,
										top: 20,
										bottom: 20,
										data: data.legendData,
									},
									series : [
										{
											name: '地区',
											type: 'pie',
											radius : '55%',
											center: ['40%', '50%'],
											data: data.seriesData,
											itemStyle: {
												emphasis: {
													shadowBlur: 10,
													shadowOffsetX: 0,
													shadowColor: 'rgba(0, 0, 0, 0.5)'
												}
											}
										}
									]
								};

								function genData(count) {
									var business_data_local = <?= json_encode($business_info_data); ?>;
									var legendData = [];
									var seriesData = [];
									var total = 0;
									for (var i = 0; i < business_data_local['key_business_3_year'][0]['data'].length; i++) {
										if(business_data_local['key_business_3_year'][0]['data'][i][1]=='地区'){
											name = business_data_local['key_business_3_year'][0]['data'][i][2];
											legendData.push(name);
											seriesData.push({
												name: name,
												value: valueConv(business_data_local['key_business_3_year'][0]['data'][i][4])
											});
											total += valueConv(business_data_local['key_business_3_year'][0]['data'][i][4]);
										}
									}
									if(total != 1){
										seriesData.push({
											name: "其它",
											value: 1- total
										});
									}

									return {
										legendData: legendData,
										seriesData: seriesData,
									};

									function valueConv(valueOri) {
										var value = parseFloat(valueOri.replace("%", "")) / 100;
										return value;
									}
								}

								// 使用刚指定的配置项和数据显示图表。
								myChart.setOption(option);
							</script>



						<p>分类依据：地区</p>
						<div id="table_3" class="table-responsive">
            				<table class = "table table-striped table-hover">
            					<tr>
            						<th>截止日期</th>
            						<th>主营构成</th>
            						<th>主营收入</th>
            						<th>收入比例</th>
									<th>主营成本</th>
									<th>成本比例</th>
									<th>主营利润</th>
									<th>利润比例</th>
									<th>主营利润率</th>
            					</tr>
								<?php
								$s = count($business_info_data['key_business_3_year'][0]['data']);
								//最近三年
								for($i=0;$i<$s;$i++){
									//每一个年份
									if($business_info_data['key_business_3_year'][0]['data'][$i][1]=="地区"){
										$each =  $business_info_data['key_business_3_year'][0]['data'][$i];
										$deadline = $each[0];
										$fenlei = $each[1];
										$goucheng = $each[2];
										$shouru = $each[3];
										$shourubili = $each[4];
										$chengben = $each[5];
										$chengbenbili = $each[6];
										$lirun = $each[7];
										$lirunbili = $each[8];
										$maolilv = $each[9];
									?>
									<tr>
										<td><?=$deadline?></td>
										<td><?=$goucheng?></td>
										<td><?=$shouru?></td>
										<td><?=$shourubili?></td>
										<td><?=$chengben?></td>
										<td><?=$chengbenbili?></td>
										<td><?=$lirun?></td>
										<td><?=$lirunbili?></td>
										<td><?=$maolilv?></td>
									</tr>
									<?php
									
									}
								}	
								?>
							</table>
						</div>
						<h3 style = 'color:red;text-align:center'>根据产品划分前三年生产经营情况</h3>
						<div id="main3" style="width: 900px; height:400px;"></div>
							<script type="text/javascript">
								// 基于准备好的dom，初始化echarts实例
								var myChart = echarts.init(document.getElementById('main3'));
								// 指定图表的配置项和数据
								var data = genData(50);

								option = {
									title : {
										text: '按产品前三年情况',
										x:'center'
									},
									tooltip : {
										trigger: 'item',
										formatter: "{a} <br/>{b} : {d}%"
									},
									legend: {
										type: 'scroll',
										//orient: 'vertical',
										right: 10,
										top: 20,
										bottom: 20,
										data: data.legendData,
									},
									series : [
										{
											name: '产品',
											type: 'pie',
											radius : '55%',
											center: ['40%', '50%'],
											data: data.seriesData,
											itemStyle: {
												emphasis: {
													shadowBlur: 10,
													shadowOffsetX: 0,
													shadowColor: 'rgba(0, 0, 0, 0.5)'
												}
											}
										}
									]
								};

								function genData(count) {
									var business_data_local = <?= json_encode($business_info_data); ?>;
									var legendData = [];
									var seriesData = [];
									var total = 0;
									for (var i = 0; i < business_data_local['key_business_3_year'][0]['data'].length; i++) {
										if(business_data_local['key_business_3_year'][0]['data'][i][1]=='产品'){
											name = business_data_local['key_business_3_year'][0]['data'][i][2];
											legendData.push(name);
											seriesData.push({
												name: name,
												value: valueConv(business_data_local['key_business_3_year'][0]['data'][i][4])
											});
											total += valueConv(business_data_local['key_business_3_year'][0]['data'][i][4]);
										}
									}
									if(total != 1){
										seriesData.push({
											name: "其它",
											value: 1- total
										});
									}

									return {
										legendData: legendData,
										seriesData: seriesData,
									};

									function valueConv(valueOri) {
										var value = parseFloat(valueOri.replace("%", "")) / 100;
										return value;
									}
								}

								// 使用刚指定的配置项和数据显示图表。
								myChart.setOption(option);
							</script>

						<p>分类依据：产品</p>
						<div id="table_4" class="table-responsive">
            				<table class = "table table-striped table-hover">
            					<tr>
            						<th>截止日期</th>
            						<th>主营构成</th>
            						<th>主营收入</th>
            						<th>收入比例</th>
									<th>主营成本</th>
									<th>成本比例</th>
									<th>主营利润</th>
									<th>利润比例</th>
									<th>主营利润率</th>
            					</tr>
								<?php
								$s = count($business_info_data['key_business_3_year'][0]['data']);
								//最近三年
								for($i=0;$i<$s;$i++){
									if($business_info_data['key_business_3_year'][0]['data'][$i][1]=="产品"){
									//每一个年份
										$each =  $business_info_data['key_business_3_year'][0]['data'][$i];
										$deadline = $each[0];
										$goucheng = $each[2];
										$shouru = $each[3];
										$shourubili = $each[4];
										$chengben = $each[5];
										$chengbenbili = $each[6];
										$lirun = $each[7];
										$lirunbili = $each[8];
										$maolilv = $each[9];
									?>
									<tr>
										<td><?=$deadline?></td>
										<td><?=$goucheng?></td>
										<td><?=$shouru?></td>
										<td><?=$shourubili?></td>
										<td><?=$chengben?></td>
										<td><?=$chengbenbili?></td>
										<td><?=$lirun?></td>
										<td><?=$lirunbili?></td>
										<td><?=$maolilv?></td>
									</tr>
									<?php
									
									
									}
								}
							?>
							</table>
						</div>

                            </div>
                        </div>
            		</div>
            
            
            		<div class="anchor" id="finance">
            			<h2>财务情况</h2>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseFinance">详情</button>
                		<div class="collapse" id="collapseFinance">
                            <div class="well">
                                ...
                            </div>
                        </div>
            		</div>
            
            
            		<div class="anchor" id="financing">
            			<h2>融资情况</h2>
						<?PHP
							$totalCredit = $financingGroupInfo_data["credit_total"][0]["amount"] / 10000;
							//集团总授信，单位亿元
							$usedCredit = $financingGroupInfo_data["credit_total"][0]["used"] / 10000;
							//集团已使用授信，单位亿元
							$unusedCredit = $financingGroupInfo_data["credit_total"][0]["unused"] / 10000;
							//集团未使用授信，单位亿元
							echo "总授信", $totalCredit, "亿元，", "已使用授信", $usedCredit, "亿元，", "未使用授信", $unusedCredit, "亿元。";



							$restBond = $financingGroupInfo_data["bond_total"]["rest"];
							//集团及其子公司存量债券，单位亿元
							$debtShortterm = $financingGroupInfo_data["debt"]["last"][1] / 100000000;
							//集团及其子公司短期借款，单位亿元
							$debtLongterm = $financingGroupInfo_data["debt"]["last"][4] / 100000000;
							//集团及其子公司长期借款，单位亿元
							$totalStockValue = $financingGroupInfo_data["share_financing_total"]["total"];
							//发行股票募集资金，单位亿元
							echo "集团及其子公司存量债券", $restBond, "亿元，", "短期借款", $debtShortterm, "亿元，", "长期借款", $debtLongterm, "亿元，", "发行股票募集资金", $totalStockValue, "亿元。";


							echo "合作银行前十名：";
							for ($i = 0; ($i < count($financingGroupInfo_data["credit_detail"])) && ($i < 10); $i++){
								echo $financingGroupInfo_data["credit_detail"][$i]["bank"];
								if($i != (count($financingGroupInfo_data["credit_detail"]) - 1) && $i != 9)echo "、";
							}
							echo "。";
						?>

                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseFinancing">详情</button>
                		<div class="collapse" id="collapseFinancing">
                            <div class="well">
							<h3>1. 集团融资概览</h3>
						<?PHP
							$totalCredit = $financingGroupInfo_data["credit_total"][0]["amount"] / 10000;
							//集团总授信，单位亿元
							$usedCredit = $financingGroupInfo_data["credit_total"][0]["used"] / 10000;
							//集团已使用授信，单位亿元
							$unusedCredit = $financingGroupInfo_data["credit_total"][0]["unused"] / 10000;
							//集团未使用授信，单位亿元
							echo "总授信", $totalCredit, "亿元，", "已使用授信", $usedCredit, "亿元，", "未使用授信", $unusedCredit, "亿元。";



							$restBond = $financingGroupInfo_data["bond_total"]["rest"];
							//集团及其子公司存量债券，单位亿元
							$debtShortterm = $financingGroupInfo_data["debt"]["last"][1] / 100000000;
							//集团及其子公司短期借款，单位亿元
							$debtLongterm = $financingGroupInfo_data["debt"]["last"][4] / 100000000;
							//集团及其子公司长期借款，单位亿元
							$totalStockValue = $financingGroupInfo_data["share_financing_total"]["total"];
							//发行股票募集资金，单位亿元
							echo "集团及其子公司存量债券", $restBond, "亿元，", "短期借款", $debtShortterm, "亿元，", "长期借款", $debtLongterm, "亿元，", "发行股票募集资金", $totalStockValue, "亿元。";


							echo "合作银行前十名：";
							for ($i = 0; ($i < count($financingGroupInfo_data["credit_detail"])) && ($i < 10); $i++){
								echo $financingGroupInfo_data["credit_detail"][$i]["bank"];
								if($i != (count($financingGroupInfo_data["credit_detail"]) - 1) && $i != 9)echo "、";
							}
							echo "。";
						?>
							<h4>(1) 集团获得主要贷款银行的授信情况</h4>
						<p>！！！内容待填充！！！</p>
						<div id="table_2" class="table-responsive">
            				<table class = "table table-striped table-hover">
            					<tr>
            						<th>债务人</th>
            						<th>发行日期</th>
            						<th>发行期限</th>
            						<th>发行规模</th>
									<th>主承销商</th>
									<th>种类</th>
									<th>债务余额</th>
            					</tr>
								<?php
								$midTermTtl = 0;
								$shortTermTtl = 0;
								$veryShortTermTtl = 0;
								$bondTtl = 0;
            					for ($i = 0; $i < count($financingGroupInfo_data["bond_detail"]); $i++) {
            					    $debtSubject = $financingGroupInfo_data["bond_detail"][$i]["debt_subject"];
									$date = $financingGroupInfo_data["bond_detail"][$i]["list_date"];
									$deadline = $financingGroupInfo_data["bond_detail"][$i]["deadline"];
									$total = $financingGroupInfo_data["bond_detail"][$i]["total"];
									$leadUnderwriter = $financingGroupInfo_data["bond_detail"][$i]["lead_underwriter"];
									$classify = $financingGroupInfo_data["bond_detail"][$i]["classify"];
									$rest = $financingGroupInfo_data["bond_detail"][$i]["rest"];
									if($classify == "一般中期票据") $midTermTtl++;
									if($classify == "一般短期融资券") $shortTermTtl++;
									if($classify == "一般超短期融资券") $veryShortTermTtl++;
									if($classify == "一般公司债") $bondTtl++;
            					?>
            					
            					<tr>
            						<td><?=$debtSubject?></td>
            						<td><?=$date?></td>
            						<td><?=$deadline?></td>
            						<td><?=$total?></td>
									<td><?=$leadUnderwriter?></td>
									<td><?=$classify?></td>
									<td><?=$rest?></td>
            					</tr>
            					
            					<?php	
            					}
            				    ?>
            				</table>
            			</div>
						<?PHP
						echo "中期票据", $midTermTtl, "只，短期融资券", $shortTermTtl, "只，超短期融资券", $veryShortTermTtl, "只，公司债券", $bondTtl, "只。";
						?>


						<h4>(3) 评级情况</h4>
						<?php
							$rating_date = $financingInfo_data["rating"]["date"];
							$rating_organ = $financingInfo_data["rating"]["organ"];
							$rating_rating = $financingInfo_data["rating"]["rating"];
							$rating_move = $financingInfo_data["rating"]["move"];
						echo "经", $rating_organ ,"评定。该企业的",$rating_date,"主体信用等级为",$rating_rating,"。较上年主体信用评级", $rating_move,"。"
						?>

                            </div>
                        </div>


            		</div>
        		</div>
        		
        		<div class="col-lg-2" id="myScrollspy">
        				<ul class="nav nav-tabs nav-stacked" data-spy="affix" data-offset-top="185">
        					<li class="active">
        						<a href="#introduction">公司简介</a>
        					</li>
        					<li>
        						<a href="#shareholder">股东信息</a>
        					</li>
        					<li>
        						<a href="#history">历史沿革</a>
        					</li>
        					<li>
        						<a href="#manager">高管信息</a>
        					</li>
							<li>
        						<a href="#operate">生产经营情况</a>
        					</li>
        					<li>
        						<a href="#finance">财务情况</a>
        					</li>
        					<li>
        						<a href="#financing">融资情况</a>
        					</li>
        				</ul>
        		</div>
			</div>
          	<div role="tabpanel" class="tab-pane" id="baoliao">...</div>
        </div>
    	
    </div>

</div>

<?PHP
	include("foot.php");
?>

<script src="master.js"></script>

</body>
</html>
