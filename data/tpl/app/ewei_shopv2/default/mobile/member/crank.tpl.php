<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<title><?php  echo $this->set['texts']['commission']?>排名</title>
<link rel="stylesheet" href="../addons/ewei_shopv2/template/mobile/default/static/css/rank.css">
<div class="fui-page page-rank yellow" style="overflow:auto;">
        <div class="fui-header">
            <div class="fui-header-left">
                <a class="back" onclick='location.back()'></a>
            </div>
            <div class="title">佣金排名</div>
            <div class="fui-header-right">&nbsp;</div>
        </div>
    <div class="fui-content">
    <div class="rankhead">
    <div class="head">
        <div class="child">
            <span></span>
            <p class="text"></p>
        </div>
        <div class="child gold">
            <span><?php  echo $myrank;?></span>
            <p class="text">我的名次</p>
        </div>
        <div class="child">
            <span><?php  echo $mycommission;?>元</span>
            <p class="text">总佣金</p>
        </div>
    </div>
    <div class="title">佣金排名自动更新</div>
</div>
<div class="rankline">
    <div class="left"></div>
    <div class="right"></div>
    <div class="center"></div>
</div>
<div class="ranklist">
    <div class="main">
        <div class="line title">
            <div class="col">排名</div>
            <div class="col">昵称</div>
            <div class="col">佣金</div>
        </div>
        <?php  if(is_array($ranks)) { foreach($ranks as $r) { ?>
        <div class="line">
            <div class="col"><?php  echo $r['rank'];?></div>
            <div class="col" style="text-align: center"><?php  echo $r['realname'];?></div>
            <div class="col"><?php  echo $r['past_brokerage'];?></div>
        </div>
        <?php  } } ?>
        <div id="container" ></div>
    </div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--青岛易联互动网络科技有限公司-->