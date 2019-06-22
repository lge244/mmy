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
		global $_GPC;
		$id = $_GPC['id'];
		$info = pdo_get('ewei_shop_freight', ['id' => $id]);
		$address = $this->address;
		include($this->template());
	}

	public function save()
	{
		global $_GPC;
		$id = $_GPC['id'];
		$address = $_GPC['address'];
		$distance_shipping = $_GPC['distance_shipping'];
		$first_weight = $_GPC['first_weight'];
		$continued_weight = $_GPC['continued_weight'];
		$first_weight_price = $_GPC['first_weight_price'];
		$continued_weight_price = $_GPC['continued_weight_price'];
		if (empty($address) || empty($distance_shipping) || empty($first_weight) || empty($continued_weight) ||
			empty($first_weight_price) || empty($continued_weight_price)) $this->message('请将信息填写完整');
		if (!is_numeric($distance_shipping) || !is_numeric($first_weight) || !is_numeric($continued_weight) ||
			!is_numeric($first_weight_price) || !is_numeric($continued_weight_price)) $this->message('参数不合法');
		if (empty($id)) {
			// 增加
			$info = pdo_get('ewei_shop_freight', ['address' => $address]);
			if ($info !== false) $this->message('该地址已经添加过');
			$res = pdo_insert('ewei_shop_freight', [
				'address'                => $address,
				'distance_shipping'      => $distance_shipping,
				'first_weight'           => $first_weight,
				'continued_weight'       => $continued_weight,
				'first_weight_price'     => $first_weight_price,
				'continued_weight_price' => $continued_weight_price,
				'create_time'            => time()
			]);
			if (!$res) $this->message('添加失败');
			$this->message('添加成功', webUrl('goods/freight'));
		} else {
			// 编辑
			$res = pdo_update('ewei_shop_freight', [
				'address'                => $address,
				'distance_shipping'      => $distance_shipping,
				'first_weight'           => $first_weight,
				'continued_weight'       => $continued_weight,
				'first_weight_price'     => $first_weight_price,
				'continued_weight_price' => $continued_weight_price
			], ['id' => $id]);
			if (!$res) $this->message('更新失败');
			$this->message('更新成功', webUrl('goods/freight'));
		}

	}

	public function del()
	{
		global $_GPC;
		$id = $_GPC['id'];
		pdo_delete('ewei_shop_freight', ['id' => $id]);
		show_json(1);
	}
}