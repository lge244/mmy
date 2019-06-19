<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<?php  echo $info['content'];?>
<div>
    <div><?php  echo $goods['title'];?></div>
    <img src="http://www.mmy.com/attachment/<?php  echo $goods['thumb'];?>" alt="" style="width: 100px;height: 100px;border: 1px solid #ccc">
    <div><?php  echo $goods['marketprice'];?></div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>