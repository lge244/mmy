<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">系统授权</span>
</div>

<div class="page-content">
<form action="" method="post" class="form-horizontal form-validate" enctype="multipart/form-data" >

    <div class="form-group">
        <label class="col-sm-2 control-label">域名</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" name="domain" class="form-control" value="<?php  echo $domain;?>" readonly/>
            <span class="help-block">服务器域名</span>
        </div>
    </div>
      <div class="form-group">
        <label class="col-sm-2 control-label">站点IP</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" name="ip" class="form-control" value="<?php  echo $ip;?>" readonly/>
            <span class="help-block">站点IP</span>
        </div>
    </div>
  <div class="form-group">
        <label class="col-sm-2 control-label">模块标识</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" name="modname" class="form-control" value="<?php  echo $modname;?>" readonly />
            <span class="help-block">请填写模块英文标识</span>
        </div>
    </div>

    <div class="form-group">
        <label class="col-sm-2 control-label">授权码</label>
        <div class="col-sm-9 col-xs-12">
            <input type="text" name="code" class="form-control" value="<?php  echo $auth['code'];?>" data-rule-required='true' data-msg-required='请填写授权码' />
            <span class="help-block">请联系微信可名客服QQ:583441274 索取授权码，保护好您的授权码，避免泄漏</span>
        </div>
    </div>
    <div class="form-group">
        <label class="col-sm-2 control-label">授权状态</label>
        <div class="col-sm-9 col-xs-12">
            <div class='form-control-static'>
                <?php  if(!empty($result['status'])) { ?>
                <span class='label label-primary'>已授权</span>
                <?php  } else if($status==0) { ?>
                <span class='label label-danger'>未授权</span>
                <?php  } ?>
            </div>
        </div>
    </div>
    <?php  if(!empty($result['status'])) { ?>
<!--     <div class="form-group">
        <label class="col-sm-2 control-label">endtime</label>
        <div class="col-sm-9 col-xs-12">
            <div class='form-control-static'>
                <span class='label label-warning'><?php  echo $result['result']['auth_date_end'];?></span>
            </div>
        </div>
    </div> -->
    <?php  } ?>

    <div class="form-group">
        <label class="col-sm-2 control-label"></label>
        <div class="col-sm-9 col-xs-12">
            <div class='form-control-static'>

                <input type="submit"  value="验证授权" class="btn btn-primary" />
                <?php  if(empty($result['status'])) { ?>
                <input type="button" style="margin-left:10px;" onclick="location.href='<?php  echo webUrl('system/auth/upgrade')?>'" value="系统升级" class="btn btn-success" />
                <?php  } ?>

            </div>
        </div>
    </div>
</form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>