<?php defined('IN_IA') or exit('Access Denied');?><div class="fui-navbar">
    <a href="<?php  echo mobileUrl('mmanage')?>" class="external nav-item <?php  if($_W['routes']=='mmanage') { ?>active<?php  } ?>">
        <span class="icon icon-home"></span>
        <span class="label">工作台</span>
    </a>

    <?php if(cv('member')) { ?>
        <a href="<?php  echo mobileUrl('mmanage/member')?>" class="external nav-item <?php  if($_W['controller']=='member') { ?>active<?php  } ?>">
            <span class="icon icon-group"></span>
            <span class="label">会员</span>
        </a>
    <?php  } ?>

    <?php if(cv('order')) { ?>
        <a href="<?php  echo mobileUrl('mmanage/order', array('status'=>1))?>" class="external nav-item <?php  if($_W['controller']=='order') { ?>active<?php  } ?>">
            <span class="icon icon-rejectedorder"></span>
            <span class="label">订单</span>
        </a>
    <?php  } ?>

    <?php if(cv('finance')) { ?>
        <a href="<?php  echo mobileUrl('mmanage/finance')?>" class="external nav-item <?php  if($_W['controller']=='finance') { ?>active<?php  } ?>">
            <span class="icon icon-home"></span>
            <span class="label">财务</span>
        </a>
    <?php  } ?>

    <a href="<?php  echo mobileUrl('mmanage/set')?>" class="external nav-item <?php  if($_W['controller']=='set') { ?>active<?php  } ?>">
        <span class="icon icon-set"></span>
        <span class="label">设置</span>
    </a>


</div>

<!--NDAwMDA5NzgyNw==-->