<?php defined('IN_IA') or exit('Access Denied');?><?php  $no_left =true;?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script type="text/javascript" src="../addons/ewei_shopv2/static/js/dist/area/cascade.js"></script>
<script type="text/javascript" src="../web/resource/js/lib/moment.js"></script>
<link rel="stylesheet" href="../web/resource/components/datetimepicker/jquery.datetimepicker.css">
<link rel="stylesheet" href="../web/resource/components/daterangepicker/daterangepicker.css">
<style type='text/css'>
	.tabs-container .form-group {
		overflow: hidden;
	}

	.tabs-container .tabs-left > .nav-tabs {
	}

	.tab-goods .nav li {
		float: left;
	}

	.spec_item_thumb {
		position: relative;
		width: 30px;
		height: 20px;
		padding: 0;
		border-left: none;
	}

	.spec_item_thumb i {
		position: absolute;
		top: -5px;
		right: -5px;
	}

	.multi-img-details, .multi-audio-details {
		margin-top: .5em;
		max-width: 700px;
		padding: 0;
	}

	.multi-audio-details .multi-audio-item {
		width: 155px;
		height: 40px;
		position: relative;
		float: left;
		margin-right: 5px;
	}

	.region-goods-details {
		background: #f8f8f8;
		margin-bottom: 10px;
		padding: 0 10px;
	}

	.region-goods-left {
		text-align: center;
		font-weight: bold;
		color: #333;
		font-size: 14px;
		padding: 20px 0;
	}

	.region-goods-right {
		border-left: 3px solid #fff;
		padding: 10px 10px;
	}

	<?php  if($item ['type'] == 4) { ?>
	.type-4 {
		display: none;
	}
	<?php  } ?>

</style>

<div class="page-header">
	当前位置：
	<span class="text-primary">
    <?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>管理员 <small><?php  if(!empty($item['id'])) { ?>修改【<span class="text-info"><?php  echo $item['title'];?></span>】<?php  } ?><?php  if(!empty($merch_user['merchname'])) { ?>商户名称:【<span
			class="text-info"><?php  echo $merch_user['merchname'];?></span>】<?php  } ?></small>
    </span>
</div>
<div class="page-content">
	<form method="post" action="<?php  echo webUrl('goods/freight/save')?>">
		<input type="hidden" id="tab" name="tab" value="#tab_basic"/>
		<div class="tabs-container tab-goods">
			<div class="tabs-left">
				<ul class="nav nav-tabs" id="myTab">
					<li <?php  if(empty($_GPC['tab']) || $_GPC['tab']=='basic') { ?>class="active"<?php  } ?>><a href="#tab_basic">基本</a></li>
				</ul>
				<div class="tab-content  ">
					<div class="region-goods-details row">
						<div class="region-goods-left col-sm-2">
							运费配置
						</div>
						<div class="region-goods-right col-sm-10">
							<input type="hidden" name="id" id="id" class="form-control" value="<?php  echo $info['id'];?>"
							       data-rule-required="true"/>
							<div class="form-group dispatch_info">
								<label class="col-sm-2 control-label">地址</label>
								<div class="col-sm-5">
									<select class="form-control tpl-category-parent select2" id="address" name="address" data-rule-required="true">
										<?php  if(is_array($address)) { foreach($address as $v) { ?>
										<option value="<?php  echo $v;?>" <?php  if($info['address'] == $v) { ?> selected <?php  } ?> ><?php  echo $v;?></option>
										<?php  } } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label must">距离运费</label>
								<div class="col-sm-5" style="padding-right:0;">
									<input type="number" name="distance_shipping" id="distance_shipping" class="form-control"
									       value="<?php  echo $info['distance_shipping'];?>" data-rule-required="true"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label must">首重(kg)</label>
								<div class="col-sm-5" style="padding-right:0;">
									<input type="number" name="first_weight" id="first_weight" class="form-control"
									       value="<?php  echo $info['first_weight'];?>" data-rule-required="true"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label must">续重(kg)</label>
								<div class="col-sm-5" style="padding-right:0;">
									<input type="number" name="continued_weight" id="continued_weight" class="form-control"
									       value="<?php  echo $info['continued_weight'];?>" data-rule-required="true"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label must">首重价格(¥/kg)</label>
								<div class="col-sm-5" style="padding-right:0;">
									<input type="number" name="first_weight_price" id="first_weight_price" class="form-control"
									       value="<?php  echo $info['first_weight'];?>" data-rule-required="true"/>
								</div>
							</div>
							<div class="form-group">
								<label class="col-sm-2 control-label must">续重价格(¥/kg)</label>
								<div class="col-sm-5" style="padding-right:0;">
									<input type="number" name="continued_weight_price" id="continued_weight_price" class="form-control"
									       value="<?php  echo $info['continued_weight_price'];?>" data-rule-required="true"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-sm-2 control-label"></label>
			<div class="col-sm-9 subtitle">
				<button id="submit" class="btn btn-primary">保存管理</button>
				<a class="btn btn-default" href="<?php  echo webUrl('goods/freight')?>">返回列表</a>
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

