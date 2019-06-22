<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .multi-item {margin-bottom: 18px;}
</style>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($item)) { ?>编辑<?php  } else { ?>新建<?php  } ?>商品组 <small><?php  if(!empty($item)) { ?>(名称: <?php  echo $item['name'];?>)<?php  } ?></small></span>
</div>

<div class="page-content">
    <form <?php if( ce('goods.group' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-validate form-horizontal ">

        <div class="form-group">
            <label class="col-lg control-label">商品组名称</label>
            <div class="col-sm-9">
                <?php if( ce('goods.group' ,$item) ) { ?>
                    <input type="text" class="form-control valid" name="name" value="<?php  echo $item['name'];?>" data-rule-required="true" placeholder="请输入商品组名称" />
                <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $item['name'];?></div>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label">商品组状态</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('goods.group' ,$item) ) { ?>
                    <label class="radio-inline">
                        <input type="radio" name="enabled" value="1" <?php  if($item['enabled']==1) { ?>checked="checked"<?php  } ?>> 启用
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="enabled" value="0" <?php  if($item['enabled']==0 || empty($item)) { ?>checked="checked"<?php  } ?>> 禁用
                    </label>
                <?php  } else { ?>
                    <div class='form-control-static'><?php  if($item['enabled']==1) { ?>启用<?php  } else { ?>禁用<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label">组内商品</label>
            <div class="col-sm-9">
                <div class="form-group" style="height: auto; display: block;">
                    <div class="col-sm-12 col-xs-12">
                        <?php if( ce('goods.group' ,$item) ) { ?>
                        <div class="input-group">
                            <input type="text" id="goodsid_text" name="goodsid_text" value="" class="form-control text" readonly="">
                            <div class="input-group-btn">
                                <button class="btn btn-primary select_goods" type="button">选择商品</button>
                            </div>
                        </div>
                        <div class="input-group multi-img-details container ui-sortable goods_show">
                            <?php  if(!empty($goods)) { ?>
                            <?php  if(is_array($goods)) { foreach($goods as $g) { ?>
                            <div class="multi-item" data-id="<?php  echo $g['id'];?>" data-name="goodsid" id="<?php  echo $g['id'];?>">
                                <img class="img-responsive img-thumbnail" src="<?php  echo tomedia($g['thumb'])?>" onerror="this.src='../addons/ewei_shopv2/static/images/nopic.png'" style="width:100px;height:100px;">
                                <div class="img-nickname"><?php  echo $g['title'];?></div>
                                <input type="hidden" value="<?php  echo $g['id'];?>" name="goodsids[]">
                                <em onclick="remove(<?php  echo $g['id'];?>)" class="close">×</em>
                                <div style="clear:both;"></div>
                            </div>
                            <?php  } } ?>
                            <?php  } ?>
                        </div>

                        <script>
                            $(function(){
                                var title = '';
                                $('.img-nickname').each(function(){
                                    title += $(this).html()+';';
                                });
                                $('#goodsid_text').val(title);
                            })
                            myrequire(['web/goods_selector'],function (Gselector) {
                                $('.select_goods').click(function () {
                                    var ids = select_goods_ids();
                                    Gselector.open('goods_show','',0,true,'',ids);
                                });
                            })
                            function goods_show(data) {
                                if(data.act == 1){
                                    var html = '<div class="multi-item" data-id="'+data.id+'" data-name="goodsid" id="'+data.id+'">'
                                        +'<img class="img-responsive img-thumbnail" src="'+data.thumb+'" onerror="this.src=\'../addons/ewei_shopv2/static/images/nopic.png\'" style="width:100px;height:100px;">'
                                        +'<div class="img-nickname">'+data.title+'</div>'
                                        +'<input type="hidden" value="'+data.id+'" name="goodsids[]">'
                                        +'<em onclick="removeHtml('+data.id+')" class="close">×</em>'
                                        +'</div>';

                                    $('.goods_show').append(html);
                                    var title = '';
                                    $('.img-nickname').each(function(){
                                        title += $(this).html()+';';
                                    });
                                    $('#goodsid_text').val(title);
                                }else if(data.act == 0){
                                    remove(data.id);
                                }
                            }
                            function remove(id){
                                $("[id='"+id+"']").remove();
                                var title = '';
                                $('.img-nickname').each(function(){
                                    title += $(this).html()+';';
                                });
                                $('#goodsid_text').val(title);
                            }
                            function select_goods_ids(){
                                var goodsids = [];
                                $(".multi-item").each(function(){
                                    goodsids.push($(this).attr('data-id'));
                                });
                                return goodsids;
                            }
                        </script>
                        <?php  } else { ?>
                            <div class="input-group multi-img-details container ui-sortable">
                                <?php  if(is_array($goods)) { foreach($goods as $item) { ?>
                                <div data-name="goodsid" data-id="426" class="multi-item">
                                    <img src="<?php  echo tomedia($item['thumb'])?>" class="img-responsive img-thumbnail">
                                    <div class="img-nickname"><?php  echo $item['title'];?></div>
                                </div>
                                <?php  } } ?>
                            </div>
                        <?php  } ?>
                    </div>
                </div>

            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label"></label>
            <div class="col-sm-9">
                <?php if( ce('goods.group' ,$item) ) { ?>
                <input type="submit" class="btn btn-primary" value="保存">
                <?php  } ?>
                <a class="btn btn-default" href="<?php  echo webUrl('goods/group')?>">返回列表</a>
            </div>
        </div>

    </form>
</div>

<?php if( ce('goods.group' ,$item) ) { ?>
    <script language="javascript">
        require(['jquery.ui'],function(){
            $('.multi-img-details').sortable();
        })
    </script>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>