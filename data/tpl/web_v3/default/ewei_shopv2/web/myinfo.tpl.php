<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary">我的用户消费记录</span>
</div>
<div class="page-content">

    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:15%;">记录ID</th>
                    <th style="width:25%;">用户名称</th>
                    <th style="width:20%;">用户电话</th>
                    <th style="width:20%;">返利金额</th>
                    <th style="width:20%;">返利时间</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                    <td><?php  if(($row['mid']['realname']) == "") { ?> <?php  echo $row['mid']['nickname'];?> <?php  } else { ?> <?php  echo $row['mid']['realname'];?><?php  } ?></td>
                    <td><?php  echo $row['mid']['mobile'];?></td>
                    <td><?php  echo $row['brokerage'];?> 元</td>
                    <td><?php  echo date('Y-m-d H:i:s',$row['time']); ?></td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

