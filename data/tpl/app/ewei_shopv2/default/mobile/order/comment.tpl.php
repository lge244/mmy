<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class='fui-page  fui-page-current order-comment-page'>
    <div class="fui-header">
		<div class="fui-header-left">
			<a class="back" onclick='history.back()'></a>
		</div>
		<div class="title"><?php  if($order['iscomment']>0) { ?>追加<?php  } ?>评价</div>
		<div class="fui-header-right">&nbsp;</div>
    </div>
  	<div class='fui-content navbar'>
		<div class="fui-list-group goods-list-group">
			<div class="fui-list-group-title"><i class="icon icon-shop"></i> <?php  echo $_W['shopset']['shop']['name'];?></div>
			<?php  if(is_array($goods)) { foreach($goods as $g) { ?>
			<div class="fui-list goods-list" data-goodsid="<?php  echo $g['goodsid'];?>">
				<a class="fui-list-media" href="<?php  echo mobileUrl('goods/detail',array('id'=>$g['goodsid']))?>">
					<img src="<?php  echo tomedia($g['thumb'])?>" class="round">
				</a>
				<a class="fui-list-inner" href="<?php  echo mobileUrl('goods/detail',array('id'=>$g['goodsid']))?>">
					<div class="text goodstitle towline"><?php  echo $g['title'];?></div>
					<?php  if(!empty($g['optionid'])) { ?><div class='subtitle'><?php  echo $g['optiontitle'];?></div><?php  } ?>
				</a>
				<div class='fui-list-angle'>
					<p>￥<span class='marketprice'><?php  echo $g['price'];?><br/>x<?php  echo $g['total'];?></span></p>
					<?php  if(count($goods)>1) { ?>
						<div class='fui-label btn btn-danger-o goods-comment-btn'>评价 <i class='icon icon-unfold'></i></div>
					<?php  } ?>
				</div>
			</div>
			<div class="fui-cell-group goods-comment-cell">
				<?php  if($order['iscomment']==0) { ?>
				<div class='fui-cell'>
					<div class='fui-cell-label'>评分</div>
					<div class='fui-cell-info'>
						<div class='fui-stars warning' data-value='0'>
							<span class='stars'></span>
							<span class='fui-label fui-default'>没有评分</span>
							<i class='icon icon-roundclose clear'></i>
						</div>
					</div>
				</div>
				<?php  } ?>
				<div class='fui-cell'>
					<div class='fui-cell-label'>晒图</div>
					<div class='fui-cell-info'>
						<ul class="fui-images fui-images-sm"></ul>
						<div class="fui-uploader fui-uploader-sm" data-max="5" data-count="0">
							<input type="file" name="imgFile<?php  echo $g['id'];?>" id="imgFile<?php  echo $g['id'];?>" multiple="" accept="image/*" >
						</div>
					</div>
				</div>
				<div class='fui-cell'>
					<div class='fui-cell-label'>评论</div>
					<div class='fui-cell-info'><textarea rows="3" placeholder="说点什么吧"></textarea></div>
				</div>
			</div>
	    	<?php  } } ?>
		</div>

		<div class="fui-cell-group">
			<div class="fui-cell"><div class='fui-cell-info'>整单评价</div></div>
			<?php  if($order['iscomment']==0) { ?>
			<div class='fui-cell must'>
				<div class='fui-cell-label'>评分</div>
				<div class='fui-cell-info'>
					<div class='fui-stars warning'  data-value='0'>
						<span class='stars'></span>
						<span class='fui-label text-default'>没有评分</span>
						<i class='icon icon-roundclose clear'></i>
					</div>
				</div>
			</div>
			<?php  } ?>
			<div class='fui-cell'>
				<div class='fui-cell-label'>晒图</div>
				<div class='fui-cell-info'>
					<ul class="fui-images fui-images-sm" id="images"></ul>
					<div class="fui-uploader fui-uploader-sm" data-max="5" data-count="0">
						<input type="file" name='imgFile0' id='imgFile0' multiple="" accept="image/*" >
					</div>
				</div>
			</div>
			<div class='fui-cell must'>
				<div class='fui-cell-label '>评论</div>
				<div class='fui-cell-info'><textarea rows="3" placeholder="说点什么吧" id='comment'></textarea></div>
			</div>
		</div>
	</div>
	<div class='fui-navbar'>
		<a class='btn btn-danger btn-submit nav-item'>提交评价</a>
	</div>

    <script language='javascript'>require(['biz/order/comment'], function (modal) {
		modal.init({
			orderid: <?php  echo intval($order['id'])?> ,
			iscomment: <?php  echo intval($order['iscomment'])?> 
		}); 
	});</script>
</div> 
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--6Z2S5bKb5piT6IGU5LqS5Yqo572R57uc56eR5oqA5pyJ6ZmQ5YWs5Y+4-->