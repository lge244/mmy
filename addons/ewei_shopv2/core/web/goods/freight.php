<?php
if (!(defined('IN_IA'))) {
	exit('Access Denied');
}

class Freight_EweiShopV2Page extends WebPage
{

	// 省级地区
	protected $address = [
		'北京', '天津', '河北省', '山西省', '内蒙古', '辽宁省', '吉林省', '黑龙江', '上海', '江苏省', '浙江省', '安徽省', '福建省',
		'江西省', '山东省', '河南省', '湖北省', '湖南省', '广东省', '广西省', '海南省', '重庆', '四川省', '贵州省', '云南省',
		'西藏', '陕西省', '甘肃省', '青海省', '宁夏', '新疆', '台湾省', '香港', '澳门'
	];

	public function main()
	{
		$list = pdo_getall('ewei_shop_freight');
		include $this->template();
	}

	public function form()
	{
		include $this->template();
	}

	public function save()
	{
		global $_GPC;
		$purchase_tax = $_GPC['purchase_tax'];
		if ($purchase_tax < 0) {
			exit(json_encode(array('code' => 1, 'msg' => '购物税不能低于零')));
		}
		$res = pdo_update('ewei_shop_purchase_tax', array('purchase_tax' => $purchase_tax));
		if ($res) {
			exit(json_encode(array('code' => 0, 'msg' => '设置成功')));
		}
		exit(json_encode(array('code' => 1, 'msg' => '设置失败！网络异常')));

	}

	public function del()
	{

	}
}