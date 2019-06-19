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
    当前位置：<span class="text-primary">会员提现</span>
</div>
<div class="page-content">
    <!--<div class="fixed-header">-->
    <!--<div style="width:25px;"></div>-->
    <!--<div style="width:80px;text-align:center;">排序</div>-->
    <!--<div style="width:80px;">商品</div>-->
    <!--<div class="flex1">&nbsp;</div>-->
    <!--<div style="width: 100px;">价格</div>-->
    <!--<div style="width: 80px;">库存</div>-->
    <!--<div style="width: 80px;">销量</div>-->
    <?php  if($goodsfrom!='cycle') { ?>
    <!--<div style="width:80px;">状态</div>-->
    <?php  } ?>
    <!--<div class="flex1">属性</div>-->
    <!--<div style="width: 120px;">操作</div>-->
    <!--</div>-->

    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:15%;">用户名</th>
                    <th style="width:25%;">提现类型</th>
                    <th style="width:25%;">账户名称</th>
                    <th style="width:20%;">提现账户</th>
                    <th style="width:20%;">提现金额</th>
                    <th style="width:20%;">提现状态</th>
                    <th style="width:20%;">提现时间</th>
                    <th style="width:20%;">操作</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($withdraw_list)) { foreach($withdraw_list as $row) { ?>
                <tr>
                    <td><?php  echo $row['nickname'];?></td>
                    <td><?php  if($row['pay_type'] == 1) { ?>微信<?php  } else { ?>支付宝<?php  } ?></td>
                    <td><?php  echo $row['username'];?></td>
                    <td><?php  echo $row['account'];?></td>
                    <td>
                        提款金额：<?php  echo $row['money'];?>
                        <br>手续费：<?php  echo $row['money']*0.06?>
                        <br>实际打款：<?php  echo $row['money'] - $row['money']*0.06?>
                    </td>
                    <td><?php  if($row['status'] == 0) { ?>未审核<?php  } else { ?><?php  if($row['status'] == 1) { ?><span style="color:#00ff00;">已发款</span> <?php  } else { ?><span style="color: #ff0011">已驳回</span><?php  } ?><?php  } ?></td>
                    <td><?php  echo date('Y-m-d',$row['withdraw_time'])?></td>
                    <td>
                        <?php  if($row['status'] == 1 ||$row['status'] == 2) { ?>
                        <?php  } else { ?>
                        <a class='btn  btn-op btn-operation confirm'
                           href="#" data-id="<?php  echo $row['id'];?>"
                           data-confirm='确定已经拨款吗？'>
                            拨款
                        </a><a class='btn  btn-op btn-operation reject'
                               href="#" data-id="<?php  echo $row['id'];?>"
                               data-confirm='确定驳回吗？'>
                        驳回
                    </a>
                        <?php  } ?>
                    </td>
                </tr>
                <?php  } } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!--<div class="panel panel-default">-->
    <!--<div class="panel-body empty-data">暂时没有任何管理员!</div>-->
    <!--</div>-->

</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('goods/batchcates', TEMPLATE_INCLUDEPATH)) : (include template('goods/batchcates', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<script>
    $('.confirm').click(function () {

        var id = $(this).attr('data-id');
        $.post("<?php  echo webUrl('member/withdraw/confirm')?>",{id:id},function (res) {
            if (res.code == 0){
                tip.msgbox.suc(res.msg);
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg);
            }
        },'json')
    })
    $('.reject').click(function () {
        var id = $(this).attr('data-id');
        $.post("<?php  echo webUrl('member/withdraw/reject')?>",{id:id},function (res) {
            if (res.code == 0){
                tip.msgbox.suc(res.msg);
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg);
            }
        },'json')
    })
</script>