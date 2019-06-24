<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="fui-list-group order-item" data-orderid="207" data-verifycode="">
    <?php  if(is_array($info)) { foreach($info as $i) { ?>
    <a href="<?php  echo MobileUrl('member/list',array('id'=>$i['id']))?>">
        <div class="fui-list-group-title lineblock2 ">
            昵称: <?php  echo $i['realname'];?>
        </div>
        <div class="fui-list goods-list">
            <div class="fui-list-inner">
                <div class="text goodstitle towline">手机号:<?php  echo $i['mobile'];?></div>
            </div>
            <div class="fui-list-angle">
                <span class="marketprice">级别:<?php  if($i['level']==0) { ?>普通会员<?php  } else if($i['level']==5) { ?>代理商<?php  } else { ?>股东<?php  } ?><br></span>
            </div>
        </div>
        <div class="fui-list-group-title lineblock">
            <div class="fui-list-inner">
                <div class="text goodstitle towline">注册时间:<?php  echo date("Y-m-d H:i:s",$i['createtime'])?></div>
            </div>
    </div>
    </a>
    <?php  } } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>