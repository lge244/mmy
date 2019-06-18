<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">订单管理</div>
        <div class="fui-header-right">
            <a class="btn-more">更多</a>
        </div>
    </div>

    <!-- 顶部tab -->
    <div id="tab" class="fui-tab fui-tab-success fixed">
        <?php  if($status==4 || $status==5) { ?>
            <a <?php  if($status==4) { ?>class="active"<?php  } ?> data-status="4">维权申请</a>
            <a <?php  if($status==5) { ?>class="active"<?php  } ?> data-status="5">维权完成</a>
        <?php  } else { ?>
            <a <?php  if($status==1) { ?>class="active"<?php  } ?> data-status="1">待发货</a>
            <a <?php  if($status==0) { ?>class="active"<?php  } ?> data-status="0">待付款</a>
            <a <?php  if($status==2) { ?>class="active"<?php  } ?> data-status="2">待收货</a>
            <a <?php  if($status==3) { ?>class="active"<?php  } ?> data-status="3">已完成</a>
            <a <?php  if($status==-1) { ?>class="active"<?php  } ?> data-status="-1">已关闭</a>
        <?php  } ?>
    </div>
    <div class='fui-content navbar'>
        <!-- 搜索框 -->
        <div class="fui-search">
            <div class="inner">
                <i class="icon icon-search"></i>
                <div class="select">
                    <select id="searchfieid">
                        <option value="ordersn" <?php  if(empty($_GPC['searchfield'])||$_GPC['searchfieId']=='ordersn') { ?>selected<?php  } ?>>订单号</option>
                        <option value="member" <?php  if($_GPC['searchfield']=='member') { ?>selected<?php  } ?>>会员信息</option>
                        <option value="address" <?php  if($_GPC['searchfield']=='address') { ?>selected<?php  } ?>>收件人信息</option>
                        <option value="location" <?php  if($_GPC['searchfield']=='location') { ?>selected<?php  } ?>>地址信息</option>
                        <option value="expresssn" <?php  if($_GPC['searchfield']=='expresssn') { ?>selected<?php  } ?>>快递单号</option>
                        <option value="goodstitle" <?php  if($_GPC['searchfield']=='goodstitle') { ?>selected<?php  } ?>>商品名称</option>
                        <option value="goodssn" <?php  if($_GPC['searchfield']=='goodssn') { ?>selected<?php  } ?>>商品编码</option>
                        <option value="saler" <?php  if($_GPC['searchfield']=='saler') { ?>selected<?php  } ?>>核销员</option>
                        <option value="store" <?php  if($_GPC['searchfield']=='store') { ?>selected<?php  } ?>>核销门店</option>
                        <option value="merch" <?php  if($_GPC['searchfield']=='merch') { ?>selected<?php  } ?>>商户名称</option>
                    </select>
                </div>
                <input value="<?php  echo $_GPC['keyword'];?>" placeholder="输入关键字..." id="keywords" />
            </div>
            <div class="fui-search-btn">搜索</div>
        </div>
        <!-- 订单列表 -->
        <div class="fui-list-outer container"></div>

        <div class="fui-title center" id="content-more">加载更多</div>
        <div class="fui-title center hide" id="content-empty">没有数据</div>
        <div class="fui-title center hide" id="content-nomore">没有更多了</div>
    </div>

    <div class="head-menu-mask"></div>
    <div class="head-menu">
        <?php  if($status==4 || $status==5) { ?>
            <a href="<?php  echo mobileUrl('mmanage/order')?>" class="external"><i class="icon icon-rejectedorder"></i> 普通订单</a>
        <?php  } else { ?>
            <a href="<?php  echo mobileUrl('mmanage/order', array('status'=>4))?>" class="external"><i class="icon icon-rejectedorder"></i> 维权订单</a>
        <?php  } ?>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/_tpl/order', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/_tpl/order', TEMPLATE_INCLUDEPATH));?>

    <script type="text/javascript" src="../addons/ewei_shopv2/plugin/mmanage/static/js/init.js?v=<?php  echo time()?>"></script>
    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/mmanage/static/js/order.js'],function(modal){
            modal.initList({status: <?php  echo $status;?>, keywords: "<?php  echo $_GPC['keyword'];?>"});
        });
    </script>
</div>
<?php  $this->footerMenus(null, $texts)?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->