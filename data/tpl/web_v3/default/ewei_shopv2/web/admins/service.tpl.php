<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
	当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>保险分润<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>
</div>
<div class="page-content">
	<div class="page-sub-toolbar">
		<span class=''></span>
	</div>
	<input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
	<div class="form-group">
		<label class="col-lg control-label">客服提成</label>
		<div class="col-sm-9 col-xs-12">
			<div class='input-group fixsingle-input-group' style="margin-top: 5px;">
				<span class='input-group-addon'>提成比例</span>
				<input type="number" name="agency_purchase_time" id="service_ratio" class="form-control"
				       value="<?php  echo $service_ratio['service_ratio'];?>"/>
				<span class='input-group-addon'>%</span>
			</div>
		</div>
	</div>
	<div class="form-group">
		<label class="col-lg control-label">客服总提成</label>
		<div class="col-sm-9 col-xs-12">
			<div class='input-group fixsingle-input-group' style="margin-top: 5px;">
				<span class='input-group-addon'>提成比例</span>
				<input type="number" name="agency_purchase_time" id="sum_service_ratio" class="form-control"
				       value="<?php  echo $service_ratio['sum_service_ratio'];?>"/>
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
</div>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
	$('.submit').click(function () {
		var service_ratio = $('#service_ratio').val();
		var sum_service_ratio = $('#sum_service_ratio').val();
		if (service_ratio == 0) {
			tip.msgbox.err("规则信息请填写完整！");
			return false;
		}

		$.post("<?php  echo webUrl('admins/service/post')?>", {
			"service_ratio": service_ratio,
			"sum_service_ratio": sum_service_ratio,
		}, function (res) {
			if (res.code == 0) {
				tip.msgbox.suc(res.msg);
				window.location.reload();
			} else {
				tip.msgbox.err(res.msg)
			}
		}, 'json')
	})
</script>
