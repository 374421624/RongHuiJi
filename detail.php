<!DOCTYPE html>
<html lang="zh-CN">

<?PHP
	include("head.php");

	$id = Request("id");
	$urlshang = $_SERVER['HTTP_REFERER'];

	# 读取接口数据
	$url_baseinfo = $base_url."/api1/baseinfo?c_id=$id";
	$url_holders = $base_url."/api1/holders?c_id=$id";
	$url_managers = $base_url."/api1/managers?c_id=$id";
	$url_financingInfo = $base_url."/api1/financing_info_0729?c_id=$id";
	$url_changeinfo = $base_url."/api1/changeinfo?c_id=$id";
	$url_business_info = $base_url."/api1/business?c_id=$id";
	$url_financialstatement_info = $base_url."/api1/financialstatement?c_id=$id";
	$url_firmgraph_holders_info = $base_url."/api1/firmgraph_holders?c_id=$id";
	$url_firmgraph_investments_info = $base_url."/api1/firmgraph_investments?c_id=$id";

	echo $url_financialstatement_info;
	
	$baseinfo_data = json_decode(file_get_contents($url_baseinfo), true);
	$holder_data = json_decode(file_get_contents($url_holders), true);
	$manager_data = json_decode(file_get_contents($url_managers), true);
	$financingInfo_data = json_decode(file_get_contents($url_financingInfo), true);
	$changeinfo_data = json_decode(file_get_contents($url_changeinfo), true);
	$business_info_data = json_decode(file_get_contents($url_business_info), true);
	$financialstatement_info_data = json_decode(file_get_contents($url_financialstatement_info), true);
	$firmgraph_holders_info_data = json_decode(file_get_contents($url_firmgraph_holders_info), true);
	$firmgraph_investments_info_data = json_decode(file_get_contents($url_firmgraph_investments_info), true);

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
		<h1 id="top">公司详情</h1>
	</div>
	
	<div class="row"> 
		
		<!-- 路径导航 -->
		<ol class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <li><a href="<?=$urlshang?>">Search</a></li>
          <li class="active">Detail</li>
        </ol>
        
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
						
                		<p>注册地址：<?=$baseinfo_data["reg_address"]?></p>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseIntroduction">详情</button>
                		<div class="collapse" id="collapseIntroduction">
                            <div class="well">
							<?php
							//公司基本信息
							$legal_name = $baseinfo_data['legal_name'];
							$s_name = $baseinfo_data['s_name'];
							$money = $baseinfo_data['money'];
							$reg_address = $baseinfo_data['reg_address'];
							?>
							<p><strong>法人：<?= $legal_name; ?></strong></p>
							<p><strong>注册资金：<?= $money; ?></strong></p>
							<?php
							if($s_name){ 
							?>
							<p><strong>公司A股简称：<?$s_name; ?></strong></p>
							<?php
							}
							?> 
							<p></p>
							<span><strong>公司主营业务：</strong></span><strong>
							<?php
							//判断是否存在主营业务
							if($business_info_data['key_business_3_year'][0]['data']){
								for($j = 0;$j<count($business_info_data['key_business_3_year'][0]['data']);$j++){
									if($business_info_data['key_business_3_year'][0]['data'][$j][1]=="产品"){
										?>
										<span>
										<?=$business_info_data['key_business_3_year'][0]['data'][$j][2];?>，	
										</span>
										<?php
									}	
								}
							?>
							等几个板块。</strong>
							<?php
							}
							else{
								?>
								<span><strong>无。</strong></span>
								<?php
							}
							?>
							<?php
							//判断是否存在上市信息
							if($baseinfo_data['list_info']){ 
								?>
								<p>——————————————————————————</p>
								<p><strong>上市信息</strong></p>
								<?php
								for($i = 0;$i<count($baseinfo_data['list_info']);$i++){
									$sname = $baseinfo_data['list_info'][$i]['s_name'];
									$s_id = $sname = $baseinfo_data['list_info'][$i]['s_id'];
									$address = $baseinfo_data['list_info'][$i]['address'];
									$date = $baseinfo_data['list_info'][$i]['date'];
									?>
									<p><strong>股票简称：<?= $sname; ?></strong>

									<p><strong>股票代码：<?= $s_id; ?></strong>

									<p><strong>上市地点：<?= $address; ?></strong>

									<p><strong>上市时间：<?= $date; ?></strong>
									
									
									<?php
								}   
							}
						?>
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
									var data = genData();
				
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
				
				
				
				
									function genData() {
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



								<div id="treeDiag" style="width: 900px; height:700px;"></div>
            					<script type="text/javascript">
									// 基于准备好的dom，初始化echarts实例
									var myChart = echarts.init(document.getElementById('treeDiag'));
				
								
									// 指定图表的配置项和数据
									
									var data1 = getData();

									function getData() {
										var seriesdata = {};
										var firmgraph_holders = <?= file_get_contents($url_firmgraph_holders_info); ?>;
										var firmgraph_investments = <?= file_get_contents($url_firmgraph_investments_info); ?>;
										seriesdata.name = "<?=$baseinfo_data["name"]?>";
										seriesdata.children = [];
										seriesdata.children.push({
											name: "股东",
											children: []
										});
										seriesdata.children.push({
											name: "投资",
											children: []
										});
										for (var i = 0; i < firmgraph_holders.holders.length; i++) {
											seriesdata.children[0].children.push({
												name: firmgraph_holders.holders[i].name,
												rate: firmgraph_holders.holders[i].rate
											});
										}
										for (var i = 0; i < firmgraph_investments.investments.length; i++) {
											seriesdata.children[1].children.push({
												name: firmgraph_investments.investments[i].name,
												rate: firmgraph_investments.investments[i].rate
											});
										}
										return seriesdata;
									}
				
									option = {
										title: {
											text: '该企业的股东及投资企业'
										},
										tooltip: {
											trigger: 'item',
											triggerOn: 'mousemove'
										},
										series:[
											{
												type: 'tree',

												name: 'tree1',

												data: [data1],

												top: '0%',
												left: '20%',
												bottom: '0%',
												right: '50%',

												symbolSize: 7,

												label: {
													normal: {
														position: 'left',
														verticalAlign: 'middle',
														align: 'right'
													}
												},

												leaves: {
													label: {
														normal: {
															position: 'right',
															verticalAlign: 'middle',
															align: 'left'
														}
													}
												},

												expandAndCollapse: true,

												animationDuration: 550,
												animationDurationUpdate: 750

											}
										]
									};
									// 使用刚指定的配置项和数据显示图表。
									myChart.setOption(option);
            					</script>
            				</div>	<!--well-->
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
									?><span>高管：<?=$name?></span>

									<br>
									<?php
									$post = $manager_data["managers"][$i]["post"];
									?><span>职位：<?=$post?></span>
									<p>——————————————————————————————————</p>
									<?php
									$abstract = $manager_data["managers"][$i]["abstract"];
									if($abstract == ''){
										?><span>简介：无。</span><?php
									}
										else{
										?><span>简介：<?=$abstract?></span><?php
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
							?><span>公司主营业务分为</span><?php
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
							?>
							<span> 等几个板块，<?=$last_deadline?>年实现了营业额<?=$last_operate_rev?>元人民币，同比增长<?=$last_operate_rev_YOY?>，实现了利润总额<?=$last_profit?>元人民币。同比增长<?=$last_profit_YOY?>，主营业务中<?=$business_info_data['key_business_3_year'][0]['data'][$max][2]?>占比较大的业务板块。占比<?=$business_info_data['key_business_3_year'][0]['data'][$max][4]?></span>
						<h3 style = 'color:red;text-align:center'>根据地区划分前三年生产经营情况</h3>


							<div id="main2" style="width: 900px; height:400px;"></div>
							<script type="text/javascript">
								// 基于准备好的dom，初始化echarts实例
								var myChart = echarts.init(document.getElementById('main2'));
								// 指定图表的配置项和数据
								var data = genData();

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

								function genData() {
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
								var data = genData();

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

								function genData() {
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
						<?php
								$date = $financialstatement_info_data['year'];
								$sum_asset = $financialstatement_info_data['sum_asset'];
								$sum_debt = $financialstatement_info_data['sum_debt'];
								$sum_owners_equity = $financialstatement_info_data['sum_owners_equity'];
								$asset_debt_ratio = $financialstatement_info_data['asset_debt_ratio'];
								$net_profit = $financialstatement_info_data['net_profit'];
								$net_profit_YOY = $financialstatement_info_data['net_profit_YOY'];
								$operate_rev = $financialstatement_info_data['operate_rev'];
								$operate_rev_YOY = $financialstatement_info_data['operate_rev_YOY'];
						?>
						<span>截止到<?=$date?>年末，公司总资产<?=$sum_asset?>元，总负债<?=$sum_debt?>元。所有者权益<?=$sum_owners_equity?>元。资产总负债率<?=$asset_debt_ratio?>。<?=$date?>年实现营业额收入<?=$operate_rev?>元，同比增长<?=$operate_rev_YOY?>。实现净利润<?=$net_profit?>元，同比增长<?=$net_profit_YOY?>。</span>
                		<button type="button" class="btn btn-default btn-block" data-toggle="collapse" data-target="#collapseFinance">详情</button>
                		<div class="collapse" id="collapseFinance">
                            <div class="well">
                                <h3 style ="color:red;text-align:center">最近两年财务报表</h3>
								<p style="text-align:right">（单位：万元）</p>
								<table class = "table table-striped table-hover">
									<tr>
									<th>日期</th>
									<?php
									for($i = 0;$i<2;$i++){
										$date = $financialstatement_info_data['statement_2_year'][$i]['date'];
										?>
										<th><?=$date?></th>
										<?php
									}
									?>
									<th>最近一期</th>
									<th>行业平均值</th>
									</tr>

									<tr>
									<th>资产总额</th>
									<?php
									for($i = 0;$i<2;$i++){
										$sum_asset = $financialstatement_info_data['statement_2_year'][$i]['sum_asset'];
										?>
										<td><?=$sum_asset/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['sum_asset']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>流动资产</th>
									<?php
									for($i = 0;$i<2;$i++){
										$curr_asset = $financialstatement_info_data['statement_2_year'][$i]['curr_asset'];
										?>
										<td><?=$curr_asset/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['curr_asset']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>货币资金</th>
									<?php
									for($i = 0;$i<2;$i++){
										$monetary_fund = $financialstatement_info_data['statement_2_year'][$i]['monetary_fund'];
										?>
										<td><?=$monetary_fund/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['monetary_fund']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>应收账款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$account_rec = $financialstatement_info_data['statement_2_year'][$i]['account_rec'];
										?>
										<td><?=$account_rec/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['account_rec']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>其他应收款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$other_rec = $financialstatement_info_data['statement_2_year'][$i]['other_rec'];
										?>
										<td><?=$other_rec/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['other_rec']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>预付账款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$advance_pay = $financialstatement_info_data['statement_2_year'][$i]['advance_pay'];
										?>
										<td><?=$advance_pay/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['advance_pay']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>存货</th>
									<?php
									for($i = 0;$i<2;$i++){
										$inventory = $financialstatement_info_data['statement_2_year'][$i]['inventory'];
										?>
										<td><?=$inventory/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['inventory']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>固定资产</th>
									<?php
									for($i = 0;$i<2;$i++){
										$fixed_ass = $financialstatement_info_data['statement_2_year'][$i]['fixed_ass'];
										?>
										<td><?=$fixed_ass/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['fixed_ass']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>负债总额</th>
									<?php
									for($i = 0;$i<2;$i++){
										$sum_liab = $financialstatement_info_data['statement_2_year'][$i]['sum_liab'];
										?>
										<td><?=$sum_liab/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['sum_liab']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>流动负债</th>
									<?php
									for($i = 0;$i<2;$i++){
										$sum_curr_liab = $financialstatement_info_data['statement_2_year'][$i]['sum_curr_liab'];
										?>
										<td><?=$sum_curr_liab/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['sum_curr_liab']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>短期借款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$st_borrow = $financialstatement_info_data['statement_2_year'][$i]['st_borrow'];
										?>
										<td><?=$st_borrow/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['st_borrow']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>应付票据</th>
									<?php
									for($i = 0;$i<2;$i++){
										$bill_pay = $financialstatement_info_data['statement_2_year'][$i]['bill_pay'];
										?>
										<td><?=$bill_pay/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['bill_pay']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>应付账款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$account_pay = $financialstatement_info_data['statement_2_year'][$i]['account_pay'];
										?>
										<td><?=$account_pay/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['account_pay']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>预收账款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$advance_rec = $financialstatement_info_data['statement_2_year'][$i]['advance_rec'];
										?>
										<td><?=$advance_rec/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['advance_rec']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>其他应付款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$other_pay = $financialstatement_info_data['statement_2_year'][$i]['other_pay'];
										?>
										<td><?=$other_pay/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['other_pay']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>长期借款</th>
									<?php
									for($i = 0;$i<2;$i++){
										$lt_borrow = $financialstatement_info_data['statement_2_year'][$i]['lt_borrow'];
										?>
										<td><?=$lt_borrow/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['lt_borrow']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>所有者权益</th>
									<?php
									for($i = 0;$i<2;$i++){
										$sum_she_equity = $financialstatement_info_data['statement_2_year'][$i]['sum_she_equity'];
										?>
										<td><?=$sum_she_equity/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['sum_she_equity']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>母公司所有者权益</th>
									<?php
									for($i = 0;$i<2;$i++){
										$sum_parent_equity = $financialstatement_info_data['statement_2_year'][$i]['sum_parent_equity'];
										?>
										<td><?=$sum_parent_equity/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['sum_parent_equity']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>营业收入</th>
									<?php
									for($i = 0;$i<2;$i++){
										$operate_rev = $financialstatement_info_data['statement_2_year'][$i]['operate_rev'];
										?>
										<td><?=$operate_rev/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['operate_rev']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>营业成本</th>
									<?php
									for($i = 0;$i<2;$i++){
										$operate_exp = $financialstatement_info_data['statement_2_year'][$i]['operate_exp'];
										?>
										<td><?=$operate_exp/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['operate_exp']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>税金及附加</th>
									<?php
									for($i = 0;$i<2;$i++){
										$operate_tax = $financialstatement_info_data['statement_2_year'][$i]['operate_tax'];
										?>
										<td><?=$operate_tax/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['operate_tax']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>营业利润</th>
									<?php
									for($i = 0;$i<2;$i++){
										$operate_profit = $financialstatement_info_data['statement_2_year'][$i]['operate_profit'];
										?>
										<td><?=$operate_profit/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['operate_profit']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>利润总额</th>
									<?php
									for($i = 0;$i<2;$i++){
										$sum_profit = $financialstatement_info_data['statement_2_year'][$i]['sum_profit'];
										?>
										<td><?=$sum_profit/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['sum_profit']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>净利润</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_profit = $financialstatement_info_data['statement_2_year'][$i]['net_profit'];
										?>
										<td><?=$net_profit/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_profit']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>归属母公司的净利润</th>
									<?php
									for($i = 0;$i<2;$i++){
										$parent_net_profit = $financialstatement_info_data['statement_2_year'][$i]['parent_net_profit'];
										?>
										<td><?=$parent_net_profit/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['parent_net_profit']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>经营性现金净流量</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_operate_cash_flow = $financialstatement_info_data['statement_2_year'][$i]['net_operate_cash_flow'];
										?>
										<td><?=$net_operate_cash_flow/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_operate_cash_flow']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>投资性现金净流量</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_inv_cash_flow = $financialstatement_info_data['statement_2_year'][$i]['net_inv_cash_flow'];
										?>
										<td><?=$net_inv_cash_flow/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_inv_cash_flow']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>筹资性现金净流量</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_fin_cash_flow = $financialstatement_info_data['statement_2_year'][$i]['net_fin_cash_flow'];
										?>
										<td><?=$net_fin_cash_flow/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_fin_cash_flow']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>现金净流量</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_cash_flow = $financialstatement_info_data['statement_2_year'][$i]['net_cash_flow'];
										?>
										<td><?=$net_cash_flow/10000?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_cash_flow']/10000;?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>资产负债率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$asset_debt_ratio = $financialstatement_info_data['statement_2_year'][$i]['asset_debt_ratio'];
										?>
										<td><?=$asset_debt_ratio?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['asset_debt_ratio'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>流动比率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$current_ratio = $financialstatement_info_data['statement_2_year'][$i]['current_ratio'];
										?>
										<td><?=$current_ratio?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['current_ratio'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>速动比率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$quick_ratio = $financialstatement_info_data['statement_2_year'][$i]['quick_ratio'];
										?>
										<td><?=$quick_ratio?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['quick_ratio'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>应收账款周转率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$account_rec_turnover = $financialstatement_info_data['statement_2_year'][$i]['account_rec_turnover'];
										?>
										<td><?=$account_rec_turnover?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['account_rec_turnover'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>存货周转率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$inventory_turnover = $financialstatement_info_data['statement_2_year'][$i]['inventory_turnover'];
										?>
										<td><?=$inventory_turnover?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['inventory_turnover'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>总资产周转率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$total_asset_turnover = $financialstatement_info_data['statement_2_year'][$i]['total_asset_turnover'];
										?>
										<td><?=$total_asset_turnover?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['total_asset_turnover'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>主营业务利润率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$main_business_profit_ratio = $financialstatement_info_data['statement_2_year'][$i]['main_business_profit_ratio'];
										?>
										<td><?=$main_business_profit_ratio?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['main_business_profit_ratio'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>净资产收益率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_asset_return_ratio = $financialstatement_info_data['statement_2_year'][$i]['net_asset_return_ratio'];
										?>
										<td><?=$net_asset_return_ratio?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_asset_return_ratio'];?></td>
									<td>-</td>
									</tr>

									<tr>
									<th>总资产报酬率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$total_asset_return_ratio = $financialstatement_info_data['statement_2_year'][$i]['total_asset_return_ratio'];
										?>
										<td><?=$total_asset_return_ratio?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['total_asset_return_ratio'];?></td>
									<td>-</td>
									</tr>

									
									<tr>
									<th>营业增长率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$business_growth_rate = $financialstatement_info_data['statement_2_year'][$i]['business_growth_rate'];
										?>
										<td><?=$business_growth_rate?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['business_growth_rate'];?></td>
									<td>-</td>
									</tr>

									
									<tr>
									<th>总资产增长率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$total_asset_growth_rate = $financialstatement_info_data['statement_2_year'][$i]['total_asset_growth_rate'];
										?>
										<td><?=$total_asset_growth_rate?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['total_asset_growth_rate'];?></td>
									<td>-</td>
									</tr>

									
									<tr>
									<th>净利润增长率</th>
									<?php
									for($i = 0;$i<2;$i++){
										$net_profit_growth_rate = $financialstatement_info_data['statement_2_year'][$i]['net_profit_growth_rate'];
										?>
										<td><?=$net_profit_growth_rate?></td>
										<?php
									}
									?>
									<td><?=$financialstatement_info_data['statement_last']['net_profit_growth_rate'];?></td>
									<td>-</td>
									</tr>

									

								</table>
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
							<p>截至---待填充---,集团主要合作银行的授信总额<?=$totalCredit?>亿元，未使用的授信额度<?=$unusedCredit?>亿元。合作的主要银行情况如下表：</p>
							<p style = 'text-align:right'>（单位：亿元）</p>
							<table class = "table table-striped table-hover">
									<tr>
										<th>银行名称</th>
										<th>授信额度</th>
										<th>已使用额度</th>
										<th>未使用额度</th>
										<th>授信到期日</th>
									</tr>
									<?php
									$used_sum = 0;
									for ($k = 0;$k<count($financingGroupInfo_data['credit_detail']);$k++){
										$bank = $financingGroupInfo_data['credit_detail'][$k]['bank'];
										$amount = $financingGroupInfo_data['credit_detail'][$k]['amount']/10000;
										$used = $financingGroupInfo_data['credit_detail'][$k]['used']/10000;
										$unused = $financingGroupInfo_data['credit_detail'][$k]['unused']/10000;
										$limit_date = $financingGroupInfo_data['credit_detail'][$k]['limit_date'];
										$used_sum += $used;
										?>
										<tr>
											<td><?=$bank?></td>
											<td><?=$amount?></td>
											<td><?=$used?></td>
											<td><?=$unused?></td>
											<td><?=$limit_date?></td>		
										</tr>
									<?php 
									}
									?>
									<tr>
											<td>合计</td>
											<td><?=$totalCredit?></td>
											<td><?=$used_sum?></td>
											<td><?=$unusedCredit?></td>		
										</tr>
							</table>
						<div id="table_2" class="table-responsive">
							<?php
							$mid = 0;
							$mid_sum = 0;
							$short = 0;
							$short_sum = 0;
							$mid_qiye = 0;
							$mid_qiye_sum = 0;
							$ABN = 0;
							$ABN_sum = 0;
							$company_debt = 0;
							$company_debt_sum = 0;
							$zhengquan = 0;
							$zhengquan_sum = 0;
							for ($j = 0; $j < count($financingGroupInfo_data["bond_detail"]); $j++) {
								if($financingGroupInfo_data["bond_detail"][$j]['classify'] == '一般中期票据'){
									$mid++;
									$mid_sum += $financingGroupInfo_data["bond_detail"][$j]['total'];
								}
								if($financingGroupInfo_data["bond_detail"][$j]['classify'] == '一般企业债'){
									$mid_qiye++;
									$mid_qiye_sum += $financingGroupInfo_data["bond_detail"][$j]['total'];
								}
								if($financingGroupInfo_data["bond_detail"][$j]['classify'] == '一般公司债'){
									$company_debt++;
									$company_debt_sum += $financingGroupInfo_data["bond_detail"][$j]['total'];
								}
								if($financingGroupInfo_data["bond_detail"][$j]['classify'] == '交易商协会ABN'){
									$ABN++;
									$ABN_sum += $financingGroupInfo_data["bond_detail"][$j]['total'];
								}
								if($financingGroupInfo_data["bond_detail"][$j]['classify'] == '一般短期融资券'){
									$short++;
									$short_sum += $financingGroupInfo_data["bond_detail"][$j]['total'];
								}
								if($financingGroupInfo_data["bond_detail"][$j]['classify'] == '证券公司债'){
									$zhengquan++;
									$zhengquan_sum += $financingGroupInfo_data["bond_detail"][$j]['total'];
								}
							}
							?>
							<h4>(2) 债券及其资产支持证券融资情况</h4>
							<p>截至--待填充---，集团及其子公司以发行商出入存续期内的债券（含资产支持证券）金额<?=$financingInfo_data['bond_total']['total']?>亿元，平均期限<?=$financingInfo_data['bond_total']['avg_deadline']?>年，平均价格<?=$financingInfo_data['bond_total']['avg_inter_rate']?>%。集团及其子公司处在存续期内的一般中期票据<?=$mid?>只，金额共<?=$mid_sum?>亿元，一般企业债<?=$mid_qiye?>只，金额共<?=$mid_qiye_sum?>亿元，一般公司债<?=$company_debt?>只，金额共<?=$company_debt_sum?>亿元，一般短期融资券<?=$short?>只，金额共<?=$short_sum?>亿元，交易商协会ABN<?=$ABN?>只，金额共<?=$ABN_sum?>亿元，证券公司债<?=$zhengquan?>只，金额共<?=$zhengquan_sum?>亿元，具体情况如下表：</p>
							<p style = 'text-align:right'>（单位：亿元）</p>
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
								$total2010 = [0,0,0,0];
								$total2011 = [0,0,0,0];
								$total2012 = [0,0,0,0];
								$total2013 = [0,0,0,0];
								$total2014 = [0,0,0,0];
								$total2015 = [0,0,0,0];
								$total2016 = [0,0,0,0];
								$total2017 = [0,0,0,0];
								$total2010cnt = [0,0,0,0];
								$total2011cnt = [0,0,0,0];
								$total2012cnt = [0,0,0,0];
								$total2013cnt = [0,0,0,0];
								$total2014cnt = [0,0,0,0];
								$total2015cnt = [0,0,0,0];
								$total2016cnt = [0,0,0,0];
								$total2017cnt = [0,0,0,0];
								$interRate2010 = [0,0,0,0];
								$interRate2011 = [0,0,0,0];
								$interRate2012 = [0,0,0,0];
								$interRate2013 = [0,0,0,0];
								$interRate2014 = [0,0,0,0];
								$interRate2015 = [0,0,0,0];
								$interRate2016 = [0,0,0,0];
								$interRate2017 = [0,0,0,0];
								$interRate2010cnt = [0,0,0,0];
								$interRate2011cnt = [0,0,0,0];
								$interRate2012cnt = [0,0,0,0];
								$interRate2013cnt = [0,0,0,0];
								$interRate2014cnt = [0,0,0,0];
								$interRate2015cnt = [0,0,0,0];
								$interRate2016cnt = [0,0,0,0];
								$interRate2017cnt = [0,0,0,0];
            					for ($i = 0; $i < count($financingGroupInfo_data["bond_detail"]); $i++) {
            					    $debtSubject = $financingGroupInfo_data["bond_detail"][$i]["debt_subject"];
									$date = $financingGroupInfo_data["bond_detail"][$i]["list_date"];
									$deadline = $financingGroupInfo_data["bond_detail"][$i]["deadline"];
									$total = $financingGroupInfo_data["bond_detail"][$i]["total"];
									$leadUnderwriter = $financingGroupInfo_data["bond_detail"][$i]["lead_underwriter"];
									$classify = $financingGroupInfo_data["bond_detail"][$i]["classify"];
									$rest = $financingGroupInfo_data["bond_detail"][$i]["rest"];
									$interRate = $financingGroupInfo_data["bond_detail"][$i]["inter_rate"];
									if($classify == "一般中期票据") $midTermTtl++;
									if($classify == "一般短期融资券") $shortTermTtl++;
									if($classify == "一般超短期融资券") $veryShortTermTtl++;
									if($classify == "一般公司债") $bondTtl++;
									$totalnum = floatval($total);
									$interRateNum = floatval($interRate);
									$deadlineNum = intval($deadline);
									switch(intval(explode("-", $date)[0])){
										case 2010:
											if($deadlineNum>0 && $deadlineNum<=1){$total2010[0] += $totalnum; $total2010cnt[0]++;$interRate2010[0] += $interRateNum; $interRate2010cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2010[1] += $totalnum; $total2010cnt[1]++;$interRate2010[1] += $interRateNum; $interRate2010cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2010[2] += $totalnum; $total2010cnt[2]++;$interRate2010[2] += $interRateNum; $interRate2010cnt[2]++;}
											else if($deadlineNum>5){$total2010[3] += $totalnum; $total2010cnt[3]++;$interRate2010[3] += $interRateNum; $interRate2010cnt[3]++;}
											break;
										case 2011:
											if($deadlineNum>0 && $deadlineNum<=1){$total2011[0] += $totalnum; $total2011cnt[0]++;$interRate2011[0] += $interRateNum; $interRate2011cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2011[1] += $totalnum; $total2011cnt[1]++;$interRate2011[1] += $interRateNum; $interRate2011cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2011[2] += $totalnum; $total2011cnt[2]++;$interRate2011[2] += $interRateNum; $interRate2011cnt[2]++;}
											else if($deadlineNum>5){$total2011[3] += $totalnum; $total2011cnt[3]++;$interRate2011[3] += $interRateNum; $interRate2011cnt[3]++;}
											break;
										case 2012:
											if($deadlineNum>0 && $deadlineNum<=1){$total2012[0] += $totalnum; $total2012cnt[0]++;$interRate2012[0] += $interRateNum; $interRate2012cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2012[1] += $totalnum; $total2012cnt[1]++;$interRate2012[1] += $interRateNum; $interRate2012cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2012[2] += $totalnum; $total2012cnt[2]++;$interRate2012[2] += $interRateNum; $interRate2012cnt[2]++;}
											else if($deadlineNum>5){$total2012[3] += $totalnum; $total2012cnt[3]++;$interRate2012[3] += $interRateNum; $interRate2012cnt[3]++;}
											break;
										case 2013:
											if($deadlineNum>0 && $deadlineNum<=1){$total2013[0] += $totalnum; $total2013cnt[0]++;$interRate2013[0] += $interRateNum; $interRate2013cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2013[1] += $totalnum; $total2013cnt[1]++;$interRate2013[1] += $interRateNum; $interRate2013cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2013[2] += $totalnum; $total2013cnt[2]++;$interRate2013[2] += $interRateNum; $interRate2013cnt[2]++;}
											else if($deadlineNum>5){$total2013[3] += $totalnum; $total2013cnt[3]++;$interRate2013[3] += $interRateNum; $interRate2013cnt[3]++;}
											break;
										case 2014:
											if($deadlineNum>0 && $deadlineNum<=1){$total2014[0] += $totalnum; $total2014cnt[0]++;$interRate2014[0] += $interRateNum; $interRate2014cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2014[1] += $totalnum; $total2014cnt[1]++;$interRate2014[1] += $interRateNum; $interRate2014cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2014[2] += $totalnum; $total2014cnt[2]++;$interRate2014[2] += $interRateNum; $interRate2014cnt[2]++;}
											else if($deadlineNum>5){$total2014[3] += $totalnum; $total2014cnt[3]++;$interRate2014[3] += $interRateNum; $interRate2014cnt[3]++;}
											break;
										case 2015:
											if($deadlineNum>0 && $deadlineNum<=1){$total2015[0] += $totalnum; $total2015cnt[0]++;$interRate2015[0] += $interRateNum; $interRate2015cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2015[1] += $totalnum; $total2015cnt[1]++;$interRate2015[1] += $interRateNum; $interRate2015cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2015[2] += $totalnum; $total2015cnt[2]++;$interRate2015[2] += $interRateNum; $interRate2015cnt[2]++;}
											else if($deadlineNum>5){$total2015[3] += $totalnum; $total2015cnt[3]++;$interRate2015[3] += $interRateNum; $interRate2015cnt[3]++;}
											break;
										case 2016:
											if($deadlineNum>0 && $deadlineNum<=1){$total2016[0] += $totalnum; $total2016cnt[0]++;$interRate2016[0] += $interRateNum; $interRate2016cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2016[1] += $totalnum; $total2016cnt[1]++;$interRate2016[1] += $interRateNum; $interRate2016cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2016[2] += $totalnum; $total2016cnt[2]++;$interRate2016[2] += $interRateNum; $interRate2016cnt[2]++;}
											else if($deadlineNum>5){$total2016[3] += $totalnum; $total2016cnt[3]++;$interRate2016[3] += $interRateNum; $interRate2016cnt[3]++;}
											break;
										case 2017:
											if($deadlineNum>0 && $deadlineNum<=1){$total2017[0] += $totalnum; $total2017cnt[0]++;$interRate2017[0] += $interRateNum; $interRate2017cnt[0]++;}
											else if($deadlineNum>1 && $deadlineNum<=3){$total2017[1] += $totalnum; $total2017cnt[1]++;$interRate2017[1] += $interRateNum; $interRate2017cnt[1]++;}
											else if($deadlineNum>3 && $deadlineNum<=5){$total2017[2] += $totalnum; $total2017cnt[2]++;$interRate2017[2] += $interRateNum; $interRate2017cnt[2]++;}
											else if($deadlineNum>5){$total2017[3] += $totalnum; $total2017cnt[3]++;$interRate2017[3] += $interRateNum; $interRate2017cnt[3]++;}
											break;
									}
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

						<?PHP
							for($i=0;$i<4;$i++){
								if($total2010cnt[$i]!=0)$total2010[$i] = $total2010[$i] / $total2010cnt[$i];
								if($total2011cnt[$i]!=0)$total2011[$i] = $total2011[$i] / $total2011cnt[$i];
								if($total2012cnt[$i]!=0)$total2012[$i] = $total2012[$i] / $total2012cnt[$i];
								if($total2013cnt[$i]!=0)$total2013[$i] = $total2013[$i] / $total2013cnt[$i];
								if($total2014cnt[$i]!=0)$total2014[$i] = $total2014[$i] / $total2014cnt[$i];
								if($total2015cnt[$i]!=0)$total2015[$i] = $total2015[$i] / $total2015cnt[$i];
								if($total2016cnt[$i]!=0)$total2016[$i] = $total2016[$i] / $total2016cnt[$i];
								if($total2017cnt[$i]!=0)$total2017[$i] = $total2017[$i] / $total2017cnt[$i];
								if($interRate2010cnt[$i]!=0)$interRate2010[$i] = $interRate2010[$i] / $interRate2010cnt[$i];
								if($interRate2011cnt[$i]!=0)$interRate2011[$i] = $interRate2011[$i] / $interRate2011cnt[$i];
								if($interRate2012cnt[$i]!=0)$interRate2012[$i] = $interRate2012[$i] / $interRate2012cnt[$i];
								if($interRate2013cnt[$i]!=0)$interRate2013[$i] = $interRate2013[$i] / $interRate2013cnt[$i];
								if($interRate2014cnt[$i]!=0)$interRate2014[$i] = $interRate2014[$i] / $interRate2014cnt[$i];
								if($interRate2015cnt[$i]!=0)$interRate2015[$i] = $interRate2015[$i] / $interRate2015cnt[$i];
								if($interRate2016cnt[$i]!=0)$interRate2016[$i] = $interRate2016[$i] / $interRate2016cnt[$i];
								if($interRate2017cnt[$i]!=0)$interRate2017[$i] = $interRate2017[$i] / $interRate2017cnt[$i];
							}
						?>
						


						<div id="lineChart1" style="width: 900px; height:400px;"></div>
						<script type="text/javascript">
            				// 基于准备好的dom，初始化echarts实例
            				var myChart = echarts.init(document.getElementById('lineChart1'));
            
            				
            				// 指定图表的配置项和数据
            
            				option = {
								title: {
									text: '债券期限-金额折线图',
									subtext: '根据债券期限分类，每年债券金额的平均值'
								},
								tooltip: {
									trigger: 'axis'
								},
								legend: {
									data:['[0,1)','[1,3)','[3,5)','>=5']
								},
								grid: {
									left: '3%',
									right: '4%',
									bottom: '3%',
									containLabel: true
								},
								toolbox: {
									feature: {
										saveAsImage: {}
									}
								},
								xAxis: {
									name: '年份',
									nameLocation: 'middle',
									type: 'category',
									boundaryGap: false,
									data: ['2010','2011','2012','2013','2014','2015','2016','2017']
								},
								yAxis: {
									name: '债券金额',
									nameLocation: 'middle',
									type: 'value'
								},
								series: [
									{
										name:'[0,1)',
										type:'line',
										stack: '总量1',
										data:[<?=$total2010[0]?>, <?=$total2011[0]?>, <?=$total2012[0]?>, <?=$total2013[0]?>, <?=$total2014[0]?>, <?=$total2015[0]?>, <?=$total2016[0]?>, <?=$total2017[0]?>]
									},
									{
										name:'[1,3)',
										type:'line',
										stack: '总量2',
										data:[<?=$total2010[1]?>, <?=$total2011[1]?>, <?=$total2012[1]?>, <?=$total2013[1]?>, <?=$total2014[1]?>, <?=$total2015[1]?>, <?=$total2016[1]?>, <?=$total2017[1]?>]
									},
									{
										name:'[3,5)',
										type:'line',
										stack: '总量3',
										data:[<?=$total2010[2]?>, <?=$total2011[2]?>, <?=$total2012[2]?>, <?=$total2013[2]?>, <?=$total2014[2]?>, <?=$total2015[2]?>, <?=$total2016[2]?>, <?=$total2017[2]?>]
									},
									{
										name:'>=5',
										type:'line',
										stack: '总量4',
										data:[<?=$total2010[3]?>, <?=$total2011[3]?>, <?=$total2012[3]?>, <?=$total2013[3]?>, <?=$total2014[3]?>, <?=$total2015[3]?>, <?=$total2016[3]?>, <?=$total2017[3]?>]
									}
								]
							};            
            				myChart.setOption(option);

            			</script>
						<div id="lineChart2" style="width: 900px; height:400px;"></div>
						<script type="text/javascript">
            				// 基于准备好的dom，初始化echarts实例
            				var myChart = echarts.init(document.getElementById('lineChart2'));
            
            				
            				// 指定图表的配置项和数据
            
            				option = {
								title: {
									text: '债券期限-价格（票面利率）折线图',
									subtext: '根据债券期限分类，每年债券利率的平均值'
								},
								tooltip: {
									trigger: 'axis'
								},
								legend: {
									data:['(0,1]','(1,3]','(3,5]','>5']
								},
								grid: {
									left: '3%',
									right: '4%',
									bottom: '3%',
									containLabel: true
								},
								toolbox: {
									feature: {
										saveAsImage: {}
									}
								},
								xAxis: {
									name: '年份',
									nameLocation: 'middle',
									type: 'category',
									boundaryGap: false,
									data: ['2010','2011','2012','2013','2014','2015','2016','2017']
								},
								yAxis: {
									name: '票面利率',
									nameLocation: 'middle',
									type: 'value'
								},
								series: [
									{
										name:'(0,1]',
										type:'line',
										stack: '总量1',
										data:[<?=$interRate2010[0]?>, <?=$interRate2011[0]?>, <?=$interRate2012[0]?>, <?=$interRate2013[0]?>, <?=$interRate2014[0]?>, <?=$interRate2015[0]?>, <?=$interRate2016[0]?>, <?=$interRate2017[0]?>]
									},
									{
										name:'(1,3]',
										type:'line',
										stack: '总量2',
										data:[<?=$interRate2010[1]?>, <?=$interRate2011[1]?>, <?=$interRate2012[1]?>, <?=$interRate2013[1]?>, <?=$interRate2014[1]?>, <?=$interRate2015[1]?>, <?=$interRate2016[1]?>, <?=$interRate2017[1]?>]
									},
									{
										name:'(3,5]',
										type:'line',
										stack: '总量3',
										data:[<?=$interRate2010[2]?>, <?=$interRate2011[2]?>, <?=$interRate2012[2]?>, <?=$interRate2013[2]?>, <?=$interRate2014[2]?>, <?=$interRate2015[2]?>, <?=$interRate2016[2]?>, <?=$interRate2017[2]?>]
									},
									{
										name:'>5',
										type:'line',
										stack: '总量4',
										data:[<?=$interRate2010[3]?>, <?=$interRate2011[3]?>, <?=$interRate2012[3]?>, <?=$interRate2013[3]?>, <?=$interRate2014[3]?>, <?=$interRate2015[3]?>, <?=$interRate2016[3]?>, <?=$interRate2017[3]?>]
									}
								]
							};
            				myChart.setOption(option);
            			</script>

						<h4>(3) 评级情况</h4>
						<?php
							$rating_date = $financingInfo_data["rating"]["date"];
							$rating_organ = $financingInfo_data["rating"]["organ"];
							$rating_rating = $financingInfo_data["rating"]["rating"];
							$rating_move = $financingInfo_data["rating"]["move"];
						echo "经", $rating_organ ,"评定。该企业的",$rating_date,"主体信用等级为",$rating_rating,"。较上年主体信用评级", $rating_move,"。"
						?>



						<h4>(4) 有息负债情况</h4>
							<p>根据公开数据显示，该企业有息总负债共<?= $financingInfo_data['debt']['total']/100000000 ?>亿元。该企业近三年及最近一期有息债务？增长规律？债务结构以长/短期为主，增减情况与现金流相匹配。</p>
							<h5><b>近三年及最近一期有息负债表：</b></h5>
							<p style = "text-align:right">（单位：亿元）</p>
							<table class = "table table-striped table-hover">
								<tr>
								<th>年份</th>
								<th style = 'text-align:center' colspan="2">短期借款</th>
								<th style = 'text-align:center' colspan="2">应付票据</th>
								<th style = 'text-align:center' colspan="2">一年内到期的非流动负债</th>
								<th style = 'text-align:center' colspan="2">长期借款</th>
								<th style = 'text-align:center' colspan="2">应付债券</th>
								<th style = 'text-align:center' colspan="2">应付租赁款</th>
								<th style = 'text-align:center' colspan="2">合计</th>
								</tr>
								<tr>
									<td>--</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
									<td style = 'text-align:center'>金额</td>
									<td style = 'text-align:center'>比例</td>
								</tr>
								<?php
								//计算比例合计(未实现)
								$sum_rate1 = 0;
								$sum_rate2 = 0;
								$sum_rate3 = 0;
								$sum_rate4 = 0;
								$sum_rate5 = 0;
								$sum_rate6 = 0;
								$sum_rate7 = 0; 
								//最近三年
								for($i=0;$i<count($financingInfo_data['debt']['3_years']);$i++){
									//每一个年份
									$data0 = $financingInfo_data['debt']['3_years'][$i][0];
									$data1 = $financingInfo_data['debt']['3_years'][$i][1];
									$data2 = $financingInfo_data['debt']['3_years'][$i][2];
									$data3 = $financingInfo_data['debt']['3_years'][$i][3];
									$data4 = $financingInfo_data['debt']['3_years'][$i][4];
									$data5 = $financingInfo_data['debt']['3_years'][$i][5];
									$data6 = $financingInfo_data['debt']['3_years'][$i][6];
									$data7 = $financingInfo_data['debt']['3_years'][$i][7];
									?>
									<tr>
										<td><?=$data0?></td>
										<td><?=$data1/100000000?></td>
										<td><?=$sum_rate1?></td>
										<td><?=$data2/100000000?></td>
										<td><?=$sum_rate2?></td>
										<td><?=$data3/100000000?></td>
										<td><?=$sum_rate3?></td>
										<td><?=$data4/100000000?></td>
										<td><?=$sum_rate4?></td>
										<td><?=$data5/100000000?></td>
										<td><?=$sum_rate5?></td>
										<td><?=$data6/100000000?></td>
										<td><?=$sum_rate6?></td>
										<td><?=$data7/100000000?></td>
										<td><?=$sum_rate7?></td>
										
									</tr>
									<?php
									
									
								}	
								?>
								<?php
								$rate = 0;
								//最近一期
							
								$data11 = $financingInfo_data['debt']['last'][1];
								$data22 = $financingInfo_data['debt']['last'][2];
								$data33 = $financingInfo_data['debt']['last'][3];
								$data44 = $financingInfo_data['debt']['last'][4];
								$data55 = $financingInfo_data['debt']['last'][5];
								$data66 = $financingInfo_data['debt']['last'][6];
								$data77 = $financingInfo_data['debt']['last'][7];
								
								?>
								<tr>
									<td>最近一期</td>
									<td><?=$data11/100000000?></td>
									<td><?=$rate?></td>
									<td><?=$data22/100000000?></td>
									<td><?=$rate?></td>
									<td><?=$data33/100000000?></td>
									<td><?=$rate?></td>
									<td><?=$data44/100000000?></td>
									<td><?=$rate?></td>
									<td><?=$data55/100000000?></td>
									<td><?=$rate?></td>
									<td><?=$data66/100000000?></td>
									<td><?=$rate?></td>
									<td><?=$data77/100000000?></td>
									<td><?=$rate?></td>
										
								</tr>
							

							</table>
							<h5><b>近三年及最近一期该企业现金流反应的融资情况如下表：</b></h5>
							<p style = "text-align:right">（单位：亿元）</p>
							<table class = "table table-striped table-hover">
            					<tr>
            						<th>年份</th>
            						<th>取得借款收到的现金</th>
            						<th>发行债券收到的现金</th>
            						<th>偿还债务支付的现金</th>
									<th>分配股利、利润或偿还利息支付的现金</th>
									<th>净额</th>
            					</tr>
								<?php
								$s = count($financingInfo_data['debt']['3_years']);
								//最近三年
								for($i=0;$i<$s;$i++){
									//每一个年份
									$data0 = $financingInfo_data['debt']['3_years'][$i][0];
									$data8 = $financingInfo_data['debt']['3_years'][$i][8];
									$data9 = $financingInfo_data['debt']['3_years'][$i][9];
									$data10 = $financingInfo_data['debt']['3_years'][$i][10];
									$data11 = $financingInfo_data['debt']['3_years'][$i][11];
									$data12 = $financingInfo_data['debt']['3_years'][$i][12];

								?>
								<tr>
									<td><?=$data0?></td>
									<td><?=$data8/100000000?></td>
									<td><?=$data9/100000000?></td>
									<td><?=$data10/100000000?></td>
									<td><?=$data11/100000000?></td>
									<td><?=$data12/100000000?></td>
								</tr>
								<?php
									
									
								}	
								?>
								<tr>
									<td>最近一期</td>
									<td><?=$financingInfo_data['debt']['last'][8]/100000000?></td>
									<td><?=$financingInfo_data['debt']['last'][9]/100000000?></td>
									<td><?=$financingInfo_data['debt']['last'][10]/100000000?></td>
									<td><?=$financingInfo_data['debt']['last'][11]/100000000?></td>
									<td><?=$financingInfo_data['debt']['last'][12]/100000000?></td>
								</tr>
							</table>
							<h4>(5) 股权融资情况</h4>
							<p>该集团旗下共有<?=$financingGroupInfo_data['share_financing_total']['listed_num']?>家上市公司，分别为
							<?php
							for($m = 0;$m<count($financingGroupInfo_data['share_financing_total']['listed']);$m++){
								$company_name = $financingGroupInfo_data['share_financing_total']['listed'][$m];
								?>
								<span><?=$company_name?></span>
								<?php
							}
							?>,根据公开信息显示，集团旗下上市公司合计通过股票市场融资<?=$financingGroupInfo_data['share_financing_total']['total']?>亿元，其中
							<?php
							for($n = 0;$n<count($financingGroupInfo_data['share_financing_total']['detail']);$n++){
								$kind = $financingGroupInfo_data['share_financing_total']['detail'][$n][0];
								$kind_money = $financingGroupInfo_data['share_financing_total']['detail'][$n][1];
								?><?=$kind?>类型股票募集<?=$kind_money?>亿元,
								<?php
							}
							?>股票募集资金情况如下表：</p>
							<table class = "table table-striped table-hover">
									<tr>
										<th>上市公司</th>
										<th>上市日期</th>
										<th>发行类型</th>
										<th>上市交易所</th>
										<th>发行股票数量（万股）</th>
										<th>发行价格（元）</th>
										<th>募集金额（亿元）</th>
										<th>主承销商</th>
									</tr>
									<?php
									for($j = 0;$j<count($financingGroupInfo_data['share_financing_detail']);$j++){
										if($financingGroupInfo_data['share_financing_detail'][$j]['detail']){
											for($i = 0;$i<count($financingGroupInfo_data['share_financing_detail'][$j]['detail']);$i++){
												$out_kind = $financingGroupInfo_data['share_financing_detail'][$j]['detail'][$i][0];
												$out_date = $financingGroupInfo_data['share_financing_detail'][$j]['detail'][$i][1];
												$out_num = $financingGroupInfo_data['share_financing_detail'][$j]['detail'][$i][2];
												$out_price = $financingGroupInfo_data['share_financing_detail'][$j]['detail'][$i][3];
												$receive_money = $financingGroupInfo_data['share_financing_detail'][$j]['detail'][$i][4];
											
											?>
											<tr>
												<td><?=$financingGroupInfo_data['share_financing_detail'][$j]['s_name'];?></td>
												<td><?=$financingGroupInfo_data['share_financing_detail'][$j]['list_date'];?></td>
												<td><?=$out_kind?></td>
												<td><?=$financingGroupInfo_data['share_financing_detail'][$j]['address']?></td>
												<td><?=$out_num?></td>
												<td><?=$out_price?></td>
												<td><?=$receive_money?></td>
												<td><?=$financingGroupInfo_data['share_financing_detail'][$j]['lead_underwriter'];?></td>
											</tr>
										<?php
										}
									}
								}
									?>
							</table>
							
							<h4>(6) 资产管理计划情况</h4>
							<p>根据公开数据显示，结合大数据分析，该企业与xx家资产管理公司合作发行xx笔资产管理计划募集资金，因资产管理计划的非公开性，根据资产管理公司披露的信息总结，该企业融资情况如下表：</p>
							<table class = "table table-striped table-hover">
									<tr>
										<th>公司</th>
										<th>资产管理公司</th>
										<th>产品名称</th>
										<th>资管计划成立时间</th>
										<th>续存规模</th>
										<th>资管计划期限</th>
										<th>资金运作方式</th>
										<th>资管计划受托人</th>
										<th>经理</th>
									</tr>
									<tr>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
										<td>-</td>
									</tr>

							</table>

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
