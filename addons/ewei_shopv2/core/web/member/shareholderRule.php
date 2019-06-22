<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class shareholderRule_EweiShopV2Page extends WebPage
{
	public function main()
	{
		$goods = pdo_getall('ewei_shop_goods', array('nosearch' => 1), array('id', 'title'));
		$agency_rule = pdo_get('shop_shareholder_rule');
		$agency_rule_arr = json_decode($agency_rule['shareholder_goodsid'], true);
		include $this->template();
	}

	public function add()
	{
		global $_GPC;
		$res = pdo_update('shop_shareholder_rule', array(
			'shareholder_purchase_time' => $_GPC['shareholder_purchase_time'],
			'shareholder_goodsid'       => json_encode($_GPC['shareholder_goodsid']),
			'shareholder_ratio'         => $_GPC['shareholder_ratio'],
			'pshareholder_ratio'        => $_GPC['pshareholder_ratio']
		));
		if (!$res) $this->message('规则保存失败');
		$this->message('规则保存成功', webUrl('member/shareholderRule'));;
	}
}