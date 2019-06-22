<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>

</style>
<div class='fui-page fui-page-current store-selector-page' id="page-store-selector">
 
	<div class="fui-header">
	    <div class="fui-header-left">
		<a class="back"></a>
	    </div>
	    <div class="title">选择门店</div>
	    <div class="fui-header-right">
			<a href="javascript:;" id="btn-near"><i class="icon icon-dingwei"style="font-size:.7rem"></i> 离我最近</a>
		</div>
	</div>
	<div class='fui-content'>
	      <div class="fui-searchbar">
		<div class="searchbar">
		       <a class="searchbar-cancel">取消</a>
		      <div class="search-input">
		        <!--<i class="fa fa-search"></i>-->
		        <input type="search" placeholder="输入门店关键字..." id="search">
		      </div>
		</div>
	    </div>
	    <div class='content-empty' <?php  if(!empty($list)) { ?>style='display:none'<?php  } ?>>
			<i class='icon icon-store'></i>
			<br/>没有任何门店
	     </div>
	    <div class="fui-list-group" style="margin-top: 0" >
		
		<?php  if(is_array($list)) { foreach($list as $store) { ?>
		<!--<div  class="fui-list store-item" -->
		      <!--data-storeid="<?php  echo $store['id'];?>"-->
		      <!--data-lng="<?php  echo floatval($store['lng'])?>"-->
		      <!--data-lat="<?php  echo floatval($store['lat'])?>">-->
		    <!--<div class="fui-list-media">-->
			<!--<i class='icon icon-shop'></i>-->
		    <!--</div>-->
		    <!--<div class="fui-list-inner">-->
			<!--<div class="title"> <span class='storename'><?php  echo $store['storename'];?></span></div>-->
			<!--<div class="text">-->
			    <!--<span class='realname'><?php  echo $store['realname'];?></span> <span class='mobile'><?php  echo $store['mobile'];?></span>-->
			<!--</div>-->
			<!--<div class="text">-->
			    <!--<span class='address'><?php  echo $store['address'];?></span>-->
			<!--</div>-->
			<!--<div class="text location" style="color:green;display:none">正在计算距离...</div>-->
		    <!--</div> -->
		     <!--<div class="fui-list-angle">-->
			 <!--//<?php  if(!empty($store['tel'])) { ?><a href="tel:<?php  echo $store['tel'];?>" class='external '><i class=' icon icon-phone' style='color:green'></i></a><?php  } ?>-->
			 <!--<a href="<?php  echo mobileUrl('store/map',array('id'=>$store['id'],'merchid'=>$store['merchid']))?>" class='external' ><i class='icon icon-location' style='color:#f90'></i></a>-->
  		      <!--</div>-->
		<!--</div>-->
			<div   class="fui-list store-item"
				   data-storeid="<?php  echo $store['id'];?>"
				   data-lng="<?php  echo floatval($store['lng'])?>"
				   data-lat="<?php  echo floatval($store['lat'])?>"
				   data-storename="<?php  echo $store['storename'];?>"
				   data-realname="<?php  echo $store['realname'];?>"
				   data-mobile="<?php  echo $store['mobile'];?>"
				   data-address="<?php  echo $store['address'];?>"
				   data-map="<?php  echo mobileUrl('store/map',array('id'=>$store['id'],'merchid'=>$store['merchid']))?>"
			>
				<div class="fui-list-media" style="margin-right: 0.25rem;">
					<i class="icon icon-duihao_fuzhi1">
					</i>
				</div>
				<div class="fui-list-inner">
					<div class="title has-address">
                                    <span class="storename">
                                        <?php  echo $store['storename'];?>
                                    </span>
						<div class="text"style="display: none">
							<span class='realname'><?php  echo $store['realname'];?></span> <span class='mobile'><?php  echo $store['mobile'];?></span>
						</div>
					</div>
					<div class="text">
                                    <span class="aline address">
                                        地址：<?php  echo $store['address'];?>
                                    </span>
					</div>
					<div style="font-size:.65rem;color:#999;display: flex;align-items: center" >
						<i class="icon icon-dingwei"style="color:#999;display: none">
						</i>
						<div class="text location" style="color:#999;margin-left:.2rem;display:none">正在计算距离...</div>
					</div>
				</div>
				<div class="fui-list-angle">
					<i class="icon icon-xiangqing-copy">
					</i>
				</div>
			</div>
		<?php  } } ?>
	    </div> 
	</div>

	<script type="text/javascript" src="https://api.map.baidu.com/api?v=2.0&ak=ZQiFErjQB7inrGpx27M1GR5w3TxZ64k7&s=1"></script>
    <script language='javascript'>
	    require(['biz/store/selector'], function (modal) {
		modal.init()
                });</script>
<!--<div class="fui-list-group" style="position: fixed;-->
    <!--bottom: 2.15rem;-->
    <!--left: 0;-->
    <!--right: 0;-->
    <!--background:#e9e9e9">-->
	<!--<a class="fui-list " href="http://192.168.100.64/mjy/contacts.html">-->
		<!--<div class="fui-list-inner" style="border:0">-->
			<!--<div class="title has-address">-->
				<!--提货人：-->
				<!--<span class="realname">-->
                                    <!--徐小花-->
                                <!--</span>-->
				<!--<span class="mobile">-->
                                    <!--18265320332-->
                                <!--</span>-->
			<!--</div>-->
		<!--</div>-->
		<!--<div class="fui-list-angle" style="width: auto">-->
			<!--<div class="angle" style="position:static;">-->
			<!--</div>-->
		<!--</div>-->
	<!--</a>-->
<!--</div>-->
<!--<a class="fui-btn-confirm">-->
	<!--确定-->
<!--</a>-->
<!--</div>-->
<div id="shopmask" style="display: none;">
	<div class="shopmask-alert">
		<div class="shopmask-title"></div>
		<div class="shopmask-content">
			<div class="shopmask-content-title">地址</div>
			<div class="shopmask-content-subtitle address">
				<div></div>
				<a href="" class='external' ><i class="icon icon-dingwei"></i></a>
			</div>
		</div>
		<div class="shopmask-content">
			<div class="shopmask-content-title">电话</div>
			<a >
				<div class="shopmask-content-subtitle mobile">
					<div></div>
					<i class="icon icon-dianhua"></i>
				</div>
			</a>
		</div>
		<div class="shopmask-content">
			<div class="shopmask-content-title">联系人</div>
			<div class="shopmask-content-subtitle realname">
				<div></div>
			</div>
		</div>
		<div class="shopmask-bottom">
			我知道了
		</div>
	</div>
</div>
<script>


</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->