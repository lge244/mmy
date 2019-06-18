<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>

<div class="page-header">
    当前位置：<span class="text-primary">标签组管理</span>
</div>

<div class="page-content">
   <div class="page-sub-toolbar">
        <span class="">
        <?php if(cv('goods.label.add')) { ?>
        <a href="<?php  echo webUrl('goods/label/add')?>" class="btn btn-primary btn-sm">添加新标签组</a>
        <?php  } ?>
          <a  class="btn btn-default  btn-sm" href="<?php  echo webUrl('goods/label')?>">标签管理</a>
    </span>
   </div>

    <form <?php if( ce('goods' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data" >
    <div class="tab-pane  active" id="tab_center">
        <div class="panel-body">
            <div class="form-group">
                <label class="col-lg control-label" style="text-align: right;">商品详情标签样式选择</label>
                <div class="col-sm-9 col-xs-12">
                    <div class="row">
                        <?php if(cv('goods.label.edit')) { ?>
                        <div class="col-sm-12">
                            <label class="radio-inline">
                                <input type="radio"  name="style" value="0" <?php  if(empty($style['style'])) { ?> checked="checked"<?php  } ?> />样式一
                            </label>
                            <label class="radio-inline">
                                <input type="radio"  name="style" value="1" <?php  if($style['style'] ==1) { ?> checked="checked"<?php  } ?> /> 样式二
                            </label>
                            <label class="radio-inline">
                                <input type="radio"  name="style" value="2" <?php  if($style['style'] ==2) { ?> checked="checked"<?php  } ?> />样式三
                            </label>
                            <label class="radio-inline">
                                <input type="radio"  name="style" value="3" <?php  if($style['style'] ==3) { ?> checked="checked"<?php  } ?> /> 样式四
                            </label>
                            <label class="radio-inline">
                                <input type="radio"  name="style" value="4" <?php  if($style['style'] ==4) { ?> checked="checked"<?php  } ?> />样式五
                            </label>
                        </div>
                        <?php  } else { ?>
                            <?php  if(empty($style['style'])) { ?>样式一
                                <?php  } else if($style['style'] ==1) { ?>样式二
                                <?php  } else if($style['style'] ==2) { ?>样式三
                                <?php  } else if($style['style'] ==3) { ?>样式四
                                <?php  } else if($style['style'] ==4) { ?>样式五
                            <?php  } ?>
                        <?php  } ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('groups.label.edit' ,$item) ) { ?>
                    <div class='panel-body'>
                        <input type="submit"  value="提交" class="btn btn-primary" />
                    </div>
                    <?php  } ?>
                </div>
            </div>

        </div>
    </div>
    </form>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+454mI5p2D5omA5pyJ-->