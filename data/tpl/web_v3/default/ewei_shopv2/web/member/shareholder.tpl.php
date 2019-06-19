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
    当前位置：<span class="text-primary">学员课程列表</span>
</div>
<div class="page-content">


    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site"/>
        <input type="hidden" name="a" value="entry"/>
        <input type="hidden" name="m" value="ewei_shopv2"/>
        <input type="hidden" name="do" value="web"/>
        <input type="hidden" name="r" value="goods.<?php  echo $goodsfrom;?>"/>
        <div class="page-toolbar">
            <span class="pull-left" style="margin-right:30px;">
                <a class='btn btn-sm btn-primary' href="<?php  echo webUrl('member/shareholder/add')?>"><i class='fa fa-plus'></i> 添加股东</a>
            </span>
        </div>
    </form>
    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:15%;">股东账号</th>
                    <th style="width:25%;">股东名称</th>
                    <th style="width:20%;">升级时间</th>
                    <th style="width:20%;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($member)) { foreach($member as $row) { ?>
                <tr>
                    <td><?php  echo $row['mobile'];?></td>
                    <td><?php  if(($row['realname'] == '')) { ?><?php  echo $row['nickname'];?><?php  } else { ?><?php  echo $row['realname'];?><?php  } ?></td>
                    <td><?php  echo date('Y-m-d',$row['shareholder_time'])?></td>
                    <td>
                        <a  class='btn  btn-op btn-operation' onclick="pass(<?php  echo $row['id'];?>)" href="#">
                                   <span data-toggle="tooltip" data-placement="top" title="" data-original-title="通过">
                                        <i class='icow icow-bianji2'></i>
                                   </span>
                        </a>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
        </div>
    </div>

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/batchcates', TEMPLATE_INCLUDEPATH)) : (include template('goods/batchcates', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
    function pass(id) {
       $.post("<?php  echo webUrl('training/pass')?>",{id:id},function (res) {
          if (res.code == 0){
              tip.msgbox.suc(res.msg);
              window.location.reload();
          }else{
              tip.msgbox.err(res.msg);
          }
       },'json')
    }
</script>
