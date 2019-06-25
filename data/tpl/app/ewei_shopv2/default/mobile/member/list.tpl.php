<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="fui-list-group order-item" data-orderid="207" data-verifycode="">
    <?php  if(is_array($info)) { foreach($info as $i) { ?>
        <div class="fui-list-group-title lineblock2 ">
            订单状态: <?php  if($i['status']==0) { ?>待付款<?php  } else if($i['status']==1) { ?>待发货<?php  } else if($i['status']==2) { ?>待收货<?php  } else if($i['status']==3) { ?>已完成<?php  } else { ?>已关闭<?php  } ?>
        </div>
        <div class="fui-list goods-list">
            <div class="fui-list-inner">
                <div class="text goodstitle towline">商品总价格:￥<?php  echo $i['goodsprice'];?></div>
            </div>
        </div>
        <div class="fui-list goods-list">
            <div class="fui-list-inner">
                <div class="text goodstitle towline">总运费:￥<?php  echo $i['dispatchprice'];?></div>
            </div>
        </div>
        <div class="fui-list goods-list">
            <div class="fui-list-inner">
                <div class="text goodstitle towline">总税费:￥<?php  echo $i['tax'];?></div>
            </div>
        </div>
        <div class="fui-list-group-title lineblock">
            <div class="fui-list-inner">
                <div class="text goodstitle towline">总实际支付:<?php  echo date("Y-m-d H:i:s",$i['createtime'])?></div>
            </div>
        </div>
    <?php  } } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>