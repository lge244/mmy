<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Agency_EweiShopV2Page extends MobilePage
{
	public function main()
	{
		$info = pdo_get('content', array('id' => 1), array('content'));
		$ids = pdo_get("ewei_shop_member_level", array('uniacid' => 2), array('goodsid'));
		$goods = pdo_get("ewei_shop_goods", array('id' => $ids['goodsid']));
		include $this->template();
	}

}