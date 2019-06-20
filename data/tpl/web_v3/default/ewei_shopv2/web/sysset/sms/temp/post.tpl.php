<?php defined('IN_IA') or exit('Access Denied');?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .form-horizontal .form-group{margin-right: -50px;}
    .col-sm-9{padding-right: 0;}
	.tm .btn { margin-bottom:5px;}
</style>

<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($item['id'])) { ?><?php if(cv('sysset.sms.temp.edit')) { ?>编辑<?php  } else { ?>查看<?php  } ?><?php  } else { ?>添加<?php  } ?>短信模板 <small><?php  if(!empty($item['id'])) { ?>修改【<?php  echo $item['name'];?>】<?php  } ?></small></span>
</div>

<div class="page-content">
    <div class="row">
        <div class="col-sm-9">
            <div class="">
                <div class="summary_box">
                    <div class="summary_title">
                        <span class="title_inner">短信模板说明</span>
                    </div>
                    <div class="summary_lg">
                        <p>模板名称：自定义填写，便于后台搜索查询选择。</p>
                        <p>模板ID：聚合数据、阿里大于需在服务商申请短信模板并审核，模板ID处填写服务商申请的模板ID。</p>
                        <p>短信签名: 阿里大于需在服务商申请短信签名并审核，短信签名处填写服务商申请的短信签名，亿美软通则可自定义填写。</p>
                        <p>数据值：聚合数据、阿里大于需在数据值中填写服务商模板变量对应的商城的变量(可在右侧选择商城变量)。</p>
                        <p>短信内容：亿美软通可直接自定义填写短信内容(可在右侧选择商城变量)。</p>
                        <p>状态：商城短信模板状态，关闭后将不能选择此模板，关闭后仍可在模板列表发送测试短信。</p>
                        <p class="text-danger">注意：阿里大于同一手机号60秒内只能发送一次，请根据需求选择适当接口。</p>
                    </div>
                </div>
            </div>
            <form <?php if( ce('sysset.sms.temp' ,$item) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
            <input type="hidden" name="template" value="<?php  if(!empty($item)) { ?><?php  echo $item['template'];?><?php  } else { ?>1<?php  } ?>" />
            <div class="form-group">
                <label class="col-lg control-label <?php if(cv('sysset.sms.temp.edit')) { ?>must<?php  } ?>" >模板名称</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <input type="text" name="name" class="form-control" value="<?php  echo $item['name'];?>" placeholder="模版名称，例：订单创建成功通知（自定义）" data-rule-required='true' />
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $item['name'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group">
                <label class="col-lg control-label <?php if(cv('sysset.sms.temp.edit')) { ?>must<?php  } ?>">服务商</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <?php  if(!empty($smsset['aliyun_new']) || (!empty($item) && $item['type']=='aliyun_new')) { ?>
                    <label class="radio-inline"><input type="radio" class="sms-type" data-template="1" name="type" value="aliyun_new" <?php  if($item['type']=='aliyun_new' || empty($item)) { ?> checked<?php  } ?> <?php  if(!empty($item['type'])) { ?>disabled<?php  } ?>> 阿里云短信(新版)</label>
                    <?php  } ?>
                    <?php  if(!empty($smsset['juhe']) || (!empty($item) && $item['type']=='juhe')) { ?><label class="radio-inline"><input type="radio" class="sms-type" data-template="1" name="type" value="juhe" <?php  if($item['type']=='juhe') { ?>checked<?php  } ?> <?php  if(!empty($item['type'])) { ?>disabled<?php  } ?>> 聚合数据</label><?php  } ?>
                    <?php  if(!empty($smsset['emay']) || (!empty($item) && $item['type']=='emay')) { ?><label class="radio-inline"><input type="radio" class="sms-type" data-template="0" name="type" value="emay" <?php  if($item['type']=='emay') { ?> checked<?php  } ?> <?php  if(!empty($item['type'])) { ?>disabled<?php  } ?>> 亿美软通</label><?php  } ?>
                    <?php  if(!empty($smsset['dayu']) || (!empty($item) && $item['type']=='dayu')) { ?>
                    <label class="radio-inline"><input type="radio" class="sms-type" data-template="1" name="type" value="dayu" <?php  if($item['type']=='dayu') { ?> checked<?php  } ?> <?php  if(!empty($item['type'])) { ?>disabled<?php  } ?>> 阿里大于(老用户)</label>
                    <?php  } ?>
                    <?php  if(!empty($smsset['aliyun']) || (!empty($item) && $item['type']=='aliyun')) { ?>
                    <label class="radio-inline"><input type="radio" class="sms-type" data-template="1" name="type" value="aliyun" <?php  if($item['type']=='aliyun') { ?> checked<?php  } ?> <?php  if(!empty($item['type'])) { ?>disabled<?php  } ?>> 阿里云短信(旧版)</label>
                    <?php  } ?>
                    <div class="help-block">注意：选择短信服务商请先至 <a href="<?php  echo webUrl('sysset/sms/set')?>" target="_blank">短信接口设置</a> 页面设置好短信服务商的接口信息。(<span class="text-danger">保存后不可修改</span> )</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  if($item['type']=='juhe') { ?>聚合数据<?php  } else if($item['type']=='dayu') { ?>阿里大于<?php  } else if($item['type']=='emay') { ?>亿美软通<?php  } else if($item['type']=='aliyun') { ?>阿里云短信(旧版)<?php  } else if($item['type']=='aliyun_new') { ?>阿里云短信(新版)<?php  } ?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group sms-template-1" style="<?php  if(!empty($item['template']) || empty($item)) { ?>display:block;<?php  } else { ?>display:none;<?php  } ?>">
                <label class="col-lg control-label <?php if(cv('sysset.sms.temp.edit')) { ?>must<?php  } ?>" >模板ID</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <input type="text" name="smstplid" class="form-control" value="<?php  echo $item['smstplid'];?>" placeholder="短信模板ID，例：1234（短信服务商提供的模板ID）" data-rule-required='true' />
                    <div class="help-block">服务商提供的模板ID</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $item['smstplid'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group sms-template-sign" style="<?php  if($item['type']=='dayu' || $item['type']=='aliyun' || $item['type']=='aliyun_new' || $item['type']=='emay' || empty($item)) { ?>display:block;<?php  } else { ?>display:none;<?php  } ?>">
                <label class="col-lg control-label <?php if(cv('sysset.sms.temp.edit')) { ?>must<?php  } ?>" >短信签名</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <input type="text" name="smssign" class="form-control" value="<?php  echo $item['smssign'];?>" placeholder="" data-rule-required='true' />
                    <div class="help-block">请填写短信签名(如果服务商是大于请填写审核成功的签名)</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $item['smssign'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group sms-template-0" style="<?php  if(empty($item['template']) && !empty($item)) { ?>display:block;<?php  } else { ?>display:none;<?php  } ?>">
                <label class="col-lg control-label <?php if(cv('sysset.sms.temp.edit')) { ?>must<?php  } ?>" >短信内容</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <textarea class="form-control" name="content" placeholder="请填写短信内容" rows="4" style="resize: none" data-rule-required="true"><?php  echo $item['content'];?></textarea>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  echo $item['content'];?></div>
                    <?php  } ?>
                </div>
            </div>

            <div class="form-group splitter sms-template-1"></div>

            <div id="datas" class="sms-template-1" style="<?php  if(!empty($item['template']) || empty($item)) { ?>display:block;<?php  } else { ?>display:none;<?php  } ?>">
                <?php  if(empty($item['data'])) { ?>
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sysset/sms/temp/tpl', TEMPLATE_INCLUDEPATH)) : (include template('sysset/sms/temp/tpl', TEMPLATE_INCLUDEPATH));?>
                <?php  } else { ?>
                <?php  if(is_array($item['data'])) { foreach($item['data'] as $data) { ?>
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('sysset/sms/temp/tpl', TEMPLATE_INCLUDEPATH)) : (include template('sysset/sms/temp/tpl', TEMPLATE_INCLUDEPATH));?>
                <?php  } } ?>
                <?php  } ?>
            </div>
            <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
            <div class="form-group sms-template-1" style="<?php  if(!empty($item['template']) || empty($item)) { ?>display:block;<?php  } else { ?>display:none;<?php  } ?>">
                <label class="col-lg control-label"></label>
                <div class="col-sm-9 col-xs-12">
                    <a class="btn btn-default btn-add-type" href="javascript:;" onclick="addType();"><i class="fa fa-plus" title=""></i> 增加一条数据值</a>
                </div>
            </div>
            <?php  } ?>


            <div class="form-group">
                <label class="col-lg control-label <?php if(cv('sysset.sms.temp.edit')) { ?>must<?php  } ?>">状态</label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <label class="radio-inline"><input type="radio" name="status" value="1" <?php  if(!empty($item['status'])) { ?>checked<?php  } ?>> 启用</label>
                    <label class="radio-inline"><input type="radio" name="status" value="0" <?php  if(empty($item['status'])) { ?>checked<?php  } ?>> 禁用</label>
                    <div class="help-block">关闭后将不能调用</div>
                    <?php  } else { ?>
                    <div class='form-control-static'><?php  if(empty($item['status'])) { ?>禁用<?php  } else { ?>启用<?php  } ?></div>
                    <?php  } ?>
                </div>
            </div>


            <div class="form-group"></div>
            <div class="form-group">
                <label class="col-lg control-label" ></label>
                <div class="col-sm-9 col-xs-12">
                    <?php if( ce('sysset.sms.temp' ,$item) ) { ?>
                    <input type="submit"  value="提交" class="btn btn-primary"  />
                    <?php  } ?>
                    <?php if(cv('sysset.sms.temp.main')) { ?>
                    <input type="button" name="back" onclick='history.back()' <?php if(cv('sysset.sms.temp.add|sysset.sms.temp.edit')) { ?>style='margin-left:10px;'<?php  } ?> value="返回列表" class="btn btn-default" />
                    <?php  } ?>
                </div>
            </div>

            </form>

        </div>
        <div class="col-sm-3">
            <div class="panel panel-default" style="width:200px;margin-left:20px;">
                <div class="panel-heading">
                    <select class="form-control" onclick="$('.tm').hide();$('.tm-' + $(this).val()).show()">
                        <option value="">选择模板变量类型</option>
                        <option value="order">订单类</option>
                        <option value="upgrade">升级类</option>
                        <option value="rw">充值提现类</option>
                        <?php  if(p('commission')) { ?>
                        <option value="commission">分销类</option>
                        <?php  } ?>
                        <?php  if(p('globonus')) { ?>
                        <option value="globonus">股东类</option>
                        <?php  } ?>
                        <?php  if(p('merch')) { ?>
                        <option value="merch">多商户类</option>
                        <?php  } ?>
                        <option value="login">登录/注册类</option>
                    </select>
                </div>
                <div class="panel-body tm tm-upgrade" style="display:none">
                    <a href='JavaScript:' class="btn btn-default  btn-sm ">商城名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">粉丝昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧等级</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新等级</a>
                </div>
                <div class="panel-heading tm tm-rw" style="display:none">充值</div>

                <div class="panel-body tm tm-rw" style="display:none">
                    <a href='JavaScript:' class="btn btn-default  btn-sm">支付方式</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">充值金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">充值时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">赠送金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">实际到账</a>
                </div>

                <div class="panel-heading tm tm-rw" style="display:none">充值退款</div>
                <div class="panel-body tm tm-rw" style="display:none">
                    <a href='JavaScript:' class="btn btn-default  btn-sm">支付方式</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">充值金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">充值时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">赠送金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">实际到账</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">退款金额</a>
                </div>

                <div class="panel-heading tm tm-rw" style="display:none">提现</div>
                <div class="panel-body tm tm-rw" style="display:none">
                    <a href='JavaScript:' class="btn btn-default  btn-sm">提现金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">提现时间</a>
                </div>
                <div class="panel-heading tm tm-order" style="display:none">
                    订单信息
                </div>
                <div class="panel-body tm tm-order" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">商城名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">粉丝昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">运费</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品详情</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">单品详情</a>(单品商家下单通知变量)
                    <a href='JavaScript:' class="btn btn-default btn-sm">快递公司</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">快递单号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">购买者姓名</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">购买者电话</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收货地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">下单时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">支付时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">发货时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">收货时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店联系人</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">门店营业时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">虚拟物品自动发货内容</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">虚拟卡密自动发货内容</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">自提码</a>

                </div>
                <div class="panel-heading tm tm-order" style="display:none">
                    售后相关
                </div>
                <div class="panel-body tm tm-order" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">售后类型</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">申请金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">退款金额</a>

                    <a href='JavaScript:' class="btn btn-default btn-sm">退货地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">换货快递公司</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">换货快递单号</a>

                </div>

                <div class="panel-heading tm tm-order" style="display:none">
                    订单状态更新
                </div>
                <div class="panel-body tm tm-order" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm"></a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">粉丝昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单编号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">原收货地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新收货地址</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单原价格</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单新价格</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">修改时间</a>

                </div>
                <div class="panel-heading tm tm-commission" style="display:none">成为下级或分销商</div>
                <div class="panel-body tm tm-commission" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                </div>
                <div class="panel-heading tm tm-commission" style="display:none">新增下线通知</div>
                <div class="panel-body tm tm-commission" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">下线层级</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">下级昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                </div>
                <div class="panel-heading tm tm-commission" style="display:none">下级付款类</div>
                <div class="panel-body tm tm-commission" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">下级昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单编号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">订单金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商品详情</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">佣金金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">下线层级</a>
                </div>
                <div class="panel-heading tm tm-commission" style="display:none">提现申请和佣金打款类</div>
                <div class="panel-body tm tm-commission" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">金额</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">提现方式</a>
                </div>
                <div class="panel-heading tm tm-commission" style="display:none">分销商等级升级通知</div>
                <div class="panel-body tm tm-commission" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧等级</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧一级分销比例</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧二级分销比例</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧三级分销比例</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新等级</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新一级分销比例</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新二级分销比例</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新三级分销比例</a>
                </div>



                <div class="panel-heading tm tm-globonus" style="display:none">成为股东</div>
                <div class="panel-body tm tm-globonus" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                </div>

                <div class="panel-heading tm tm-globonus" style="display:none">股东等级升级通知</div>
                <div class="panel-body tm tm-globonus" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧等级</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">旧分红例</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新等级</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">新分红比例</a>
                </div>
                <div class="panel-heading tm tm-globonus" style="display:none">分红发放通知</div>
                <div class="panel-body tm tm-globonus" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">昵称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">时间</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">打款方式</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">金额</a>
                </div>

                <div class="panel-heading tm tm-merch" style="display:none">入驻申请</div>
                <div class="panel-body tm tm-merch" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">商户名称</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">主营项目</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">联系人</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">手机号</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">申请时间</a>
                </div>
                <div class="panel-heading tm tm-merch" style="display:none">入驻申请(用户)</div>
                <div class="panel-body tm tm-merch" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">驳回原因</a>
                </div>

                <div class="panel-heading tm tm-login" style="display:none">登录/注册</div>
                <div class="panel-body tm tm-login" style="display:none">
                    <a href='JavaScript:' class="btn btn-default btn-sm">验证码</a>
                    <a href='JavaScript:' class="btn btn-default btn-sm">商城名称</a>
                </div>

                <div class="panel-footer">
                    点击变量后会自动插入选择的文本框的焦点位置，在发送给粉丝时系统会自动替换对应变量值
                    <div class="text text-danger">
                        注意：以上模板消息变量只适用于系统类通知，会员群发工具不适用
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

 
<script language='javascript'>

    $(function () {
        $(".sms-type").unbind('click').click(function () {
            var temp = $(this).data('template');
            var val = $(this).val();
            $("input[name='template']").val(temp);
            if(temp){
                $(".sms-template-0").hide();
                $(".sms-template-1").show();
            }else{
                $(".sms-template-1").hide();
                $(".sms-template-0").show();
            }
            if(val=='dayu' || val=='aliyun' || val=='aliyun_new' || val=='emay'){
                $(".sms-template-sign").show();
            }else{
                $(".sms-template-sign").hide();
            }
        });
        $(document).on('click', '.data-item-delete', function () {
            var len = $(".data-item").length;
            if(len==1){
                tip.msgbox.err('必须留一条!');
                return;
            }
            $(this).closest('.data-item').remove();
        });
    });


    var kw = 1;
    function addType() {
        $(".btn-add-type").button("loading");
        $.ajax({
            url: "<?php  echo webUrl('sysset/sms/temp/tpl')?>&kw="+kw,
            cache: false
        }).done(function (html) {
            $(".btn-add-type").button("reset");
            $("#datas").append(html);
        });
        kw++;
    }

        $('form').submit(function(){
            var smstype = $("input[name='type']:checked").val();
            if(!smstype){
                tip.msgbox.err('请选择短信服务商!');
                $('form').attr('stop',1);
                return false;
            }
            var type = $("input[name='type']:checked").data('template');
            if(type){
                if($('.data-item').length<=0){
                    tip.msgbox.err('请添加一条键!');
                    $('form').attr('stop',1);
                    return false;
                }
                var checkkw = true;
                $("#datas input").each(function(){
                    if ( $.trim( $(this).val() ) ==''){
                        checkkw = false;
                        tip.msgbox.err('变量不能为空!');
                        $(this).focus();
                        $('form').attr('stop',1);
                        return false;
                    }
                });
                if( !checkkw){
                    return false;
                }
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
    })
 
    </script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
