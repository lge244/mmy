<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .input-group{
        width: 100%;
    }
    .ban{
        width: 50%;
        display: table;
        float: left;
    }
</style>
<div class="page-header">
    当前位置：<span class="text-primary"><?php  if(!empty($cityexpress['id'])) { ?>编辑<?php  } else { ?>添加<?php  } ?>同城配送<?php  if(!empty($cityexpress['id'])) { ?>(<?php  echo $cityexpress['express_name'];?>)<?php  } ?></span>
</div>
<div class="page-content">

    <form <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>action="" method="post"<?php  } ?> class="form-horizontal form-validate" enctype="multipart/form-data">
        <input type="hidden" name="id" value="<?php  echo $cityexpress['id'];?>" />
        <div class="form-group">
            <label class="col-lg control-label ">状态</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                <label class='radio-inline'><input type='radio' name='enabled' value='1' <?php  if($cityexpress['enabled']==1) { ?>checked<?php  } ?> /> 启用</label>
                <label class='radio-inline'><input type='radio' name='enabled' value='0' <?php  if($cityexpress['enabled']==0) { ?>checked<?php  } ?> /> 禁用</label>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if(empty($item['enabled'])) { ?>禁用<?php  } else { ?>启用<?php  } ?></div>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label ">购买多件商品时运费</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                <label class='radio-inline'><input type='radio' name='is_sum' value='1' <?php  if($cityexpress['is_sum']==1) { ?>checked<?php  } ?> /> 叠加</label>
                <label class='radio-inline'><input type='radio' name='is_sum' value='0' <?php  if($cityexpress['is_sum']==0) { ?>checked<?php  } ?> /> 不叠加</label>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if(empty($item['is_sum'])) { ?>不叠加<?php  } else { ?>叠加<?php  } ?></div>
                <?php  } ?>
                <div class='help-block'>如果开启了同城配送，并且在同城配送范围内，选择叠加时购买多件商品的同城运费等于每件商品运费的和， 选择不叠加，则使用其中商品运费（包含统一运费）的最大值</div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label ">超出同城配送范围后</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                <label class='radio-inline'><input type='radio' name='is_dispatch' value='1' <?php  if($cityexpress['is_dispatch']==1) { ?>checked<?php  } ?> /> 使用快递方式</label>
                <label class='radio-inline'><input type='radio' name='is_dispatch' value='0' <?php  if($cityexpress['is_dispatch']==0) { ?>checked<?php  } ?> /> 不使用快递方式</label>
                <?php  } else { ?>
                <div class='form-control-static'><?php  if(empty($item['is_dispatch'])) { ?>不使用快递方式<?php  } else { ?>使用快递方式<?php  } ?></div>
                <?php  } ?>
                <div class='help-block'>如果开启了同城配送，选择使用快递方式，则超出范围后自动使用快递方式；选择不使用快递方式，则超出同城配送范围后不配送</div>
            </div>
        </div>

    <div class="form-group dispatch0">
        <label class="col-lg control-label ">物流公司</label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <select name='express_type' id="express_type" class="form-control select2">
                <option  <?php  if($cityexpress['express_type']==0 ) { ?>selected<?php  } ?> value="0"  >商家配送</option>
                <option  <?php  if($cityexpress['express_type']==1 ) { ?>selected<?php  } ?> value="1"  >达达配送</option>
                <option  <?php  if($cityexpress['express_type']==2 ) { ?>selected<?php  } ?> value="2" disabled="disabled"  >蜂鸟配送（敬请期待）</option>
            </select>
            <?php  } else { ?>
            <div class='form-control-static'><?php  if($cityexpress['express_type']==0) { ?>商家配送<?php  } else if($cityexpress['express_type']==1) { ?>达达配送<?php  } else if($cityexpress['express_type']==2) { ?>蜂鸟配送<?php  } ?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="dada"  <?php  if($cityexpress['express_type']==1 ) { ?>style="display: block;"<?php  } else { ?>style="display: none;"<?php  } ?>>
        <div class="form-group">
            <label class="col-lg control-label must">接口信息</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                <div class="input-group">
                    <div class="ban">
                        <span class="input-group-addon">app_key</span>
                        <input type="text" name="config[app_key]" class="form-control valid" value="<?php  echo $cityexpress['app_key'];?>" aria-invalid="false" data-rule-required="true">
                    </div>
                    <div class="ban">
                        <span class="input-group-addon">app_secret</span>
                        <input type="text" name="config[app_secret]" class="form-control valid" value="<?php  echo $cityexpress['app_secret'];?>" aria-invalid="false" data-rule-required="true">
                    </div>
                </div>
                <?php  } else { ?>
                <div class='form-control-static'>app_key：<?php  echo $cityexpress['app_key'];?>  app_secret：<?php  echo $cityexpress['app_secret'];?></div>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group">
            <label class="col-lg control-label "></label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                <div class="input-group">
                    <div class="ban">
                        <span class="input-group-addon">商户ID</span>
                        <input type="text" name="config[source_id]"  class="form-control valid" value="<?php  echo $cityexpress['source_id'];?>" aria-invalid="false" data-rule-required="true">
                    </div>
                     <div class="ban">
                        <span class="input-group-addon">门店编码</span>
                        <input type="text" name="config[shop_no]" class="form-control valid" value="<?php  echo $cityexpress['shop_no'];?>" aria-invalid="false" data-rule-required="true">
                     </div>
                </div>
                <?php  } else { ?>
                <div class='form-control-static'>商户ID：<?php  echo $cityexpress['source_id'];?>  门店编码：<?php  echo $cityexpress['shop_no'];?></div>
                <?php  } ?>
            </div>
        </div>

        <div class="form-group dispatch0">
            <label class="col-lg control-label ">所在城市</label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                <select name='config[city_code]' id="city_code" class="form-control select2">
                    <option <?php  if($cityexpress['city_code']=='021' ) { ?>selected<?php  } ?>  value="021">上海</option>
                    <option <?php  if($cityexpress['city_code']=='010' ) { ?>selected<?php  } ?>  value="010">北京</option>
                    <option <?php  if($cityexpress['city_code']=='0551' ) { ?>selected<?php  } ?>  value="0551">合肥</option>
                    <option <?php  if($cityexpress['city_code']=='025' ) { ?>selected<?php  } ?>  value="025">南京</option>
                    <option <?php  if($cityexpress['city_code']=='0512' ) { ?>selected<?php  } ?>  value="0512">苏州</option>
                    <option <?php  if($cityexpress['city_code']=='027') { ?>selected<?php  } ?>  value="027">武汉</option>
                    <option <?php  if($cityexpress['city_code']=='0510' ) { ?>selected<?php  } ?>  value="0510">无锡</option>
                    <option <?php  if($cityexpress['city_code']=='0519' ) { ?>selected<?php  } ?>  value="0519">常州</option>
                    <option <?php  if($cityexpress['city_code']=='0571' ) { ?>selected<?php  } ?>  value="0571">杭州</option>
                    <option <?php  if($cityexpress['city_code']=='020' ) { ?>selected<?php  } ?>  value="020">广州</option>
                    <option <?php  if($cityexpress['city_code']=='0755' ) { ?>selected<?php  } ?>  value="0755">深圳</option>
                    <option <?php  if($cityexpress['city_code']=='023' ) { ?>selected<?php  } ?>  value="023">重庆</option>
                    <option <?php  if($cityexpress['city_code']=='0731' ) { ?>selected<?php  } ?>  value="0731">长沙</option>
                    <option <?php  if($cityexpress['city_code']=='028' ) { ?>selected<?php  } ?>  value="028">成都</option>
                    <option <?php  if($cityexpress['city_code']=='022' ) { ?>selected<?php  } ?>  value="022">天津</option>
                    <option <?php  if($cityexpress['city_code']=='0592' ) { ?>selected<?php  } ?>  value="0592">厦门</option>
                    <option <?php  if($cityexpress['city_code']=='0591' ) { ?>selected<?php  } ?>  value="0591">福州</option>
                    <option <?php  if($cityexpress['city_code']=='0411' ) { ?>selected<?php  } ?>  value="0411">大连</option>
                    <option <?php  if($cityexpress['city_code']=='0532' ) { ?>selected<?php  } ?>  value="0532">青岛</option>
                    <option <?php  if($cityexpress['city_code']=='0451' ) { ?>selected<?php  } ?>  value="0451">哈尔滨</option>
                    <option <?php  if($cityexpress['city_code']=='0531' ) { ?>selected<?php  } ?>  value="0531">济南</option>
                    <option <?php  if($cityexpress['city_code']=='0371' ) { ?>selected<?php  } ?>  value="0371">郑州</option>
                    <option <?php  if($cityexpress['city_code']=='029' ) { ?>selected<?php  } ?>  value="029">西安</option>
                    <option <?php  if($cityexpress['city_code']=='0574' ) { ?>selected<?php  } ?>  value="0574">宁波</option>
                    <option <?php  if($cityexpress['city_code']=='0577' ) { ?>selected<?php  } ?>  value="0577">温州</option>
                    <option <?php  if($cityexpress['city_code']=='0553' ) { ?>selected<?php  } ?>  value="0553">芜湖</option>
                    <option <?php  if($cityexpress['city_code']=='0513' ) { ?>selected<?php  } ?>  value="0513">南通</option>
                    <option <?php  if($cityexpress['city_code']=='0791' ) { ?>selected<?php  } ?>  value="0791">南昌</option>
                    <option <?php  if($cityexpress['city_code']=='0311' ) { ?>selected<?php  } ?>  value="0311">石家庄</option>
                    <option <?php  if($cityexpress['city_code']=='0536' ) { ?>selected<?php  } ?>  value="0536">潍坊</option>
                    <option <?php  if($cityexpress['city_code']=='0573' ) { ?>selected<?php  } ?>  value="0573">嘉兴</option>
                    <option <?php  if($cityexpress['city_code']=='0579' ) { ?>selected<?php  } ?>  value="0579">金华</option>
                    <option <?php  if($cityexpress['city_code']=='0575' ) { ?>selected<?php  } ?>  value="0575">绍兴</option>
                    <option <?php  if($cityexpress['city_code']=='0535' ) { ?>selected<?php  } ?>  value="0535">烟台</option>
                    <option <?php  if($cityexpress['city_code']=='0514' ) { ?>selected<?php  } ?>  value="0514">扬州</option>
                    <option <?php  if($cityexpress['city_code']=='0512' ) { ?>selected<?php  } ?>  value="0512">昆山</option>
                    <option <?php  if($cityexpress['city_code']=='0757' ) { ?>selected<?php  } ?>  value="0757">佛山</option>
                    <option <?php  if($cityexpress['city_code']=='0769' ) { ?>selected<?php  } ?>  value="0769">东莞</option>
                    <option <?php  if($cityexpress['city_code']=='0555' ) { ?>selected<?php  } ?>  value="0555">马鞍山</option>
                </select>
                <?php  } else { ?>
                <div class='form-control-static'>
                    <?php  if($cityexpress['city_code']=='021' ) { ?>上海<?php  } ?>
                    <?php  if($cityexpress['city_code']=='010' ) { ?>北京<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0551' ) { ?>合肥<?php  } ?>
                    <?php  if($cityexpress['city_code']=='025' ) { ?>南京<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0512' ) { ?>苏州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='027' ) { ?>武汉<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0510' ) { ?>无锡<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0519' ) { ?>常州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0571' ) { ?>杭州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='020' ) { ?>广州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0755' ) { ?>深圳<?php  } ?>
                    <?php  if($cityexpress['city_code']=='023' ) { ?>重庆<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0731' ) { ?>长沙<?php  } ?>
                    <?php  if($cityexpress['city_code']=='028' ) { ?>成都<?php  } ?>
                    <?php  if($cityexpress['city_code']=='022' ) { ?>天津<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0592' ) { ?>厦门<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0591' ) { ?>福州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0411' ) { ?>大连<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0532' ) { ?>青岛<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0451' ) { ?>哈尔滨<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0531' ) { ?>济南<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0371' ) { ?>郑州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='029' ) { ?>西安<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0574' ) { ?>宁波<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0577' ) { ?>温州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0553' ) { ?>芜湖<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0513' ) { ?>南通<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0791' ) { ?>南昌<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0311' ) { ?>石家庄<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0536' ) { ?>潍坊<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0573' ) { ?>嘉兴<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0579' ) { ?>金华<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0575' ) { ?>绍兴<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0535' ) { ?>烟台<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0514' ) { ?>扬州<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0512' ) { ?>昆山<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0757' ) { ?>佛山<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0769' ) { ?>东莞<?php  } ?>
                    <?php  if($cityexpress['city_code']=='0555' ) { ?>马鞍山<?php  } ?>
                </div>
                <?php  } ?>
            </div>
        </div>
    </div>

    <div class="form-group tel">
        <label class="col-lg control-label must">配送电话</label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <div class="input-group">
                <div class="ban">
                    <span class="input-group-addon">联系电话1</span>
                    <input type="text" name="tel1"   class="form-control valid" value="<?php  echo $cityexpress['tel1'];?>" aria-invalid="false" data-rule-required="true">
                </div>
                <div class="ban">
                    <span class="input-group-addon">联系电话2</span>
                    <input type="text" name="tel2"  class="form-control valid" value="<?php  echo $cityexpress['tel2'];?>" aria-invalid="false">
                </div>
            </div>
            <?php  } else { ?>
            <div class='form-control-static'>联系电话1：<?php  echo $cityexpress['tel1'];?>  联系电话2：<?php  echo $cityexpress['tel2'];?></div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label must">计费方式</label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <div class="input-group">
                <div class="ban">
                    <span class="input-group-addon">起步价</span>
                    <input type="text" name="start_fee" class="form-control valid" value="<?php  echo $cityexpress['start_fee'];?>" aria-invalid="false" data-rule-required="true">
                </div>
                 <div class="ban">
                     <span class="input-group-addon">元 包含</span>
                    <input type="text" name="start_km" id="start_km"  class="form-control valid" value="<?php  echo $cityexpress['start_km'];?>" aria-invalid="false" data-rule-required="true">
                    <span class="input-group-addon">公里</span>
                 </div>
            </div>
            <?php  } else { ?>
                <div class='form-control-static'>起步价：<?php  echo $cityexpress['start_fee'];?>元 包含：<?php  echo $cityexpress['start_km'];?>公里</div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label "></label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <div class="input-group">
                <div class="ban">
                    <span class="input-group-addon">超出起步范围</span>
                    <input type="text" name="pre_km" id="pre_km"  class="form-control valid" value="<?php  echo $cityexpress['pre_km'];?>" aria-invalid="false" data-rule-required="true">
                </div>
                <div class="ban">
                    <span class="input-group-addon">公里内 每增加1公里</span>
                    <input type="text" name="pre_km_fee"  class="form-control valid" value="<?php  echo $cityexpress['pre_km_fee'];?>" aria-invalid="false" data-rule-required="true">
                    <span class="input-group-addon">元</span>
                </div>

            </div>
            <?php  } else { ?>
            <div class='form-control-static'>超出起步范围：<?php  echo $cityexpress['pre_km'];?>公里内 每增加1公里：<?php  echo $cityexpress['pre_km_fee'];?>元</div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label "></label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <div class="input-group">
                <div class="ban">
                    <span class="input-group-addon">超出</span>
                    <input type="text" readonly="readonly" name="fixed_km" id="fixed_km"  class="form-control valid" value="<?php  echo $cityexpress['fixed_km'];?>" aria-invalid="false">
                </div>
                <div class="ban">
                    <span class="input-group-addon">公里 固定价格</span>
                    <input type="text" name="fixed_fee"  class="form-control valid" value="<?php  echo $cityexpress['fixed_fee'];?>" aria-invalid="false" data-rule-required="true">
                    <span class="input-group-addon">元</span>
                </div>

            </div>
            <?php  } else { ?>
            <div class='form-control-static'>超出：<?php  echo $cityexpress['fixed_km'];?>公里 固定价格：<?php  echo $cityexpress['fixed_fee'];?>元</div>
            <?php  } ?>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label must">自动收货</label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <div class="input-group">
                <span class="input-group-addon">发货几天后</span>
                <input type="number" name="receive_goods"  class="form-control valid" value="<?php  echo $cityexpress['receive_goods'];?>" aria-invalid="false" data-rule-required="true">
                <span class="input-group-addon">天</span>
            </div>
            <?php  } else { ?>
            <div class='form-control-static'>发货几天后：<?php  echo $cityexpress['receive_goods'];?>天</div>
            <?php  } ?>
            <div class='help-block'>如果设置0或空，则读取系统设置</div>
        </div>
    </div>

    <div class="form-group">
        <label class="col-lg control-label must">高德Web服务接口key</label>
        <div class="col-sm-9 col-xs-12">
            <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
            <div class="input-group">
                <input type="text" name="geo_key"  class="form-control valid" value="<?php  echo $cityexpress['geo_key'];?>" aria-invalid="false" data-rule-required="true">
            </div>
            <?php  } else { ?>
            <div class='form-control-static'><?php  echo $cityexpress['geo_key'];?></div>
            <?php  } ?>
            <div class='help-block'>注册高德地图帐号并访问<a href="http://lbs.amap.com/dev/key/app">高德开放平台</a>申请Web服务接口key</div>
        </div>
    </div>

        <div class="form-group-title">区域设置</div>
        <input type="hidden" name="lng" value="<?php  echo $cityexpress['lng'];?>">
        <input type="hidden" name="lat" value="<?php  echo $cityexpress['lat'];?>">
        <input type="hidden" name="range" value="<?php  echo $cityexpress['range'];?>">
        <input type="hidden" name="zoom" value="<?php  echo $cityexpress['zoom'];?>">
        <div class="form-group"  style="width: 75%;height: 600px;margin: 0 140px;position: relative">
            <link rel="stylesheet" href="https://cache.amap.com/lbs/static/main1119.css"/>
            <script src="https://webapi.amap.com/maps?v=1.4.0&key=1fb308f0707e5ff11db5997d42660396&plugin=AMap.PolyEditor,AMap.CircleEditor"></script>
            <script src="//webapi.amap.com/ui/1.0/main.js?v=1.0.11"></script>
            <script type="text/javascript" src="https://cache.amap.com/lbs/static/addToolbar.js"></script>
            <div id="container" class="map" > </div>
            <div class="button-group" style="bottom: 0px;right: 15px;">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                    <input type="button" class="button" value="开始选取坐标范围" id="start_position" />
                    <input type="button" class="button" value="结束选取坐标范围" id="stop_position" />
                <?php  } ?>
            </div>

            <script>

                var lng=$("input[name='lng']").val();
                var lat=$("input[name='lat']").val();
                var range=$("input[name='range']").val();

                var lnglat='';//设置的坐标
                if(lng !="" && lat !=""){
                    lnglat=[lng,lat];
                }

                if(range==0){
                    range=15;
                }

                var circleisopen=false;//是否已经打开圆形编辑
                //初始化地图参数
                var editor={};
                var  map = new AMap.Map("container", {
                    resizeEnable: true,//是否监控地图容器尺寸变化，默认值为false
                    dragEnable: true,//是否允许拖拽地图
                    keyboardEnable: false,//是否允许键盘平移
                    doubleClickZoom: false,//是否允许双击放大地图
                    scrollWheel:true,//是否允许鼠标滚轮操作地图
                    center:lnglat,
                    zoom: 13 //地图显示的缩放级别
                });

                var marker = new AMap.Marker({
                    map: map,
                    position: lnglat
                });

                //在地图上绘制覆盖物
                editor._circle=(function(){
                    var circle = new AMap.Circle({
                        center: lnglat,// 圆心位置
                        radius: range, //半径
                        strokeColor: "#4e73f1", //线颜色
                        strokeOpacity: 1, //线透明度
                        strokeWeight: 3, //线粗细度
                        fillColor: "#4e73f1", //填充颜色
                        fillOpacity: 0.35,//填充透明度
                    });
                    circle.setMap(map);
                    return circle;
                })();

                map.setFitView();//根据地图上添加的覆盖物分布情况，自动缩放地图到合适的视野级别
                editor._circleEditor= new AMap.CircleEditor(map, editor._circle);


                //初始化地图选点
                AMapUI.loadUI(['misc/PositionPicker'], function(PositionPicker) {
                    var positionPicker = new PositionPicker({
                        mode: 'dragMarker',
                        map: map
                    });

                    //开始选取坐标
                    $('#start_position').click(function () {
                        positionPicker.start(lnglat);

                        //坐标点为空时不打开圆形编辑
                       if(lnglat !=''){
                           editor._circleEditor.open(lnglat);
                           circleisopen=true;
                       }
//                        map.setStatus({dragEnable: true});//是否允许拖拽地图
//                        map.setStatus({keyboardEnable: true});//是否允许键盘平移
                    })

                    //结束选取坐标
                    $('#stop_position').click(function () {
//                        map.setStatus({dragEnable: false});//是否允许拖拽地图
//                        map.setStatus({keyboardEnable: false});//是否允许键盘平移
                        if(editor._circle.getRadius()<(parseInt($('#fixed_km').val()))*1000){
                            tip.msgbox.err("配送半径不能小于"+parseInt($('#fixed_km').val())+"公里");
                            return;
                        }

                        map.panTo(lnglat);
                        positionPicker.stop();
                        editor._circleEditor.close();
                        map.setFitView();//根据地图上添加的覆盖物分布情况，自动缩放地图到合适的视野级别

                        $("input[name='lng']").val(lnglat.lng);
                        $("input[name='lat']").val(lnglat.lat);
                        $("input[name='range']").val(editor._circle.getRadius());
                        $("input[name='zoom']").val(map.getZoom());
                    });


                    positionPicker.on('success', function(positionResult) {
                        lnglat=positionResult.position;
                        marker.setPosition(lnglat); //更新点标记位置
                        editor._circle.setCenter(lnglat);//更新中心点坐标

                        //获取当前坐标后再打开圆形编辑
                        if(circleisopen==false){
                            editor._circleEditor.open(lnglat);
                        }
                    });
                });

                //达达城市选择器，选择城市地图跳转到相应城市
                $('#city_code').change(function () {
                    var city = $(this).find("option:selected").text();
                    $.ajax({
                        url: "<?php  echo webUrl('shop/cityexpress/getlocation')?>",
                        dataType: 'json',
                        data: {city: city},
                        success: function (ret) {
                                if (ret.status ==1) {
                                    lnglat=ret['result']['location'];
                                    map.panTo(lnglat);
                                    marker.setPosition(lnglat); //更新点标记位置
                                    editor._circle.setCenter(lnglat);//更新中心点坐标

                                    $("input[name='lng']").val(lnglat[0]);
                                    $("input[name='lat']").val(lnglat[1]);
                            }
                        }
                    });
                });

                //设置地图圆的半径
                function setRadius(radius) {
                    editor._circle.setRadius(radius*1000);
                    map.setFitView();
                }
            </script>
        </div>

        <div class="form-group"></div>
        <div class="form-group">
            <label class="col-lg control-label "></label>
            <div class="col-sm-9 col-xs-12">
                <?php if( ce('shop.cityexpress' ,$cityexpress) ) { ?>
                    <input type="submit" value="提交" class="btn btn-primary"  />
                <?php  } ?>
            </div>
        </div>
    </form>
</div>


<script language='javascript'>
    $(function () {
        $('#express_type').change(function () {
            if($(this).val()==0){
                $('.dada').hide();
//                $('.form-group.tel').show();
            }else if($(this).val()==1){
                $('.dada').show();
//                $('.form-group.tel').hide();
            } else if($(this).val()==2){
                $('.dada').hide();
//                $('.form-group.tel').hide();
            }
        });


        $('#start_km').change(function () {
            var start_km=parseInt($(this).val());
            var pre_km= parseInt($('#pre_km').val());
           if(start_km >0){
               $('#fixed_km').val(start_km+pre_km);
               $("input[name='range']").val((start_km+pre_km)*1000);
               setRadius(start_km+pre_km);
           }
        });

        $('#pre_km').change(function () {
            var start_km= parseInt($('#start_km').val());
            var pre_km=parseInt($(this).val());

            if(start_km >0){
                $('#fixed_km').val(start_km+pre_km);
                $("input[name='range']").val((start_km+pre_km)*1000);
                setRadius(start_km+pre_km);
            }
        });

    })
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>