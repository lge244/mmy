<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="fui-list-group order-item" data-orderid="207" data-verifycode="">
    <?php  if(is_array($info)) { foreach($info as $i) { ?>
<!--    <a href="./index.php?i=2&amp;c=entry&amp;m=ewei_shopv2&amp;do=mobile&amp;r=order.detail&amp;id=207" data-nocache="true">-->

        <div class="fui-list-group-title lineblock2 ">

            昵称: <?php  echo $i['realname'];?>

<!--            <span class="status text-success">待评价</span>-->
        </div>

        <div class="fui-list goods-list">

<!--            <div class="fui-list-media" style="">-->

<!--                <img class="" src="http://www.mmy.com/attachment/images/2/2019/06/z8K1J5KMIiMj85joRtliJTzIiwJ858.jpg?t=sTs00eBbLIstM88Wi8mlV8W8W33MvTBg33mTM3mjn0ht8bwlVA" data-lazyloaded="true">-->

<!--            </div>-->

            <div class="fui-list-inner">

                <div class="text goodstitle towline">手机号:<?php  echo $i['mobile'];?></div>

            </div>

            <div class="fui-list-angle">

                <span class="marketprice">级别:<?php  echo $i['level'];?><br>
<!--                    <span style="color: #999">x1</span>-->
                </span>
            </div>

        </div>


        <div class="fui-list-group-title lineblock">
            <div class="fui-list-inner">

                <div class="text goodstitle towline">注册时间:<?php  echo date("Y-m-d H:i:s",$i['createtime'])?></div>

            </div>
<!--            <span class="status noremark">共 <span>1</span> 个商品 实付: <span class="text-danger">¥ <span class="bigprice">4049.99</span></span></span>-->

<!--        </div>-->

<!--    </a>-->

<!--    <div class="fui-list-group-title lineblock   opblock">-->

<!--        <span class="status noremark">-->

<!--    <div class="btn btn-default btn-default-o order-delete" data-orderid="207">删除订单</div>-->

<!--&lt;!&ndash;    <a class="btn btn-sm btn-danger-o" data-nocache="true" href="./index.php?i=2&amp;c=entry&amp;m=ewei_shopv2&amp;do=mobile&amp;r=order.comment&amp;id=207">评价</a>&ndash;&gt;-->

<!--&lt;!&ndash;    <a class="btn btn-default btn-default-o" href="./index.php?i=2&amp;c=entry&amp;m=ewei_shopv2&amp;do=mobile&amp;r=order.express&amp;id=207" data-nocache="true">查看物流</a>&ndash;&gt;-->

<!--        </span>-->

    </div>
    <?php  } } ?>
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>