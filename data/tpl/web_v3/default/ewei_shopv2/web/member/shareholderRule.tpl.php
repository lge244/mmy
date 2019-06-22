<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>保险分润<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>
</div>
<div class="page-content">
	<div class="page-sub-toolbar">
		<span class=''></span>
	</div>
	<form action="<?php  echo webUrl('member/shareholderRule/add')?>" method="post">
		<input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
		<div class="form-group">
			<label class="col-lg control-label">股东规则</label>
			<div class="col-sm-9 col-xs-12">
				<div class='input-group fixsingle-input-group'>
					<span class='input-group-addon'>复购周期</span>
					<input type="number" name="shareholder_purchase_time" id="shareholder_purchase_time"
					       class="form-control" value="<?php  echo $agency_rule['shareholder_purchase_time'];?>"/>
					<span class='input-group-addon'>天</span>
				</div>
				<div class="form-group" style="display: block;margin-top: 10px;">
					<label class="col-sm-2 control-label">复购商品</label>
					<div class="col-sm-8 col-xs-12">
						<select id="shareholder_goodsid" name='shareholder_goodsid[]' class="form-control select2"
						        style='width:605px;' multiple=''>
							<?php  if(is_array($goods)) { foreach($goods as $value) { ?>
							<option value="<?php  echo $value['id'];?>" <?php  if(in_array($value['id'], $agency_rule_arr)) { ?>selected<?php  } ?>><?php  echo $value['title'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class='input-group fixsingle-input-group' style="margin-top: 5px;">
					<span class='input-group-addon'>分红比例</span>
					<input type="number" name="shareholder_ratio" id="shareholder_ratio" class="form-control"
					       value="<?php  echo $agency_rule['shareholder_ratio'];?>"/>
					<span class='input-group-addon'>%</span>
				</div>
				<div class='input-group fixsingle-input-group' style="margin-top: 5px;">
					<span class='input-group-addon'>上级提成</span>
					<input type="number" name="pshareholder_ratio" id="pshareholder_ratio" class="form-control"
					       value="<?php  echo $agency_rule['pshareholder_ratio'];?>"/>
					<span class='input-group-addon'>%</span>
				</div>
			</div>
		</div>
		<div class="form-group">
			<label class="col-lg control-label"></label>
			<div class="col-sm-9 col-xs-12">
				<input type="submit" value="保存" class="btn btn-primary submit"/>
			</div>
		</div>
	</form>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>