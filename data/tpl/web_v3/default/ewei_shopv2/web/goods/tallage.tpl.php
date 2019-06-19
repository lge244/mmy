<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">购物税管理</span>
</div>
<div class="page-content">

    <div class="page-sub-toolbar">


    </div>
    <input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
    <div class="form-group">
        <label class="col-lg control-label">购物税设置</label>
        <div class="col-sm-9 col-xs-12">
            <div class='input-group fixsingle-input-group'>
                <span class='input-group-addon'>购物税</span>
                <input type="number" name="agency_purchase_time" id="purchase_tax" class="form-control"
                       value="<?php  echo $purchase_tax['purchase_tax'];?>"/>
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
        var purchase_tax = $('#purchase_tax').val();
        if (purchase_tax <= 0) {
            tip.msgbox.suc("规则信息请填写完整！");
            return false;
        }

        $.post("<?php  echo webUrl('goods/tallage/post')?>", {
            "purchase_tax": purchase_tax,
        }, function (res) {
            if (res.code == 0) {
                tip.msgbox.suc(res.msg)
                window.location.reload();
            } else {
                tip.msgbox.err(res.msg)
            }
        }, 'json')
    })
</script>
