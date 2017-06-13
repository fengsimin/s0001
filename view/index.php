<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="renderer" content="webkit">
   	<meta name="viewport" content="width=device-width,initial-scale=1">
    <title><?php echo $site['title'];?></title>
    <meta name="keywords" content="<?php echo $site['keywords'];?>">
    <meta name="description" content="<?php echo $site['description'];?>">
    <!--[if lt IE 9]><script>window.location.href='http://www.ifeiwu.com/ie-browser-upgrade.html';</script><![endif]-->
	<link rel="apple-touch-icon" href="<?php echo $this->url('data/apple-touch-icon.png');?>">
    <link rel="icon" type="image/png" href="<?php echo $this->url('data/favicon.png');?>">

    <link rel="stylesheet" href="<?php echo $this->url('asset/css/reset.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('asset/css/iview.min.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('asset/css/iview-skin.min.css');?>">
    <link rel="stylesheet" href="<?php echo $this->url('asset/css/main.min.css');?>">
    <?php if($site['skin']):?>
    <link rel="stylesheet" href="<?php echo $this->url('asset/css/skin/'.$site['skin'].'.css');?>">
    <?php endif;?>
    <?php if($site['style']):?>
    <link rel="stylesheet" href="<?php echo $this->url('asset/css/'.$site['style'].'.css');?>">
	<?php endif;?>
</head>
<body>
	
	<div class="container">
		<div class="layout">
			<div>
				<div id="iview">
					<?php
					$utime = $item['utime'];
					$image_path = $item['image_path'];
					$imageInfo = json_decode($item['image'], true);
					$thumbInfo = json_decode($item['thumb'], true);
					$images = $imageInfo['image'];
					$thumbs = $thumbInfo['image'];
					$count = count($images);
					for ($i = 0; $i < $count; $i++):
					?>
					<div data-iview:thumbnail="<?php echo $this->url($image_path.'/'.$thumbs[$i], $utime);?>" data-iview:image="<?php echo $this->url($image_path.'/'.$images[$i], $utime);?>">
						<!--<div class="iview-caption caption1" data-x="40%" data-y="80%" data-transition="expandDown"></div>-->
					</div>
					<?php endfor;?>
				</div>
			</div>
			<div>
				<div class="about">
					<h1><?php echo $item['title'];?></h1>
					<div class="col color">
						<label>颜色</label>
						<div>
							<?php
							$colorInfo = json_decode($item['color'], true);
							$cimages = $colorInfo['image'];
							$ccount = count($cimages);
							for ($i=0; $i < $ccount; $i++):
								$image = $image_path . '/' . $cimages[$i];
								$color = $this->request->root(true) . $image_path . '/' . $cimages[$i];
							?>
							<a href="javascript:;" style="background-image:url(<?php echo $this->url($image, $utime);?>);" data-color="<?php echo $color;?>"><span></span></a>
							<?php endfor;?>
						</div>
					</div>
					<div class="col intr">
						<label>介绍</label>
						<div>
							<?php echo $item['introduce'];?>
							<a href="javascript:;" id="more">More</a>
						</div>
					</div>
					<div class="col price">
						<label>价格</label>
						<div>
							<strong>¥<?php echo $item['price'];?></strong>
							<del>¥<?php echo $item['price2'];?></del>
						</div>
					</div>
					<div class="col buy">
						<button id="now-buy"><i class="icon icon-cart"></i>&nbsp;现在购买</button>
					</div>
					<div class="order">
						<form id="order-form">
							<input type="hidden" name="item_id" id="item_id" value="<?php echo $item['id'];?>">
							<input type="hidden" name="color" id="color">
							<fieldset>
								<legend>收货人信息</legend>
								<div class="field">
									<input type="text" placeholder="您的姓名" name="linkman" id="linkman" value="">
								</div>
								<div class="field">
									<input type="tel" placeholder="手机号码" name="mobile" id="mobile" value="">
								</div>
								<div class="field">
									<div id="distpicker">
										<select name="province" id="province" data-province="<?php echo $area['region'];?>"></select>
										<select name="city" id="city" data-city="<?php echo $area['city'];?>"></select>
										<select name="district" id="district"></select>
									</div>
								</div>
								<div class="field">
									<input type="text" placeholder="详细地址" name="address" id="address" value="">
								</div>
								<div class="field">
									<input type="number" placeholder="购买数量" name="quantity" id="quantity" min="1" max="999" value="">
								</div>
								<div class="field">
									<textarea placeholder="留言（可填）" name="message" id="message"></textarea>
								</div>
							</fieldset>
							<input type="hidden" name="_token" value="<?php echo token();?>">
						</form>
					</div>
					<a href="javascript:;" id="order-cancel">取消</a>
					<button id="order-submit">提交订单</button>
				</div>
			</div>
		</div>
		
		<!-- 商品详细 -->
		<div id="details">
			<a href="javascript:;" id="close"><i class="icon icon-close"></i></a>
			<div class="content">
				<?php echo $this->decode($item['content']);?>
			</div>
		</div>
		
	</div>
	
	<script src="<?php echo $this->url('asset/js/jquery.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/jquery.easing.min.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/raphael.min.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/iview.min.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/velocity.min.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/distpicker.data.min.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/distpicker.min.js');?>"></script>
	<script src="<?php echo $this->url('asset/js/main.min.js');?>"></script>
		
	<?php
	if ($site['stats_open'] == 1)
	{
		$squery = http_build_query(array(
				'r'=>$this->request->root(),
				'm'=>$site['stats_much'],
				'u'=>$site['stats_unit'],
				'd'=>$site['stats_date']
			)
		);
		
		echo '<script src="' . $this->url('asset/js/stats.js?' . $squery) . '"></script>';
	}
	
	if ($site['stats3_open'] == 1) { echo $this->decode($site['stats3_code']); }
	?>
	
</body>
</html>
