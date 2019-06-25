<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	public function order()
	{
		global $_GPC;
		$openid = $_GPC['openid'];
		$start_time = strtotime($_GPC['time']['start']);
		$end_time = strtotime($_GPC['time']['end']);
		if (empty($openid) && empty($start_time) && empty($end_time)) $this->message('条件不能全部为空');
		if (empty($openid) && !empty($start_time) && !empty($end_time)) {
			$condition = ' a.createtime between ' . $start_time . ' and ' . $end_time;
		}
		if (!empty($openid) && !empty($start_time) && !empty($end_time)) {
			$condition = ' a.openid = ' . $openid . ' a.createtime between ' . $start_time . ' and ' . $end_time;
		}
		if (!empty($openid) && empty($start_time) && empty($end_time)) {
			$condition = ' a.openid = ' . $openid;
		}
		$sql = "select a.*,b.realname,b.level,d.total from `ims_ewei_shop_order` a left join `ims_ewei_shop_order_goods` d on a.id = d.orderid left join `ims_ewei_shop_member` b on a.openid = b.openid where" . $condition;
		$list = pdo_fetchall($sql);

		include $this->template();
	}
}