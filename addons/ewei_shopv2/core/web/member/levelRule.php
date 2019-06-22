<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class LevelRule_EweiShopV2Page extends WebPage
{
	public function main()
	{
		$goods = pdo_getall('ewei_shop_goods', array('nosearch' => 1), array('id', 'title'));
		$agency_rule = pdo_get('shop_agency_rule');
		$agency_rule_arr = json_decode($agency_rule['agency_goodsid'], true);
		include $this->template();
	}

	public function add()
	{
		global $_GPC;
		$agency_purchase_time = $_GPC['agency_purchase_time'];
		$agency_goodsid = json_encode($_GPC['agency_goodsid']);
		$res = pdo_update('shop_agency_rule', array('agency_purchase_time' => $agency_purchase_time, 'agency_goodsid' => $agency_goodsid));
		if (!$res) $this->message('规则保存失败!');
		$this->message('规则保存成功!', webUrl('member/levelRule'));
	}
}