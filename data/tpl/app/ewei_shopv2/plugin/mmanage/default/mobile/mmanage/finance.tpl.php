<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">财务管理</div>
        <div class="fui-header-right"></div>
    </div>
    <!-- 顶部tab -->
    <div id="tab" class="fui-tab fui-tab-success fixed">
        <?php if(cv('finance.log.recharge')) { ?>
            <a data-tab="0" <?php  if($type==0) { ?>class="active"<?php  } ?>>充值记录</a>
        <?php  } ?>
        <?php if(cv('finance.log.withdraw')) { ?>
            <a data-tab="1" <?php  if($type==1) { ?>class="active"<?php  } ?>>提现记录</a>
        <?php  } ?>
        <?php if(cv('finance.credit.credit1')) { ?>
            <a data-tab="2" <?php  if($type==2) { ?>class="active"<?php  } ?>>积分明细</a>
        <?php  } ?>
        <?php if(cv('finance.credit.credit2')) { ?>
            <a data-tab="3" <?php  if($type==3) { ?>class="active"<?php  } ?>>余额明细</a>
        <?php  } ?>
    </div>
    <div class='fui-content navbar'>

        <!-- 搜索框 -->
        <div class="fui-searchbar bar">
            <div class="searchbar center">
                <input type="submit" class="searchbar-cancel searchbtn" value="搜索" />
                <div class="search-input">
                    <i class="icon icon-search"></i>
                    <input type="search" placeholder="输入关键字..." class="search" id="keywords" />
                </div>
            </div>
        </div>


        <div class="fui-list-outer container container_l"></div>

        <div class="fui-list-group nomargin container container_c"></div>

        <div class="fui-title center" id="content-more">加载更多</div>
        <div class="fui-title center hide" id="content-empty">没有数据</div>
        <div class="fui-title center hide" id="content-nomore">没有更多了</div>
    </div>

    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/_tpl/finance', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/_tpl/finance', TEMPLATE_INCLUDEPATH));?>

    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/mmanage/static/js/finance.js'],function(modal){
            modal.initList({type: <?php  echo $type;?>});
        });
    </script>
</div>
<?php  $this->footerMenus(null, $texts)?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->