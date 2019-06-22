<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<style>
    .fui-icon-col.external.before:before{
        content: '';
        position: absolute;
        top: 1rem;
        bottom: 1rem;
        left: 0;
        width: 1px;
        background-color: #ebebeb;
        display: block;
        z-index: 15;
    }

</style>
<div class='fui-page  fui-page-current'>
    <div class="fui-header">
        <div class="fui-header-left">
            <a class="back" onclick='location.back()'></a>
        </div>
        <div class="title">代理</div>
        <div class="fui-header-right"></div>
    </div>
	<a class="fui-goods-item" data-goodsid="14"  data-type="1" data-nocache="true" style="position: relative;margin-top: 2rem;">
		<div class="detail">
			<div class="name" style="color: #000000;"><?php  echo htmlspecialchars_decode($info['content'])?></div>
		</div>
	</a>

	<?php  if(is_array($goods)) { foreach($goods as $g) { ?>
	<a class="fui-goods-item" data-goodsid="14" href="<?php  echo mobileUrl('goods/detail', ['id' => $g['id']])?>" data-type="1" data-nocache="true" style="position: relative;">
		<div class="image   triangle" data-text="热销" data-lazyloaded="true" style="background-image: url('<?php  echo tomedia($g['thumb'])?>');">
		</div>
		<div class="detail">
			<div class="name" style="color: #000000;"><?php  echo $g['title'];?></div>
			<p class="productprice noheight"></p>
			<div class="price buy">
				<span class="text" style="color: #ff5555;"><p class="minprice">¥<?php  echo $g['marketprice'];?></p></span>
				<span class="buy buybtn-1" id="buy-btn" style="border-color: #ff5555;color:  #fff">购买</span>
			</div>
		</div>
	</a>
	<?php  } } ?>
    <?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_copyright', TEMPLATE_INCLUDEPATH)) : (include template('_copyright', TEMPLATE_INCLUDEPATH));?>
</div>
<script>
	$(function () {
		$('#buy-btn').click(function () {
			window.location = "<?php  echo mobileUrl('goods/detail', ['id' => $goods['id']])?>";
		})
	})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>