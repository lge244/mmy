<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    tbody tr td {
        position: relative;
    }

    tbody tr .icow-weibiaoti-- {
        visibility: hidden;
        display: inline-block;
        color: #fff;
        height: 18px;
        width: 18px;
        background: #e0e0e0;
        text-align: center;
        line-height: 18px;
        vertical-align: middle;
    }

    tbody tr:hover .icow-weibiaoti-- {
        visibility: visible;
    }

    tbody tr .icow-weibiaoti--.hidden {
        visibility: hidden !important;
    }

    .full .icow-weibiaoti-- {
        margin-left: 10px;
    }

    .full > span {
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        vertical-align: middle;
        align-items: center;
    }

    tbody tr .label {
        margin: 5px 0;
    }

    .goods_attribute a {
        cursor: pointer;
    }

    .newgoodsflag {
        width: 22px;
        height: 16px;
        background-color: #ff0000;
        color: #fff;
        text-align: center;
        position: absolute;
        bottom: 70px;
        left: 57px;
        font-size: 12px;
    }

    .modal-dialog {
        min-width: 720px !important;
        position: absolute;
        left: 0;
        right: 0;
        top: 50%;
    }

    .catetag {
        overflow: hidden;

        text-overflow: ellipsis;

        display: -webkit-box;

        -webkit-box-orient: vertical;

        -webkit-line-clamp: 2;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary">管理员管理</span>
</div>
<div class="page-content">
    <div class="fixed-header">
        <div style="width:25px;">商品名称</div>
        <div style="width:80px;text-align:center;">商品数量</div>
        <div style="width:80px;">商品</div>
        <div class="flex1">管理员</div>
        <div style="width: 100px;">描述</div>
        <div style="width: 80px;">数量</div>
        <div style="width: 80px;">时间</div>
    </div>
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="goods.<?php  echo $goodsfrom;?>"/>

    </form>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:15%;">商品名称</th>
                    <th style="width:25%;">商品数量</th>
                    <th style="width:20%;">管理员</th>
                    <th style="width:20%;">描述</th>
                    <th style="width:20%;">数量</th>
                    <th style="width:20%;">时间</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($record)) { foreach($record as $row) { ?>
                <tr>
                    <td><?php  echo $row['title'];?></td>
                    <td><?php  echo $row['total'];?></td>
                    <td><?php  if($row['member']['truename'] == '') { ?> <?php  echo $row['member']['username'];?><?php  } else { ?> <?php  echo $row['member']['truename'];?><?php  } ?></td>
                    <td><?php  echo $row['desc'];?></td>
                    <td><?php  echo $row['difference'];?></td>
                    <td><?php  echo date('Y-m-d',$row['time'])?></td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/batchcates', TEMPLATE_INCLUDEPATH)) : (include template('goods/batchcates', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>


