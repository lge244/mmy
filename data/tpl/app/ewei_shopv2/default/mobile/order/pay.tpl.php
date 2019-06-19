<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>

</style>
<div class='fui-page  fui-page-current order-pay-page'>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back" onclick='history.back()'></a>
        </div>
        <div class="title" style='margin-right:-2rem;'>收银台</div>
        <div class="fui-header-right">
            <!--<a href="<?php  echo mobileUrl('order')?>" class="external">我的订单</a>-->
        </div>
    </div>
    <div class='fui-content '>
        <div class="fui-cell-group" style="margin-top: 0">
            <div class="fui-cell">
                <div class="fui-cell-label">订单编号</div>
                <div class="fui-cell-info"></div>
                <div class="fui-cell-remark noremark"><?php  echo $order['ordersn'];?></div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">订单金额</div>
                <div class="fui-cell-info"></div>
                <div class="fui-cell-remark noremark"><span class='text-danger bigprice'>￥<?php  if(empty($ispeerpay)) { ?><?php  echo number_format($order['price'],2)?><?php  } else { ?><span id="peerpay"><?php  echo number_format($peerprice,2)?></span><?php  } ?></span>
                </div>
            </div>
        </div>


        <div class='fui-list-group' style="margin-top:10px;">
            <?php  if($order['price'] == 0) { ?>
            <!--<div class='fui-list pay-btn' data-type='credit'>-->
                <!--<div class='fui-list-media'>-->
                    <!--<i class='icon icon-money credit'></i>-->
                <!--</div>-->
                <!--<div class='fui-list-inner'>-->
                    <!--<div class="title">确认支付</div>-->
                <!--</div>-->
                <!--<div class='fui-list-angle'>-->
                    <!--<span class="angle"></span>-->
                <!--</div>-->
            <!--</div>-->
            <a id="btn-submit" class="external btn btn-danger block pay-btn"  style="margin-top:1.25rem" data-type='credit'>确认支付</a>
            <?php  } else { ?>
            <?php  if($wechat['success'] || (is_h5app() &&$payinfo['wechat'])) { ?>
            <div class='fui-list pay-btn' data-type='wechat' <?php  if(is_h5app()&&is_ios()) { ?>style="display: none;" id="threeWX"<?php  } ?>>
            <div class='fui-list-media'>
                <!--<i class='icon icon-wechat wechat'></i>-->
                <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/wx.png" alt="">
            </div>
            <div class='fui-list-inner'>
                <div class="title">
                    微信支付
                </div>
                <div class="subtitle c999 f24">
                    <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">微信安全支付
                </div>
            </div>
            <div class='fui-list-angle'><span class="angle"></span></div>
        </div>
            <?php  } ?>

            <?php  if(($alipay['success'] && !is_h5app()) || (is_h5app() &&$payinfo['alipay']) && empty($ispeerpay)) { ?>
            <div class='fui-list pay-btn' data-type='alipay'>
                <div class='fui-list-media'>
                    <!--<i class='icon icon-alipay alipay'></i>-->
                    <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/zfb.png" alt="">

                </div>
                <div class='fui-list-inner'>
                    <div class="title">
                        支付宝支付
                    </div>
                    <div class="subtitle c999 f24">
                        <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/safe.png" alt="" style="height: .8rem;vertical-align: text-bottom">支付宝安全支付
                    </div>
                </div>
                <div class='fui-list-angle'><span class="angle"></span></div>
            </div>
            <?php  } ?>


        <?php  if($credit['success']) { ?>
            <div class='fui-list pay-btn' data-type='credit'>
                <div class='fui-list-media'>
                    <!--<i class='icon icon-money credit'></i>-->
                    <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/ye.png" alt="">
                </div>
                <div class='fui-list-inner'>
                    <div class="title"><?php  echo $_W['shopset']['trade']['moneytext'];?>支付</div>
                    <div class="subtitle c999 f24">当前<?php  echo $_W['shopset']['trade']['moneytext'];?>: <span class='text-danger'>￥<?php  echo number_format($member['credit2'],2)?></span>
                    </div>
                </div>
                <div class='fui-list-angle'>
		    <span class="angle">

		    </span>
                </div>
            </div>
            <?php  } ?>
            <?php  if($cash['success'] && empty($ispeerpay)&&!$haveverifygood) { ?>
            <div class='fui-list pay-btn' data-type='cash'>
                <div class='fui-list-media'>
                    <!--<i class='icon icon-deliver1 cash'></i>-->
                    <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/hdfk.png" alt="">

                </div>
                <div class='fui-list-inner'>
                    <div class="title">货到付款</div>
                    <div class="subtitle c999 f24">收到商品后进行付款</div>
                </div>
                <div class='fui-list-angle'><span class="angle"></span></div>
            </div>
            <?php  } ?>

            <?php  if(!empty($peerPaySwi)) { ?>
            <div class='fui-list pay-btn' data-type='peerpay'>
                <div class='fui-list-media'>
                    <!--<i class='icon icon-natice peerpay' style="background: #ff9326;color: #fff"></i>-->
                    <img src="<?php echo EWEI_SHOPV2_STATIC;?>images/zrdf.png" alt="">
                </div>
                <div class='fui-list-inner'>
                    <div class="title">微信找人代付</div>
                    <div class="subtitle c999 f24">帮你付款的才是真爱</div>
                </div>
                <div class='fui-list-angle'><span class="angle"></span></div>
            </div>
            <?php  } ?>
            <?php  } ?>
        </div>
    </div>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH)) : (include template('order/pay/wechat_jie', TEMPLATE_INCLUDEPATH));?>
    <script language='javascript'>require(['biz/order/pay'], function (modal) {
        modal.init(<?php  echo json_encode($payinfo)?>);
    });</script>
</div>
<input type="hidden" value="<?php  echo $peerpayMessage;?>" id="peerpaymessage">
<?php  if(is_ios()) { ?>
    <?php  $initWX=true?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->