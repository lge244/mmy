<?php
if (!defined('IN_IA')) {
	exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
	/**
	 * 订单导出
	 */
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

	/**
	 * 商品导出
	 */
	public function good()
	{
		global $_GPC;
		$start_time = strtotime($_GPC['time']['start']);
		$end_time = strtotime($_GPC['time']['end']);
		if (empty($start_time) && empty($end_time)) $this->message('参数错误');
		$list = pdo_getall('ewei_shop_goods', ['createtime >' => $start_time, 'createtime <' => $end_time]);
		include $this->template();
	}
}