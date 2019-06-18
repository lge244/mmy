<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    body,ul,ol{margin:0;padding:0}
    ul,ol,menu{list-style:none}
    html {overflow-x: hidden;height: 100%;-webkit-tap-highlight-color: transparent;}
    body {font-family: Arial, "Microsoft Yahei", "Helvetica Neue", Helvetica, sans-serif;color: #333;font-size: .28em;line-height: 1;-webkit-text-size-adjust: none;}

    .list{width: 100%;padding: .2rem 0}
    ul{width: 100%;margin: 0 auto;display: flex;}
    li{flex: 1;text-align: center;padding: .3rem 0; }
    .head-title{border-bottom: 1px solid #ccc;font-weight: bold; font-size: .8rem}
    .content:nth-of-type(odd){ background: #f7f7f7;}
    .content:nth-of-type(even){ background:#fff;}
    .content{ background:#fff; font-size: .7rem}
</style>
<div class="fui-page-group ">
    <div class="fui-page  fui-page-current" id="fui-page-1554275708948">
        <div class="fui-header">
            <div class="fui-header-left">
                <a class="back" onclick="location.back()"></a>
            </div>
            <div class="title">下级佣金记录</div>
            <div class="fui-header-right"></div>
        </div>
    </div>
    <div class='fui-content member-page navbar'>
        <div class="list">
            <ul class="head-title">
                <li class="head-li">用户产生</li>
                <li class="head-li">积分数量</li>
                <li class="head-li">操作</li>
                <li class="head-li">日期</li>
            </ul>
            <?php  if(is_array($list)) { foreach($list as $row) { ?>
            <ul class="content">
                <li class="date"><?php  if(($row['member_info']['realname'] == '')) { ?> <?php  echo $row['member_info']['nickname'];?> <?php  } else { ?> <?php  echo $row['member_info']['realname'];?> <?php  } ?></li>
                <li class="number"><?php  echo $row['money'];?></li>
                <li class="operate"><?php  if(($row['type'] == 0)) { ?> 增加 <?php  } else { ?> 减少 <?php  } ?></li>
                <li class="user"><?php  echo date('Y-m-d',$row['time'])?></li>
            </ul>
            <?php  } } ?>
        </div>
    </div>
</div>


<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>