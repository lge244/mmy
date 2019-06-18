<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/template/account/default2/style.css?v=2.0.0">
<style type="text/css">
    .header {background-image: url("<?php echo empty($set['wap']['bg'])?'../addons/ewei_shopv2/template/account/default2/bg.jpg':tomedia($set['wap']['bg'])?>"); background-repeat: no-repeat}
    .btn {background: <?php  if(!empty($set['wap']['color'])) { ?><?php  echo $set['wap']['color'];?><?php  } else { ?>#fea119<?php  } ?>;}
    .text a {color: <?php  if(!empty($set['wap']['color'])) { ?><?php  echo $set['wap']['color'];?><?php  } else { ?>#fea119<?php  } ?>;}
    .header .logo {box-shadow: <?php  if(!empty($set['wap']['color'])) { ?><?php  echo $set['wap']['color'];?><?php  } else { ?>#fea119<?php  } ?> 0px 1px 8px;}
</style>
<div class="fui-page">
    <?php  if(is_h5app()) { ?>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back"> </a>
        </div>
        <div class="title">用户登录</div>
        <div class="fui-header-right" data-nomenu="true"></div>
    </div>
    <?php  } ?>
    <div class="fui-content">

        <div class="header">
            <div class="logo">
                <img src="<?php  echo tomedia($set['shop']['logo'])?>" />
            </div>
        </div>

        <div class="acc-input-group">
            <div class="acc-input">
                <div class="title">11位手机号</div>
                <div class="input">
                    <input type="tel" class="input-inner" value="<?php  echo trim($_GPC['mobile'])?>" placeholder="请输入手机号码" name="mobile" id="mobile" maxlength="11" />
                </div>
            </div>
            <div class="acc-input">
                <div class="title">登录密码</div>
                <div class="input">
                    <input type="password" class="input-inner" value="" placeholder="请输入密码" name="pwd" id="pwd" maxlength="20" />
                    <a class="remark" href="<?php  echo $set['wap']['forgeturl'];?>">忘记密码</a>
                </div>
            </div>
        </div>

        <div class="btn" id="btnSubmit">立即登录</div>
        <div class="text">
            <p>还没有帐号? <a href="<?php  echo $set['wap']['regurl'];?>">立即注册</a></p>
        </div>
        <?php  if(is_h5app()) { ?>
            <?php  if(!empty($sns['wx']) || !empty($sns['qq'])) { ?>
                <div class="sns-login">
                    <div class="title">
                        <div class="text">第三方登录</div>
                    </div>
                    <div class="icons">
                        <?php  if(!empty($sns['wx'])) { ?>
                            <div class="item green btn-sns" data-sns="wx" style="display: none;" id="threeWX"><i class="icon icon-wechat1"></i></div>
                        <?php  } ?>
                        <?php  if(!empty($sns['qq'])) { ?>
                            <div class="item blue btn-sns" data-sns="qq"><i class="icon icon-qq" style="font-size: 1.5rem"></i></div>
                        <?php  } ?>
                    </div>
                </div>
            <?php  } ?>
        <?php  } ?>

        <script language='javascript'>
            require(['biz/member/account'], function (modal) {
                modal.initLogin({backurl:'<?php  echo $backurl;?>'});
            });
        </script>
    </div>
</div>

<?php  $initWX=true?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>