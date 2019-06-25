<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .form-horizontal .form-group{margin-right: -50px;}
    .col-sm-9{padding-right: 0;}
	.tm .btn { margin-bottom:5px;}
    .table>tbody>tr>td, .table>tbody>tr>th, .table>tfoot>tr>td, .table>tfoot>tr>th, .table>thead>tr>td, .table>thead>tr>th {
        padding: 0;
        margin: 0;
        border: 0;
        text-overflow: clip;
    }
</style>

<div class="page-header">
	

    当前位置：<span class="text-primary">	<?php  if(!empty($item['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>消息模板 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['title'];?>】<?php  } ?></small></span>

</div>

<div class="page-content">
    <div class="page-sub-toolbar">
        <span class=''>
            <?php if(cv('printer.add')) { ?>
                                <a class="btn btn-primary btn-sm" href="<?php  echo webUrl('sysset/printer/add')?>">添加消息模板</a>
            <?php  } ?>
        </span>
    </div>
    <div class="row">
        <div class="col-sm-9">

            <form <?php if( ce('sysset.printer' ,$list) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
            <div class="form-group">
                <label class="col-lg control-label must" >模板名称</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.printer' ,$list) ) { ?>
                    <input type="text" name="title" class="form-control" value="<?php  echo $list['title'];?>" placeholder="小票模版名称，例：订单打印小票" data-rule-required='true' />
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $list['title'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label" >打印头部</label>

                <?php if( ce('sysset.printer' ,$list) ) { ?>
                <div class="col-sm-9 title" style='padding-right:0' >
                    <input type="text" name="print_title" class="form-control" value="<?php  echo $list['print_title'];?>"/>
                    <span class='help-block'>打印头部信息,比如商家名称 建议不超过8个字,会进行加粗处理 </span>
                </div>
                <?php  } else { ?>
                <div class="col-sm-3">
                    <div class='form-control-static'><?php  echo $list['print_title'];?></div>
                </div>
                <?php  } ?>

            </div>

            <div class="form-group">
                <label class="col-lg control-label" >打印列格式</label>
                <?php if( ce('sysset.printer' ,$list) ) { ?>
                <div class="col-sm-9 title" style='padding-right:0' >
                    <input type="text" name="print_style" class="form-control" value="<?php  echo $list['print_style'];?>"/>
                    <span class='help-block'>例如: <span class="text-danger">名称:16|单价:6|数量:5|金额:5</span>  解释: 名字 占据16位,单价占据6位,数量占据5位,金额占据5位;总共每行是32个字符,每个中文或中文标点占用2字符;请严格按照格式来!</span>
                </div>
                <?php  } else { ?>
                <div class="col-sm-3">
                    <div class='form-control-static'><?php  echo $list['print_style'];?></div>
                </div>
                <?php  } ?>
            </div>

            <?php  if(is_array($keys)) { foreach($keys as $key2 => $list2) { ?>
            <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sysset/printer/tpl', TEMPLATE_INCLUDEPATH)) : (include template('sysset/printer/tpl', TEMPLATE_INCLUDEPATH));?>
            <?php  } } ?>
            <?php if( ce('sysset.printer' ,$list) ) { ?>
            <div id="type-items"></div>
            <div class="form-group">
                <label class="col-lg control-label" ></label>
                <div class="col-sm-9 col-xs-12">
                    <a class="btn btn-default btn-add-type" href="javascript:;" onclick="addType();"><i class="fa fa-plus" title=""></i> 增加一条键</a>
                        <span class='help-block'>

                        </span>
                </div>
            </div>
            <?php  } ?>
            <div class="form-group">
                <label class="col-lg control-label" >打印条形码</label>
                <?php if( ce('sysset.printer' ,$list) ) { ?>
                <div class="col-sm-9 title" style='padding-right:0' >
                    <input type="number" name="code" class="form-control" value="<?php  echo $list['code'];?>"/>
                    <span class='help-block'>只能是数字,为空则不显示</span>
                </div>
                <?php  } else { ?>
                <div class="col-sm-3">
                    <div class='form-control-static'><?php  echo $list['code'];?></div>
                </div>
                <?php  } ?>
            </div>
            <div class="form-group">
                <label class="col-lg control-label" >打印二维码</label>
                <div class="col-sm-9 ">
                    <?php if( ce('sysset.printer' ,$list) ) { ?>
                    <div class="input-group">
                        <input type="text" name="qrcode" class="form-control" value="<?php  echo $list['qrcode'];?>" placeholder="" id="qrcode"/>
                        <span data-input="#qrcode" data-toggle="selectUrl" data-full="true" class="input-group-btn">
                            <sapn class="btn btn-default">选择链接</sapn>
                        </span>
                    </div>
                    <span class='help-block'>为空则不显示</span>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $list['url'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label">打印商品编码</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.printer')) { ?>
                    <label class="radio-inline"><input type="radio" name="goodssn" value="0" <?php  if(empty($list['goodssn'])) { ?>checked<?php  } ?>> 不打印</label>
                    <label class="radio-inline"><input type="radio" name="goodssn" value="1" <?php  if(!empty($list['goodssn'])) { ?>checked<?php  } ?>> 打印</label>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($list['goodssn'])) { ?>不打印<?php  } else { ?>打印<?php  } ?></div>
                    <?php  } ?>
                </div>
            </div>
            <div class="form-group">
                <label class="col-lg control-label">打印商品条码</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if(cv('sysset.printer')) { ?>
                    <label class="radio-inline"><input type="radio" name="productsn" value="0" <?php  if(empty($list['productsn'])) { ?>checked<?php  } ?>> 不打印</label>
                    <label class="radio-inline"><input type="radio" name="productsn" value="1" <?php  if(!empty($list['productsn'])) { ?>checked<?php  } ?>> 打印</label>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($list['productsn'])) { ?>不打印<?php  } else { ?>打印<?php  } ?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group"></div>
            <div class="form-group">
                <label class="col-lg control-label" ></label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.printer' ,$list) ) { ?>
                    <input type="submit"  value="提交" class="btn btn-primary"  />

                    <?php  } ?>
                    <input type="button" name="back" onclick='history.back()' <?php if(cv('sysset.printer.add|sysset.printer.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                </div>
            </div>

            </form>

        </div>
        <div class="col-sm-3">
            <div class="panel panel-default" style="width:200px;margin-left:20px; padding: 10px" id="printer_preview">
                <h3 class="text-center"></h3>
                <table class="table">
                    <thead></thead>
                    <tbody></tbody>
                </table>
            </div>
            <div class="panel panel-default" style="width:200px;margin-left:20px;">
                <div class="panel-heading">
                    <select class="form-control" onclick="$('.tm').hide();$('.tm-' + $(this).val()).show()">
                        <option value="">选择模板变量类型</option>
                        <?php  if(cv('order')) { ?>
                        <option value="order">订单打印</option>
                        <?php  } ?>
                        <?php  if(cv('cashier')) { ?>
                        <option value="cashier">收银台参数</option>
                        <?php  } ?>
                    </select>
                </div>
                <div class="panel-heading tm tm-order" style="display:none">商品支持变量</div>
                <div class="panel-body tm tm-order" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品价格</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品数量</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">单商品合计</a>
                </div>
                <div class="panel-heading tm tm-order" style="display:none">其他变量</div>
                <div class="panel-body tm tm-order" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单编号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">优惠金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品价格详情</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收货人</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收货地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收货电话</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">备注</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">运费</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单时间标题</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单状态</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">付款地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">付款类型</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单详情地址</a>
                </div>

                <div class="panel-heading tm tm-order" style="display:none">门店使用变量</div>
                <div class="panel-body tm tm-order" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店联系人</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店联系方式</a>
                </div>

                <div class="panel-heading tm tm-cashier" style="display:none">收银台商品支持变量</div>
                <div class="panel-body tm tm-cashier" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品价格</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品数量</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">单商品合计</a>
                </div>

                <div class="panel-heading tm tm-cashier" style="display:none">收银台打印变量</div>
                <div class="panel-body tm tm-cashier" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">收银台名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收银金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收银时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">支付类型</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单编号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">随机减金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">满立减金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">余额抵扣金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">操作员</a>
                </div>

                <div class="panel-footer">
                    点击变量后会自动插入选择的文本框的焦点位置，在发送给粉丝时系统会自动替换对应变量值
                    <div class="text text-danger">
                        注意：以上模板消息变量只适用于小票打印
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
<script language='javascript'>
    var kw = <?php  echo $kw;?>;
    function addType() {
        $(".btn-add-type").button("loading");
        $.ajax({ 
            url: "<?php  echo webUrl('sysset/printer/tpl')?>&kw="+kw,
            cache: false
        }).done(function (html) {
            $(".btn-add-type").button("reset");
            $("#type-items").append(html);
        });
        kw++;
    }
 
        $('form').submit(function(){
      
            if($('.key_item').length<=0){
                tip.msgbox.err('请添加一条键!');
                $('form').attr('stop',1);
                return false;
            }
            var checkkw = true;
            $(":input[name='data[]']").each(function(){
                if ( $.trim( $(this).val() ) ==''){
                    checkkw = false;
                    tip.msgbox.err('请输入键名!');
                    $(this).focus();
                    $('form').attr('stop',1);
                    return false;
                }
            });
            if( !checkkw){
                return false;
            }
            $('form').removeAttr('stop');
            return true;
      });

    $(function () {
        require(['jquery.caret'],function(){
            var jiaodian;
            $(document).on('focus', 'input,textarea',function () {
                jiaodian = this;
            });

            $("a[href='JavaScript:']").click(function () {
                if (jiaodian) {
                    $(jiaodian).insertAtCaret("["+this.innerText+"]" );
                }
            })

        });

        $(document).off('change','input').on('change','input',function(){
            var printer_preview = $("#printer_preview");
            var print_title = $(':input[name="print_title"]');
            var print_style = $(':input[name="print_style"]');
            var key = $(':input[name="key[]"]');
            var print_style_array = print_style.val().split('|');
            var thead = '';
            var tbody = '';
            var array_len = 0;
            $.each(print_style_array,function (index,iteam) {
                var val_array = iteam.split(':');
                if (val_array.length > 1){
                    array_len = array_len+parseInt(val_array[1]);
                    var width = parseInt(val_array[1])*5.7;
                    thead += '<th style="width: '+width+'px">'+val_array[0]+'</th>';
                }
            });
            if (array_len>32){
                tip.msgbox.err('设置总共长度超过32字符');
                return false;
            }
            $.each(key,function (index,iteam) {
                var has = iteam.value.indexOf('|');
                if (has != -1){
                    var key_array = iteam.value.split('|');
                    tbody += '<tr>';
                    $.each(key_array,function (k,v) {
                        v = v.replace('[商品名称]','测试商品');
                        v = v.replace('[商品价格]','50');
                        v = v.replace('[商品数量]','1');
                        v = v.replace('[单商品合计]','50');
                        tbody += '<td>'+v+'</td>';
                    });
                    tbody += '</tr>';
                }else{
                    tbody += '<tr><td colspan="'+print_style_array.length+'">'+iteam.value+'</td></tr>';
                }
            });
            printer_preview.find("table thead").html(thead);
            printer_preview.find("h3").html(print_title.val());
            printer_preview.find("table tbody").html(tbody);
        });
    })
 
    </script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--OTEzNzAyMDIzNTAzMjQyOTE0-->