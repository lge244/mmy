<?php defined('IN_IA') or exit('Access Denied');?><?php  $frames_system = buildframes('system')?>
<?php  if(empty($frames_system['section']['message']['is_display']) && $frames_system['section']['message']['is_display'] != '0') { ?>
<li class="dropdown msg header-notice">
    <a href="javascript:;" class="dropdown-toogle" data-toggle="dropdown"><span class="wi wi-bell"><span class="badge"></span></span></a>
    <div class="dropdown-menu">
        <div class="clearfix top">消息<a href="./index.php?c=message&a=notice" class="pull-right">查看更多</a></div>
    </div>
</li>
<?php  } ?>
