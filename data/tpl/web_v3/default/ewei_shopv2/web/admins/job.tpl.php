<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    tbody tr td{
        position: relative;
    }
    tbody tr  .icow-weibiaoti--{
        visibility: hidden;
        display: inline-block;
        color: #fff;
        height:18px;
        width:18px;
        background: #e0e0e0;
        text-align: center;
        line-height: 18px;
        vertical-align: middle;
    }
    tbody tr:hover .icow-weibiaoti--{
        visibility: visible;
    }
    tbody tr  .icow-weibiaoti--.hidden{
        visibility: hidden !important;
    }
    .full .icow-weibiaoti--{
        margin-left:10px;
    }
    .full>span{
        display: -webkit-box;
        display: -webkit-flex;
        display: -ms-flexbox;
        display: flex;
        vertical-align: middle;
        align-items: center;
    }
    tbody tr .label{
        margin: 5px 0;
    }
    .goods_attribute a{
        cursor: pointer;
    }
    .newgoodsflag{
        width: 22px;height: 16px;
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
    .catetag{
        overflow:hidden;

        text-overflow:ellipsis;

        display:-webkit-box;

        -webkit-box-orient:vertical;

        -webkit-line-clamp:2;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary">权限列表</span>
</div>
<div class="page-content">
    <div class="fixed-header">
        <div style="width:25px;"></div>
        <div style="width:80px;text-align:center;">排序</div>
        <div style="width:80px;">商品</div>
        <div class="flex1">&nbsp;</div>
        <div style="width: 100px;">价格</div>
        <div style="width: 80px;">库存</div>
        <div style="width: 80px;">销量</div>
        <?php  if($goodsfrom!='cycle') { ?>
        <div  style="width:80px;" >状态</div>
        <?php  } ?>
        <div class="flex1">属性</div>
        <div style="width: 120px;">操作</div>
    </div>
    <form action="./index.php" method="get" class="form-horizontal form-search" role="form">
        <input type="hidden" name="c" value="site" />
        <input type="hidden" name="a" value="entry" />
        <input type="hidden" name="m" value="ewei_shopv2" />
        <input type="hidden" name="do" value="web" />
        <input type="hidden" name="r"  value="goods.<?php  echo $goodsfrom;?>" />
        <div class="page-toolbar">
            <span class="pull-left" style="margin-right:30px;">
                <a class='btn btn-sm btn-primary' href="<?php  echo webUrl('admins/job/add')?>"><i class='fa fa-plus'></i> 添加权限</a>
            </span>
        </div>
    </form>

    <div class="row">
        <div class="col-md-12">
            <table class="table table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width: 20%">权限id</th>
                    <th style="width: 30%" >权限名称</th>
                    <th style="width: 50%" >权限描述</th>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($category)) { foreach($category as $row) { ?>
                <tr>
                    <td><?php  echo $row['id'];?></td>
                    <td><?php  echo $row['jobtitle'];?></td>
                    <td><?php  echo $row['jobdesc'];?></td>
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
    //获得分类标签
    // var length = $('#catetag').children().length;
    // if (length >10){
    //     for (var i=2;i<length;i++)
    //     {
    //         $('#catetag').children().eq(i).hide();
    //     }
    //     $('#catetag').append('...等');
    // }
    //显示批量分类
    $('#batchcatesbut').click(function () {
        $('#batchcates').show();
    })

    //关闭批量分类
    $('.modal-header .close').click(function () {
        $('#batchcates').hide();
    })

    // 取消批量分类
    $('.modal-footer .btn.btn-default').click(function () {
        $('#batchcates').hide();
    })


    //确认
    $('.modal-footer .btn.btn-primary').click(function () {
        var selected_checkboxs = $('.table-responsive tbody tr td:first-child [type="checkbox"]:checked');
        var goodsids = selected_checkboxs.map(function () {
            return $(this).val()
        }).get();

        var cates=$('#cates').val();
        var iscover=$('input[name="iscover"]:checked').val();
        $.post(biz.url('goods/ajax_batchcates'),{'goodsids':goodsids,'cates': cates,'iscover':iscover}, function (ret) {
            if (ret.status == 1) {
                $('#batchcates').hide();
                tip.msgbox.suc('修改成功');
                window.location.reload();
                return
            } else {
                tip.msgbox.err('修改失败');
            }
        }, 'json');
    })

    $(document).on("click", '[data-toggle="ajaxEdit2"]',
        function (e) {
            var _this = $(this)
            $(this).addClass('hidden')
            var obj = $(this).parent().find('a'),
                url = obj.data('href') || obj.attr('href'),
                data = obj.data('set') || {},
                html = $.trim(obj.text()),
                required = obj.data('required') || true,
                edit = obj.data('edit') || 'input';
            var oldval = $.trim($(this).text());
            e.preventDefault();

            submit = function () {
                e.preventDefault();
                var val = $.trim(input.val());
                if (required) {
                    if (val == '') {
                        tip.msgbox.err(tip.lang.empty);
                        return;
                    }
                }
                if (val == html) {
                    input.remove(), obj.html(val).show();
                    //obj.closest('tr').find('.icow').css({visibility:'visible'})
                    return;
                }
                if (url) {
                    $.post(url, {
                        value: val
                    }, function (ret) {

                        ret = eval("(" + ret + ")");
                        if (ret.status == 1) {
                            obj.html(val).show();

                        } else {
                            tip.msgbox.err(ret.result.message, ret.result.url);
                        }
                        input.remove();
                    }).fail(function () {
                        input.remove(), tip.msgbox.err(tip.lang.exception);
                    });
                } else {
                    input.remove();
                    obj.html(val).show();
                }
                obj.trigger('valueChange', [val, oldval]);
            },
                obj.hide().html('<i class="fa fa-spinner fa-spin"></i>');
            var input = $('<input type="text" class="form-control input-sm" style="width: 80%;display: inline;" />');
            if (edit == 'textarea') {
                input = $('<textarea type="text" class="form-control" style="resize:none;" rows=3 width="100%" ></textarea>');
            }
            obj.after(input);

            input.val(html).select().blur(function () {
                submit(input);
                _this.removeClass('hidden')

            }).keypress(function (e) {
                if (e.which == 13) {
                    submit(input);
                    _this.removeClass('hidden')
                }
            });

        })
</script>
