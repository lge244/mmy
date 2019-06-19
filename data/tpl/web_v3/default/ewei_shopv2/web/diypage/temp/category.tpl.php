<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">当前位置：<span class="text-primary">模板分类管理</span></div>

<div class="page-content">

    <form action="<?php echo !empty($_W['merchid'])?'./merchant.php':'./index.php'?>" <?php if(cv('diypage.page.sys.delete|diypage.page.diy.delete|diypage.page.mod.delete')) { ?>method="get"<?php  } ?>>
    <input type="hidden" name="c" value="site" />
    <input type="hidden" name="a" value="entry" />
    <input type="hidden" name="m" value="ewei_shopv2" />
    <input type="hidden" name="do" value="web" />
    <input type="hidden" name="r" value="diypage.temp.category" />

    <div class="page-toolbar">
        <div class="col-sm-4">
            <?php if(cv('diypage.temp.category.add')) { ?>
                <span class="btn btn-primary btn-sm" id="addCate"><i class="fa fa-plus"></i> 新建分类</span>
            <?php  } ?>
        </div>
        <div class="col-sm-6 pull-right">
            <div class="input-group">
                <input type="text" class=" form-control" name="keyword" value="<?php  echo $_GPC['keyword'];?>" placeholder="请输入关键字进行搜索">
                <span class="input-group-btn">
                    <button class="btn btn-primary" type="submit">搜索</button>
                </span>
            </div>
        </div>
    </div>

    <form action="" method="post">
        <?php  if(empty($list)) { ?>
            <div class="panel panel-default">
                <div class="panel-body empty-data">未查询到相关分类!</div>
            </div>
        <?php  } else { ?>
            <table class="table table-hover table-responsive">
                <thead class="navbar-inner">
                <tr>
                    <th style="width:50px;">ID</th>
                    <th>分类名称(点击编辑)</th>
                    <?php if(cv('diypage.temp.category.delete')) { ?>
                        <th style="width: 40px">操作</th>
                    <?php  } ?>
                </tr>
                </thead>
                <tbody>
                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <tr>
                        <td><?php  echo $item['id'];?></td>
                        <td>
                            <?php if(cv('diypage.temp.category.edit')) { ?>
                                <a href='javascript:;' data-toggle='ajaxEdit' data-href="<?php  echo webUrl('diypage/temp/category/edit',array('id'=>$item['id']))?>">
                                    <?php  echo $item['name'];?>
                                </a>
                            <?php  } else { ?>
                                <?php  echo $item['name'];?>
                            <?php  } ?>
                        </td>
                        <?php if(cv('diypage.temp.category.delete')) { ?>
                            <td>
                                <a class="btn btn-op btn-operation" data-toggle="ajaxRemove" href="<?php  echo webUrl('diypage/temp/category/delete', array('id'=>$item['id']))?>" data-confirm="删除后该分类下模版将转入未分类，确定要删除该分类吗？">
                                    <span data-toggle="tooltip" data-placement="top" data-original-title="删除"><i class="icow icow-shanchu1"></i></span>
                                </a>
                            </td>
                        <?php  } ?>
                    </tr>
                <?php  } } ?>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right">
                        <?php  echo $pager;?>
                    </td>
                </tr>
                </tfoot>
            </table>
        <?php  } ?>
    </form>
</div>





<?php if(cv('diypage.temp.category.add')) { ?>
    <div class="modal fade" id="addCateModal" aria-hidden="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button data-dismiss="modal" class="close" type="button">×</button>
                    <h4 class="modal-title">新建分类</h4>
                </div>
                <div class="modal-body form-horizontal">
                    <div class="form-group">
                        <div class="col-sm-2 control-label must">分类名称</div>
                        <div class="col-sm-10">
                            <input class="form-control input-sm" placeholder="请输入分类名称" id="saveTempName" value="未命名分类" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <div class="btn btn-primary" id="saveCate">保存</div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        $("#addCate").unbind('click').click(function () {
            $("#addCateModal").modal();
            $("#saveCate").unbind('click').click(function () {
                var status = $(this).data('status');
                if(status) {
                    tip.msgbox.err("正在保存，请稍候。");
                    return;
                }
                var name = $.trim($("#saveTempName").val());
                if(!name) {
                    tip.msgbox.err("请填写分类名称！");
                    $("#saveTempName").focus();
                    return;
                }
                $(this).data('status',1).text('保存中')
                var posturl = biz.url("diypage/temp/category/add", null, <?php  if($_W['plugin']='merch'&&!empty($_W['merchid'])) { ?>1<?php  } else { ?>0<?php  } ?>)
                $.post(posturl, {
                    name: name
                }, function (ret) {
                    if(ret.status==0){
                        tip.msgbox.err(ret.result.message);
                    }else{
                        tip.msgbox.suc("保存成功！");
                    }
                    $("#addCateModal .close").trigger('click');
                    setTimeout(function () {
                        location.reload();
                    }, 500);
                }, 'json');
            });
        });
    </script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--913702023503242914-->