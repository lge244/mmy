<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>


<div class="page-header">

    当前位置：<span class="text-primary"><?php  if(!empty($level['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>保险分润<?php  if(!empty($level['id'])) { ?>(<?php  echo $level['levelname'];?>)<?php  } ?></span>

</div>


<div class="page-content">

    <div class="page-sub-toolbar">

        <span class=''>
        </span>

    </div>
    <input type="hidden" name="id" value="<?php  echo $level['id'];?>"/>
    <div class="form-group">

        <label class="col-lg control-label">股东规则</label>

        <div class="col-sm-9 col-xs-12">
            <div class='input-group fixsingle-input-group'>
                <span class='input-group-addon'>复购周期</span>
                <input type="number" name="shareholder_purchase_time" id="shareholder_purchase_time" class="form-control" value="<?php  echo $agency_rule['shareholder_purchase_time'];?>"/>
                <span class='input-group-addon'>天</span>
            </div>
            <div class='input-group fixsingle-input-group' style="margin-top: 5px;">
                <span class='input-group-addon'>指定商品</span>
                <select name="shareholder_goodsid" id="shareholder_goodsid" class="form-control tp_is_default" style="width:190px;">
                    <?php  if(is_array($goods)) { foreach($goods as $value) { ?>
                    <option value="<?php  echo $value['id'];?>" <?php  if($agency_rule['agency_goodsid']==$value['id']) { ?>selected<?php  } ?>><?php  echo $value['title'];?></option>
                    <?php  } } ?>
                </select>
            </div>
            <div class='input-group fixsingle-input-group' style="margin-top: 5px;">
                <span class='input-group-addon'>分红比例</span>
                <input type="number" name="shareholder_purchase_time" id="shareholder_ratio" class="form-control" value="<?php  echo $agency_rule['shareholder_ratio'];?>"/>
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
        var shareholder_purchase_time = $('#shareholder_purchase_time').val();
        var shareholder_ratio = $('#shareholder_ratio').val();
        var shareholder_goodsid = $('#shareholder_goodsid option:selected').val();
        if (shareholder_purchase_time == 0 || shareholder_goodsid == 0 || shareholder_ratio == 0){
            tip.msgbox.suc("规则信息请填写完整！");
            return false;
        }

        $.post("<?php  echo webUrl('member/shareholderRule/add')?>",{
            "shareholder_purchase_time":shareholder_purchase_time,
            "shareholder_goodsid":shareholder_goodsid,
            "shareholder_ratio":shareholder_ratio,
        },function (res) {
            if(res.code == 0){
                tip.msgbox.suc(res.msg)
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg)
            }
        },'json')
    })
</script>
