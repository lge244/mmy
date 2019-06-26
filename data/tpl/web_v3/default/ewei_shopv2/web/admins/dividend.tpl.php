<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>保险分润<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>
</div>
<div class="page-content">
	<form action="<?php  echo webUrl('admins/index/dividend')?>" method="post">
		<div class="page-sub-toolbar">
			<span class=''></span>
		</div>
		<div class="form-group">
			<label class="col-lg control-label">指定客服</label>
			<div class="col-sm-9 col-xs-12">
				<select class="form-control tpl-category-parent select2" id="uid" name="uid"  data-rule-required="true" >
					<?php  if(is_array($service_list)) { foreach($service_list as $v) { ?>
					<option value="<?php  echo $v['uid'];?>"><?php  echo $v['username'];?></option>
					<?php  } } ?>
				</select>
			</div>
		</div>
		<div class="form-group" style="margin-top: 10px;">
			<label class="col-lg control-label"></label>
			<div class="col-sm-9 col-xs-12">
				<input type="submit" value="确定" class="btn btn-primary submit"/>
			</div>
		</div>
	</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>