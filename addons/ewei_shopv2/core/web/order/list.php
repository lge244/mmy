<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class List_EweiShopV2Page extends WebPage
{
	protected function orderData($status, $st) 
	{
		global $_W;
		global $_GPC;
		$pindex = max(1, intval($_GPC['page']));
		$psize = 20;
		$merch_plugin = p('merch');
		$merch_data = m('common')->getPluginset('merch');
		if ($merch_plugin && $merch_data['is_openmerch']) 
		{
			$is_openmerch = 1;
			$this->updateChildOrderPay();
		}
		else 
		{
			$is_openmerch = 0;
		}
		if ($st == 'main') 
		{
			$st = '';
		}
		else 
		{
			$st = '.' . $st;
		}
		$sendtype = ((!(isset($_GPC['sendtype'])) ? 0 : $_GPC['sendtype']));
		$condition = ' o.uniacid = :uniacid and o.ismr=0 and o.deleted=0 and o.isparent=0 and o.istrade=0 and iscycelbuy=0';
		$uniacid = $_W['uniacid'];
		$paras = $paras1 = array(':uniacid' => $uniacid);
		$merch_data = m('common')->getPluginset('merch');
		if (empty($starttime) || empty($endtime)) 
		{
			$starttime = strtotime('-1 month');
			$endtime = time();
		}
		$priceCondition = '';
		$orderbuy = 'o.createtime';
		$searchtime = trim($_GPC['searchtime']);
		if (!(empty($searchtime)) && is_array($_GPC['time']) && in_array($searchtime, array('create', 'pay', 'send', 'finish'))) 
		{
			$starttime = strtotime($_GPC['time']['start']);
			$endtime = strtotime($_GPC['time']['end']);
			$condition .= ' AND o.' . $searchtime . 'time >= :starttime AND o.' . $searchtime . 'time <= :endtime ';
			$paras[':starttime'] = $starttime;
			$paras[':endtime'] = $endtime;
			$priceCondition .= ' AND o.' . $searchtime . 'time >= ' . $starttime . ' AND o.' . $searchtime . 'time <= ' . $endtime . ' ';
			$timeCondition .= ' AND o.' . $searchtime . 'time >= ' . $starttime . ' AND o.' . $searchtime . 'time <= ' . $endtime . ' ';
			$orderbuy = 'o.' . $searchtime . 'time';
		}
		if ($_GPC['paytype'] != '') 
		{
			if ($_GPC['paytype'] == '2') 
			{
				$condition .= ' AND ( o.paytype =21 or o.paytype=22 or o.paytype=23 )';
				$priceCondition .= ' AND ( o.paytype =21 or o.paytype=22 or o.paytype=23 )';
			}
			else if ($_GPC['paytype'] == '4') 
			{
				$condition .= ' AND o.paytype = 3 AND is_cashier = 1 ';
				$priceCondition .= ' AND o.paytype = 3 AND is_cashier = 1 ';
			}
			else 
			{
				$condition .= ' AND o.paytype =' . intval($_GPC['paytype']);
				$priceCondition .= ' AND o.paytype =' . intval($_GPC['paytype']);
			}
		}
		if (!(empty($_GPC['searchfield'])) && !(empty($_GPC['keyword']))) 
		{
			$searchfield = trim(strtolower($_GPC['searchfield']));
			$_GPC['keyword'] = trim($_GPC['keyword']);
			$paras[':keyword'] = htmlspecialchars_decode($_GPC['keyword'], ENT_QUOTES);
			$sqlcondition = '';
			if ($searchfield == 'ordersn') 
			{
				$condition .= ' AND locate(:keyword,o.ordersn)>0';
			}
			else if ($searchfield == 'member') 
			{
				if (empty($_GPC['isprecise'])) 
				{
					$condition .= ' AND (locate(:keyword,m.realname)>0 or locate(:keyword,m.mobile)>0 or locate(:keyword,m.nickname)>0)';
				}
				else 
				{
					$condition .= ' AND (m.realname=:keyword or m.mobile=:keyword or m.nickname=:keyword)';
				}
				$priceCondition .= ' AND (nickname LIKE \'%' . $_GPC['keyword'] . '%\' OR realname LIKE \'%' . $_GPC['keyword'] . '%\' OR mobile LIKE \'%' . $_GPC['keyword'] . '%\') ';
				$memberCondition = ' AND (nickname LIKE \'%' . $_GPC['keyword'] . '%\' OR realname LIKE \'%' . $_GPC['keyword'] . '%\' OR mobile LIKE \'%' . $_GPC['keyword'] . '%\') ';
			}
			else if ($searchfield == 'mid') 
			{
				$condition .= ' AND m.id = :keyword';
			}
			else if ($searchfield == 'address') 
			{
				$condition .= ' AND ( locate(:keyword,a.realname)>0 or locate(:keyword,a.mobile)>0 or locate(:keyword,o.carrier)>0 or locate(:keyword,o.address)>0)';
				$priceCondition .= ' AND (a.realname LIKE \'' . $_GPC['keyword'] . '%\' OR a.mobile LIKE \'' . $_GPC['keyword'] . '%\')';
			}
			else if ($searchfield == 'location') 
			{
				$condition .= ' AND ( locate(:keyword,o.address)>0 or locate(:keyword,o.address_send)>0 )';
				$priceCondition .= ' AND (o.address LIKE \'%' . $_GPC['keyword'] . '%\' OR o.address_send LIKE \'%' . $_GPC['keyword'] . '%\' ) ';
			}
			else if ($searchfield == 'expresssn') 
			{
				$condition .= ' AND locate(:keyword,o.expresssn)>0';
			}
			else if ($searchfield == 'saler') 
			{
				$condition .= ' AND (locate(:keyword,sm.realname)>0 or locate(:keyword,sm.mobile)>0 or locate(:keyword,sm.nickname)>0 or locate(:keyword,s.salername)>0 )';
			}
			else if ($searchfield == 'verifycode') 
			{
				$condition .= ' AND (verifycode=:keyword or locate(:keyword,o.verifycodes)>0)';
			}
			else if ($searchfield == 'store') 
			{
				$condition .= ' AND (locate(:keyword,store.storename)>0)';
				$sqlcondition = ' left join ' . tablename('ewei_shop_store') . ' store on store.id = o.verifystoreid and store.uniacid=o.uniacid';
			}
			else if ($searchfield == 'goodstitle') 
			{
				$sqlcondition = ' inner join ( select DISTINCT(og.orderid) from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,g.title)>0)) gs on gs.orderid=o.id';
			}
			else if ($searchfield == 'goodssn') 
			{
				$sqlcondition = ' inner join ( select DISTINCT(og.orderid) from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (((locate(:keyword,g.goodssn)>0)) or (locate(:keyword,og.goodssn)>0))) gs on gs.orderid=o.id';
			}
			else if ($searchfield == 'goodsoptiontitle') 
			{
				$sqlcondition = ' inner join ( select  DISTINCT(og.orderid) from ' . tablename('ewei_shop_order_goods') . ' og left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid where og.uniacid = \'' . $uniacid . '\' and (locate(:keyword,og.optionname)>0)) gs on gs.orderid=o.id';
			}
			else if ($searchfield == 'merch') 
			{
				if ($merch_plugin) 
				{
					$condition .= ' AND (locate(:keyword,merch.merchname)>0)';
					$sqlcondition = ' left join ' . tablename('ewei_shop_merch_user') . ' merch on merch.id = o.merchid and merch.uniacid=o.uniacid';
				}
			}
			else if ($searchfield == 'selfget') 
			{
				$condition .= ' AND (locate(:keyword,store.storename)>0)';
				$sqlcondition = ' left join ' . tablename('ewei_shop_store') . ' store on store.id = o.storeid and store.uniacid=o.uniacid';
			}
		}
		$statuscondition = '';
		if ($status !== '') 
		{
			if ($status == '-1') 
			{
				$statuscondition = ' AND o.status=-1 and o.refundtime=0';
				$priceStatus = ' AND status=-1 and refundtime=0';
			}
			else if ($status == '4') 
			{
				$statuscondition = ' AND o.refundstate>0 and o.refundid<>0';
				$priceStatus = ' AND refundstate>0 and refundid<>0';
			}
			else if ($status == '5') 
			{
				$statuscondition = ' AND o.refundtime<>0';
				$priceStatus = ' AND refundtime<>0';
			}
			else if ($status == '1') 
			{
				$statuscondition = ' AND ( o.status = 1 or (o.status=0 and o.paytype=3) )';
				$priceStatus = ' AND ( status = 1 or (status=0 and paytype=3) )';
			}
			else if ($status == '0') 
			{
				$statuscondition = ' AND o.status = 0 and o.paytype<>3';
				$priceStatus = ' AND status = 0 and paytype<>3';
			}
			else if ($status == '2') 
			{
				$statuscondition = ' AND ( o.status = 2 or (o.status=1 and o.sendtype>0) )';
				$priceStatus = ' AND (  status = 2 or (status=1 and sendtype>0) )';
			}
			else 
			{
				$statuscondition = ' AND o.status = ' . intval($status);
				$priceStatus = ' AND o.status = ' . intval($status);
			}
		}
		$agentid = intval($_GPC['agentid']);
		$p = p('commission');
		$level = 0;
		if ($p) 
		{
			$cset = $p->getSet();
			$level = intval($cset['level']);
		}
		$olevel = intval($_GPC['olevel']);
		if (!(empty($agentid)) && (0 < $level)) 
		{
			$agent = $p->getInfo($agentid, array());
			if (!(empty($agent))) 
			{
				$agentLevel = $p->getLevel($agentid);
			}
			if (empty($olevel)) 
			{
				if (1 <= $level) 
				{
					$condition .= ' and  ( o.agentid=' . intval($_GPC['agentid']);
				}
				if ((2 <= $level) && (0 < $agent['level2'])) 
				{
					$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
				}
				if ((3 <= $level) && (0 < $agent['level3'])) 
				{
					$condition .= ' or o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
				}
				if (1 <= $level) 
				{
					$condition .= ')';
				}
			}
			else if ($olevel == 1) 
			{
				$condition .= ' and  o.agentid=' . intval($_GPC['agentid']);
			}
			else if ($olevel == 2) 
			{
				if (0 < $agent['level2']) 
				{
					$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level1_agentids'])) . ')';
				}
				else 
				{
					$condition .= ' and o.agentid in( 0 )';
				}
			}
			else if ($olevel == 3) 
			{
				if (0 < $agent['level3']) 
				{
					$condition .= ' and o.agentid in( ' . implode(',', array_keys($agent['level2_agentids'])) . ')';
				}
				else 
				{
					$condition .= ' and o.agentid in( 0 )';
				}
			}
		}
		$heads = intval($_GPC['headsid']);
		$dividend = p('dividend');
		if ($dividend && !(empty($heads))) 
		{
			$condition .= ' and o.headsid = ' . $heads;
		}
		$authorid = intval($_GPC['authorid']);
		$author = p('author');
		if ($author && !(empty($authorid))) 
		{
			$condition .= ' and o.authorid = :authorid';
			$paras[':authorid'] = $authorid;
		}
		if (($condition != ' o.uniacid = :uniacid and o.ismr=0 and o.deleted=0 and o.isparent=0 and o.istrade=0 ') || !(empty($sqlcondition))) 
		{
			$sql = 'select o.* , a.realname as arealname,a.mobile as amobile,a.province as aprovince ,a.city as acity , a.area as aarea, a.street as astreet,a.address as aaddress,' . "\r\n" . '                  d.dispatchname,m.nickname,m.id as mid,m.realname as mrealname,m.mobile as mmobile,m.uid,sm.id as salerid,sm.nickname as salernickname,s.salername,' . "\r\n" . '                  r.rtype,r.status as rstatus,o.sendtype,o.city_express_state,o.status as sta from ' . tablename('ewei_shop_order') . ' o' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_member') . ' m on m.openid=o.openid and m.uniacid =  o.uniacid ' . ' left join ' . tablename('ewei_shop_member_address') . ' a on a.id=o.addressid ' . ' left join ' . tablename('ewei_shop_dispatch') . ' d on d.id = o.dispatchid ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . ' ' . $sqlcondition . ' where ' . $condition . ' ' . $statuscondition . ' GROUP BY o.id ORDER BY ' . $orderbuy . ' DESC  ';
			if (empty($_GPC['export'])) 
			{
				$sql .= 'LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			}
			$list = pdo_fetchall($sql, $paras);
		}
		else 
		{
			$status_condition = str_replace('o.', '', $statuscondition);
			$sql = 'select * from ' . tablename('ewei_shop_order') . ' where uniacid = :uniacid and ismr=0 and deleted=0 and isparent=0 ' . $status_condition . ' GROUP BY id ORDER BY createtime DESC  ';
			if (empty($_GPC['export'])) 
			{
				$sql .= 'LIMIT ' . (($pindex - 1) * $psize) . ',' . $psize;
			}
			$list = pdo_fetchall($sql, $paras);
			if (!(empty($list))) 
			{
				$refundid = '';
				$openid = '';
				$addressid = '';
				$dispatchid = '';
				$verifyopenid = '';
				foreach ($list as $key => $value ) 
				{
					$refundid .= ',\'' . $value['refundid'] . '\'';
					$openid .= ',\'' . $value['openid'] . '\'';
					$addressid .= ',\'' . $value['addressid'] . '\'';
					$dispatchid .= ',\'' . $value['dispatchid'] . '\'';
					$verifyopenid .= ',\'' . $value['verifyopenid'] . '\'';
				}
				$refundid = ltrim($refundid, ',');
				$openid = ltrim($openid, ',');
				$addressid = ltrim($addressid, ',');
				$dispatchid = ltrim($dispatchid, ',');
				$verifyopenid = ltrim($verifyopenid, ',');
				$refundid_array = pdo_fetchall('SELECT id,rtype,status as rstatus FROM ' . tablename('ewei_shop_order_refund') . ' WHERE id IN (' . $refundid . ')', array(), 'id');
				$openid_array = pdo_fetchall('SELECT openid,nickname,id as mid,realname as mrealname,uid,mobile as mmobile FROM ' . tablename('ewei_shop_member') . ' WHERE openid IN (' . $openid . ') AND uniacid=' . $_W['uniacid'], array(), 'openid');
				$addressid_array = pdo_fetchall('SELECT id,realname as arealname,mobile as amobile,province as aprovince ,city as acity , area as aarea,address as aaddress FROM ' . tablename('ewei_shop_member_address') . ' WHERE id IN (' . $addressid . ')', array(), 'id');
				$dispatchid_array = pdo_fetchall('SELECT id,dispatchname FROM ' . tablename('ewei_shop_dispatch') . ' WHERE id IN (' . $dispatchid . ')', array(), 'id');
				$verifyopenid_array = pdo_fetchall('SELECT sm.id as salerid,sm.nickname as salernickname,sm.openid,s.salername FROM ' . tablename('ewei_shop_saler') . ' s LEFT JOIN ' . tablename('ewei_shop_member') . ' sm ON sm.openid = s.openid and sm.uniacid=s.uniacid WHERE s.openid IN (' . $verifyopenid . ')', array(), 'openid');
				foreach ($list as $key => &$value ) 
				{
					$list[$key]['rtype'] = $refundid_array[$value['refundid']]['rtype'];
					$list[$key]['rstatus'] = $refundid_array[$value['refundid']]['rstatus'];
					$list[$key]['nickname'] = $openid_array[$value['openid']]['nickname'];
					$list[$key]['mid'] = $openid_array[$value['openid']]['mid'];
					$list[$key]['uid'] = $openid_array[$value['openid']]['uid'];
					$list[$key]['mrealname'] = $openid_array[$value['openid']]['mrealname'];
					$list[$key]['mmobile'] = $openid_array[$value['openid']]['mmobile'];
					$list[$key]['arealname'] = $addressid_array[$value['addressid']]['arealname'];
					$list[$key]['amobile'] = $addressid_array[$value['addressid']]['amobile'];
					$list[$key]['aprovince'] = $addressid_array[$value['addressid']]['aprovince'];
					$list[$key]['acity'] = $addressid_array[$value['addressid']]['acity'];
					$list[$key]['aarea'] = $addressid_array[$value['addressid']]['aarea'];
					$list[$key]['astreet'] = $addressid_array[$value['addressid']]['astreet'];
					$list[$key]['aaddress'] = $addressid_array[$value['addressid']]['aaddress'];
					$list[$key]['dispatchname'] = $dispatchid_array[$value['dispatchid']]['dispatchname'];
					$list[$key]['salerid'] = $verifyopenid_array[$value['verifyopenid']]['salerid'];
					$list[$key]['salernickname'] = $verifyopenid_array[$value['verifyopenid']]['salernickname'];
					$list[$key]['salername'] = $verifyopenid_array[$value['verifyopenid']]['salername'];
				}
				unset($value);
			}
		}
		$paytype = array( 0 => array('css' => 'default', 'name' => '未支付'), 1 => array('css' => 'danger', 'name' => '余额支付'), 11 => array('css' => 'default', 'name' => '后台付款'), 2 => array('css' => 'danger', 'name' => '在线支付'), 21 => array('css' => 'success', 'name' => '微信支付'), 22 => array('css' => 'warning', 'name' => '支付宝支付'), 23 => array('css' => 'warning', 'name' => '银联支付'), 3 => array('css' => 'primary', 'name' => '货到付款'), 4 => array('css' => 'primary', 'name' => '收银台现金收款') );
		$orderstatus = array( -1 => array('css' => 'default', 'name' => '已关闭'), 0 => array('css' => 'danger', 'name' => '待付款'), 1 => array('css' => 'info', 'name' => '待发货'), 2 => array('css' => 'warning', 'name' => '待收货'), 3 => array('css' => 'success', 'name' => '已完成') );
		$is_merch = array();
		$is_merchname = 0;
		if ($merch_plugin) 
		{
			$merch_user = $merch_plugin->getListUser($list, 'merch_user');
			if (!(empty($merch_user))) 
			{
				$is_merchname = 1;
			}
		}
		if (!(empty($list))) 
		{
			$diy_title_data = array();
			$diy_data = array();
			foreach ($list as &$value ) 
			{
				if ($is_merchname == 1) 
				{
					$value['merchname'] = (($merch_user[$value['merchid']]['merchname'] ? $merch_user[$value['merchid']]['merchname'] : ''));
				}
				$s = $value['status'];
				$pt = $value['paytype'];
				$value['statusvalue'] = $s;
				$value['statuscss'] = $orderstatus[$value['status']]['css'];
				$value['status'] = $orderstatus[$value['status']]['name'];
				if (($pt == 3) && empty($value['statusvalue'])) 
				{
					$value['statuscss'] = $orderstatus[1]['css'];
					$value['status'] = $orderstatus[1]['name'];
				}
				if ($s == 1) 
				{
					if ($value['isverify'] == 1) 
					{
						$value['status'] = '待使用';
						if (0 < $value['sendtype']) 
						{
							$value['status'] = '部分使用';
						}
					}
					else if (empty($value['addressid'])) 
					{
						$value['status'] = '待取货';
					}
					else if (0 < $value['sendtype']) 
					{
						$value['status'] = '部分发货';
					}
				}
				if ($s == -1) 
				{
					if (!(empty($value['refundtime']))) 
					{
						$value['status'] = '已维权';
					}
				}
				$value['paytypevalue'] = $pt;
				$value['css'] = $paytype[$pt]['css'];
				$value['paytype'] = $paytype[$pt]['name'];
				$value['dispatchname'] = ((empty($value['addressid']) ? '自提' : $value['dispatchname']));
				if (empty($value['dispatchname'])) 
				{
					$value['dispatchname'] = '快递';
				}
				if ($value['city_express_state'] == 1) 
				{
					$value['dispatchname'] = '同城配送';
				}
				if ($pt == 3) 
				{
					$value['dispatchname'] = '货到付款';
				}
				else if ($value['isverify'] == 1) 
				{
					$value['dispatchname'] = '线下核销';
				}
				else if ($value['isvirtual'] == 1) 
				{
					$value['dispatchname'] = '虚拟物品';
				}
				else if (!(empty($value['virtual']))) 
				{
					$value['dispatchname'] = '虚拟物品(卡密)<br/>自动发货';
				}
				$isonlyverifygoods = m('order')->checkisonlyverifygoods($value['id']);
				if ($isonlyverifygoods) 
				{
					$value['dispatchname'] = '记次/时商品';
				}
				if (($value['dispatchtype'] == 1) || !(empty($value['isverify'])) || !(empty($value['virtual'])) || !(empty($value['isvirtual']))) 
				{
					$value['address'] = '';
					$carrier = iunserializer($value['carrier']);
					if (is_array($carrier)) 
					{
						$value['addressdata']['realname'] = $value['realname'] = $carrier['carrier_realname'];
						$value['addressdata']['mobile'] = $value['mobile'] = $carrier['carrier_mobile'];
					}
				}
				else 
				{
					$address = iunserializer($value['address']);
					$isarray = is_array($address);
					$value['realname'] = (($isarray ? $address['realname'] : $value['arealname']));
					$value['mobile'] = (($isarray ? $address['mobile'] : $value['amobile']));
					$value['province'] = (($isarray ? $address['province'] : $value['aprovince']));
					$value['city'] = (($isarray ? $address['city'] : $value['acity']));
					$value['area'] = (($isarray ? $address['area'] : $value['aarea']));
					$value['street'] = (($isarray ? $address['street'] : $value['astreet']));
					$value['address'] = (($isarray ? $address['address'] : $value['aaddress']));
					$value['address_province'] = $value['province'];
					$value['address_city'] = $value['city'];
					$value['address_area'] = $value['area'];
					$value['address_street'] = $value['street'];
					$value['address_address'] = $value['address'];
					$value['address'] = $value['province'] . ' ' . $value['city'] . ' ' . $value['area'] . ' ' . $value['address'];
					$value['addressdata'] = array('realname' => $value['realname'], 'mobile' => $value['mobile'], 'address' => $value['address']);
				}
				$commission1 = -1;
				$commission2 = -1;
				$commission3 = -1;
				$m1 = false;
				$m2 = false;
				$m3 = false;
				if (!(empty($level)) && empty($agentid)) 
				{
					if (!(empty($value['agentid']))) 
					{
						$m1 = m('member')->getMember($value['agentid']);
						$commission1 = 0;
						if (!(empty($m1['agentid'])) && (1 < $level)) 
						{
							$m2 = m('member')->getMember($m1['agentid']);
							$commission2 = 0;
							if (!(empty($m2['agentid'])) && (2 < $level)) 
							{
								$m3 = m('member')->getMember($m2['agentid']);
								$commission3 = 0;
							}
						}
					}
				}
				if (!(empty($agentid))) 
				{
					$magent = m('member')->getMember($agentid);
				}
				$order_goods = pdo_fetchall('select g.id,g.title,g.thumb,g.goodssn,og.goodssn as option_goodssn, g.productsn,og.productsn as option_productsn, og.total,' . "\r\n" . '                    og.price,og.optionname as optiontitle, og.realprice,og.changeprice,og.oldprice,og.commission1,og.commission2,og.commission3,og.commissions,og.diyformdata,' . "\r\n" . '                    og.diyformfields,op.specs,g.merchid,og.seckill,og.seckill_taskid,og.seckill_roomid,g.ispresell,g.costprice,op.costprice as option_costprice,og.expresssn,og.expresscom,og.express,og.sendtype from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join ' . tablename('ewei_shop_goods') . ' g on g.id=og.goodsid ' . ' left join ' . tablename('ewei_shop_goods_option') . ' op on og.optionid = op.id ' . ' where og.uniacid=:uniacid and og.orderid=:orderid ', array(':uniacid' => $uniacid, ':orderid' => $value['id']));
				$goods = '';
				foreach ($order_goods as &$og ) 
				{
					$og['seckill_task'] = false;
					$og['seckill_room'] = false;
					if ($og['seckill']) 
					{
						$og['seckill_task'] = plugin_run('seckill::getTaskInfo', $og['seckill_taskid']);
						$og['seckill_room'] = plugin_run('seckill::getRoomInfo', $og['seckill_taskid'], $og['seckill_roomid']);
					}
					if (!(empty($og['specs']))) 
					{
						$thumb = m('goods')->getSpecThumb($og['specs']);
						if (!(empty($thumb))) 
						{
							$og['thumb'] = $thumb;
						}
					}
					if (!(empty($og['option_costprice']))) 
					{
						$og['costprice'] = $og['option_costprice'];
					}
					if (!(empty($level)) && empty($agentid)) 
					{
						$commissions = iunserializer($og['commissions']);
						if (!(empty($m1))) 
						{
							if (is_array($commissions)) 
							{
								$commission1 += ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
							}
							else 
							{
								$c1 = iunserializer($og['commission1']);
								$l1 = $p->getLevel($m1['openid']);
								if (!(empty($c1))) 
								{
									$commission1 += ((isset($c1['level' . $l1['id']]) ? $c1['level' . $l1['id']] : $c1['default']));
								}
							}
						}
						if (!(empty($m2))) 
						{
							if (is_array($commissions)) 
							{
								$commission2 += ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
							}
							else 
							{
								$c2 = iunserializer($og['commission2']);
								$l2 = $p->getLevel($m2['openid']);
								if (!(empty($c2))) 
								{
									$commission2 += ((isset($c2['level' . $l2['id']]) ? $c2['level' . $l2['id']] : $c2['default']));
								}
							}
						}
						if (!(empty($m3))) 
						{
							if (is_array($commissions)) 
							{
								$commission3 += ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
							}
							else 
							{
								$c3 = iunserializer($og['commission3']);
								$l3 = $p->getLevel($m3['openid']);
								if (!(empty($c3))) 
								{
									$commission3 += ((isset($c3['level' . $l3['id']]) ? $c3['level' . $l3['id']] : $c3['default']));
								}
							}
						}
					}
					$goods .= '' . $og['title'] . "\r\n";
					if (!(empty($og['optiontitle']))) 
					{
						$goods .= ' 规格: ' . $og['optiontitle'];
					}
					if (!(empty($og['option_goodssn']))) 
					{
						$og['goodssn'] = $og['option_goodssn'];
					}
					if (!(empty($og['option_productsn']))) 
					{
						$og['productsn'] = $og['option_productsn'];
					}
					if (!(empty($og['goodssn']))) 
					{
						$goods .= ' 商品编号: ' . $og['goodssn'];
					}
					if (!(empty($og['productsn']))) 
					{
						$goods .= ' 商品条码: ' . $og['productsn'];
					}
					$goods .= ' 单价: ' . ($og['price'] / $og['total']) . ' 折扣后: ' . ($og['realprice'] / $og['total']) . ' 数量: ' . $og['total'] . ' 总价: ' . $og['price'] . ' 折扣后: ' . $og['realprice'] . "\r\n" . ' ';
					if (p('diyform') && !(empty($og['diyformfields'])) && !(empty($og['diyformdata']))) 
					{
						$diyformdata_array = p('diyform')->getDatas(iunserializer($og['diyformfields']), iunserializer($og['diyformdata']), 1);
						$diyformdata = '';
						$dflag = 1;
						foreach ($diyformdata_array as $da ) 
						{
							if (!(empty($diy_title_data))) 
							{
								if (array_key_exists($da['key'], $diy_title_data)) 
								{
									$dflag = 0;
								}
							}
							if ($dflag == 1) 
							{
								$diy_title_data[$da['key']] = $da['name'];
							}
							$og['goods_' . $da['key']] = $da['value'];
							$diyformdata .= $da['name'] . ': ' . $da['value'] . ' ' . "\r\n";
						}
						$og['goods_diyformdata'] = $diyformdata;
					}
				}
				unset($og);
				if (!(empty($level)) && empty($agentid)) 
				{
					$value['commission1'] = $commission1;
					$value['commission2'] = $commission2;
					$value['commission3'] = $commission3;
				}
				$value['goods'] = set_medias($order_goods, 'thumb');
				$value['goods_str'] = $goods;
				if (!(empty($agentid)) && (0 < $level)) 
				{
					$commission_level = 0;
					if ($value['agentid'] == $agentid) 
					{
						$value['level'] = 1;
						$level1_commissions = pdo_fetchall('select commission1,commissions  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and o.agentid= ' . $agentid . '  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));
						foreach ($level1_commissions as $c ) 
						{
							$commission = iunserializer($c['commission1']);
							$commissions = iunserializer($c['commissions']);
							if (empty($commissions)) 
							{
								$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
							}
							else 
							{
								$commission_level += ((isset($commissions['level1']) ? floatval($commissions['level1']) : 0));
							}
						}
					}
					else if (in_array($value['agentid'], array_keys($agent['level1_agentids']))) 
					{
						$value['level'] = 2;
						if (0 < $agent['level2']) 
						{
							$level2_commissions = pdo_fetchall('select commission2,commissions  from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level1_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));
							foreach ($level2_commissions as $c ) 
							{
								$commission = iunserializer($c['commission2']);
								$commissions = iunserializer($c['commissions']);
								if (empty($commissions)) 
								{
									$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
								}
								else 
								{
									$commission_level += ((isset($commissions['level2']) ? floatval($commissions['level2']) : 0));
								}
							}
						}
					}
					else if (in_array($value['agentid'], array_keys($agent['level2_agentids']))) 
					{
						$value['level'] = 3;
						if (0 < $agent['level3']) 
						{
							$level3_commissions = pdo_fetchall('select commission3,commissions from ' . tablename('ewei_shop_order_goods') . ' og ' . ' left join  ' . tablename('ewei_shop_order') . ' o on o.id = og.orderid ' . ' where og.orderid=:orderid and  o.agentid in ( ' . implode(',', array_keys($agent['level2_agentids'])) . ')  and o.uniacid=:uniacid', array(':orderid' => $value['id'], ':uniacid' => $uniacid));
							foreach ($level3_commissions as $c ) 
							{
								$commission = iunserializer($c['commission3']);
								$commissions = iunserializer($c['commissions']);
								if (empty($commissions)) 
								{
									$commission_level += ((isset($commission['level' . $agentLevel['id']]) ? $commission['level' . $agentLevel['id']] : $commission['default']));
								}
								else 
								{
									$commission_level += ((isset($commissions['level3']) ? floatval($commissions['level3']) : 0));
								}
							}
						}
					}
					$value['commission'] = $commission_level;
				}
			}
		}
		unset($value);
		set_time_limit(0);
		if ($_GPC['export'] == 1) 
		{
			plog('order.op.export', '导出订单');
			$columns = array( array('title' => '订单编号', 'field' => 'ordersn', 'width' => 24), array('title' => '粉丝昵称', 'field' => 'nickname', 'width' => 12), array('title' => '会员id', 'field' => 'uid', 'width' => 12), array('title' => '会员姓名', 'field' => 'mrealname', 'width' => 12), array('title' => 'openid', 'field' => 'openid', 'width' => 24), array('title' => '会员手机手机号', 'field' => 'mmobile', 'width' => 12), array('title' => '收货姓名(或自提人)', 'field' => 'realname', 'width' => 12), array('title' => '联系电话', 'field' => 'mobile', 'width' => 12), array('title' => '收货地址', 'field' => 'address_province', 'width' => 12), array('title' => '', 'field' => 'address_city', 'width' => 12), array('title' => '', 'field' => 'address_area', 'width' => 12), array('title' => '', 'field' => 'address_street', 'width' => 12), array('title' => '', 'field' => 'address_address', 'width' => 12), array('title' => '商品名称', 'field' => 'goods_title', 'width' => 24), array('title' => '商品编码', 'field' => 'goods_goodssn', 'width' => 12), array('title' => '商品规格', 'field' => 'goods_optiontitle', 'width' => 12), array('title' => '商品数量', 'field' => 'goods_total', 'width' => 12), array('title' => '商品单价(折扣前)', 'field' => 'goods_price1', 'width' => 12), array('title' => '商品单价(折扣后)', 'field' => 'goods_price2', 'width' => 12), array('title' => '商品价格(折扣前)', 'field' => 'goods_rprice1', 'width' => 12), array('title' => '商品价格(折扣后)', 'field' => 'goods_rprice2', 'width' => 12), array('title' => '商品成本价', 'field' => 'goods_costprice', 'width' => 12), array('title' => '支付方式', 'field' => 'paytype', 'width' => 12), array('title' => '配送方式', 'field' => 'dispatchname', 'width' => 12), array('title' => '自提门店', 'field' => 'pickname', 'width' => 24), array('title' => '自提码', 'field' => 'verifycode', 'width' => 24), array('title' => '商品小计', 'field' => 'goodsprice', 'width' => 12), array('title' => '运费', 'field' => 'dispatchprice', 'width' => 12), array('title' => '积分抵扣', 'field' => 'deductprice', 'width' => 12), array('title' => '余额抵扣', 'field' => 'deductcredit2', 'width' => 12), array('title' => '满额立减', 'field' => 'deductenough', 'width' => 12), array('title' => '优惠券优惠', 'field' => 'couponprice', 'width' => 12), array('title' => '订单改价', 'field' => 'changeprice', 'width' => 12), array('title' => '运费改价', 'field' => 'changedispatchprice', 'width' => 12), array('title' => '应收款', 'field' => 'price', 'width' => 12), array('title' => '状态', 'field' => 'status', 'width' => 12), array('title' => '维权状态', 'field' => 'refundstatus', 'width' => 20), array('title' => '下单时间', 'field' => 'createtime', 'width' => 24), array('title' => '付款时间', 'field' => 'paytime', 'width' => 24), array('title' => '发货时间', 'field' => 'sendtime', 'width' => 24), array('title' => '完成时间', 'field' => 'finishtime', 'width' => 24), array('title' => '快递公司', 'field' => 'expresscom', 'width' => 24), array('title' => '快递单号', 'field' => 'expresssn', 'width' => 24), array('title' => '订单备注', 'field' => 'remark', 'width' => 36), array('title' => '卖家订单备注', 'field' => 'remarksaler', 'width' => 36), array('title' => '核销员', 'field' => 'salerinfo', 'width' => 24), array('title' => '核销门店', 'field' => 'storeinfo', 'width' => 36), array('title' => '订单自定义信息', 'field' => 'order_diyformdata', 'width' => 36), array('title' => '商品自定义信息', 'field' => 'goods_diyformdata', 'width' => 36) );
			if (!(empty($agentid)) && (0 < $level)) 
			{
				$columns[] = array('title' => '分销级别', 'field' => 'level', 'width' => 24);
				$columns[] = array('title' => '分销佣金', 'field' => 'commission', 'width' => 24);
			}
			if (!(empty($diy_title_data))) 
			{
				foreach ($diy_title_data as $key => $value ) 
				{
					$field = 'goods_' . $key;
					$columns[] = array('title' => $value . '(商品自定义信息)', 'field' => $field, 'width' => 24);
				}
			}
			if ($merch_plugin) 
			{
				$columns[] = array('title' => '商户名称', 'field' => 'merchname', 'width' => 24);
			}
			$r_type = array('退款', '退货退款', '换货');
			foreach ($list as &$row ) 
			{
				$row['realname'] = str_replace('=', '', $row['realname']);
				$row['nickname'] = str_replace('=', '', $row['nickname']);
				$row['ordersn'] = $row['ordersn'] . ' ';
				$row['refundstatus'] = ((!(empty($row['refundstate'])) ? $r_type[$row['rtype']] . '申请' : ''));
				if (0 < $row['deductprice']) 
				{
					$row['deductprice'] = '-' . $row['deductprice'];
				}
				if (0 < $row['deductcredit2']) 
				{
					$row['deductcredit2'] = '-' . $row['deductcredit2'];
				}
				if (0 < $row['deductenough']) 
				{
					$row['deductenough'] = '-' . $row['deductenough'];
				}
				if ($row['changeprice'] < 0) 
				{
					$row['changeprice'] = '-' . $row['changeprice'];
				}
				else if (0 < $row['changeprice']) 
				{
					$row['changeprice'] = '+' . $row['changeprice'];
				}
				if ($row['changedispatchprice'] < 0) 
				{
					$row['changedispatchprice'] = '-' . $row['changedispatchprice'];
				}
				else if (0 < $row['changedispatchprice']) 
				{
					$row['changedispatchprice'] = '+' . $row['changedispatchprice'];
				}
				if (0 < $row['couponprice']) 
				{
					$row['couponprice'] = '-' . $row['couponprice'];
				}
				$row['nickname'] = ((strexists($row['nickname'], '^') ? '\'' . $row['nickname'] : $row['nickname']));
				$row['expresssn'] = ((strexists($row['expresssn'], '-') ? '\'' . $row['expresssn'] . ' ' : $row['expresssn'] . ' '));
				$row['expresssn'] = ((strexists($row['expresssn'], '=') ? '\'' . $row['expresssn'] . ' ' : $row['expresssn'] . ' '));
				$row['createtime'] = date('Y-m-d H:i:s', $row['createtime']);
				$row['paytime'] = ((!(empty($row['paytime'])) ? date('Y-m-d H:i:s', $row['paytime']) : ''));
				$row['sendtime'] = ((!(empty($row['sendtime'])) ? date('Y-m-d H:i:s', $row['sendtime']) : ''));
				$row['finishtime'] = ((!(empty($row['finishtime'])) ? date('Y-m-d H:i:s', $row['finishtime']) : ''));
				$row['salerinfo'] = '';
				$row['storeinfo'] = '';
				$row['pickname'] = '';
				if (!(empty($row['verifyopenid']))) 
				{
					if (!(empty($row['salerid'])) || !(empty($row['salername'])) || !(empty($row['salernickname']))) 
					{
						$row['salerinfo'] = '[' . $row['salerid'] . ']' . $row['salername'] . '(' . $row['salernickname'] . ')';
					}
				}
				else if (!(empty($row['verifyinfo']))) 
				{
					$verifyinfo = iunserializer($row['verifyinfo']);
					if (!(empty($verifyinfo))) 
					{
						foreach ($verifyinfo as $k => $v ) 
						{
							$verifyopenid = $v['verifyopenid'];
							if (!(empty($verifyopenid))) 
							{
								$verify_member = com('verify')->getSalerInfo($verifyopenid);
								$row['salerinfo'] .= '[' . $verify_member['salerid'] . ']' . $verify_member['salername'] . '(' . $verify_member['salernickname'] . ')';
							}
						}
					}
				}
				if (!(empty($row['verifystoreid']))) 
				{
					if (0 < $row['merchid']) 
					{
						$row['storeinfo'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid']));
					}
					else 
					{
						$row['storeinfo'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['verifystoreid']));
					}
				}
				else if (!(empty($row['verifyinfo']))) 
				{
					$verifyinfo = iunserializer($row['verifyinfo']);
					if (!(empty($verifyinfo))) 
					{
						foreach ($verifyinfo as $k => $v ) 
						{
							$verifystoreid = $v['verifystoreid'];
							if (!(empty($verifystoreid))) 
							{
								$verify_store = com('verify')->getStoreInfo($verifystoreid);
								$row['storeinfo'] .= $verify_store['storename'];
							}
						}
					}
				}
				if (!(empty($row['storeid']))) 
				{
					if (0 < $row['merchid']) 
					{
						$row['pickname'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['storeid']));
					}
					else 
					{
						$row['pickname'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_store') . ' where id=:storeid limit 1 ', array(':storeid' => $row['storeid']));
					}
				}
				if (p('diyform') && !(empty($row['diyformfields'])) && !(empty($row['diyformdata']))) 
				{
					$diyformdata_array = p('diyform')->getDatas(iunserializer($row['diyformfields']), iunserializer($row['diyformdata']));
					$diyformdata = '';
					foreach ($diyformdata_array as $da ) 
					{
						$diyformdata .= $da['name'] . ': ' . $da['value'] . "\r\n";
					}
					$row['order_diyformdata'] = $diyformdata;
				}
				if ($row['isverify']) 
				{
					if (is_array($verifyinfo)) 
					{
						if (empty($row['dispatchtype'])) 
						{
							$v = $verifyinfo[0];
							if ($v['verified'] || ($row['verifytype'] == 1)) 
							{
								$v['storename'] = pdo_fetchcolumn('select storename from ' . tablename('ewei_shop_merch_store') . ' where id=:id limit 1', array(':id' => $v['verifystoreid']));
								if (empty($v['storename'])) 
								{
									$v['storename'] = '总店';
								}
								$row['storeinfo'] = $v['storename'];
								$v['nickname'] = pdo_fetchcolumn('select nickname from ' . tablename('ewei_shop_member') . ' where openid=:openid and uniacid=:uniacid limit 1', array(':openid' => $v['verifyopenid'], ':uniacid' => $_W['uniacid']));
								$v['salername'] = pdo_fetchcolumn('select salername from ' . tablename('ewei_shop_merch_saler') . ' where openid=:openid and uniacid=:uniacid and merchid = :merchid limit 1', array(':openid' => $v['verifyopenid'], ':uniacid' => $_W['uniacid'], ':merchid' => $_W['merchid']));
								if (!(empty($v['nickname'])) || !(empty($v['nickname']))) 
								{
									$row['salerinfo'] = $v['salername'] . '(' . $v['nickname'] . ')';
								}
							}
							unset($v);
						}
					}
				}
			}
			unset($row);
			$exportlist = array();
			foreach ($list as &$r ) 
			{
				$ogoods = $r['goods'];
				unset($r['goods']);
				foreach ($ogoods as $k => $g ) 
				{
					if (0 < $k) 
					{
						$r['ordersn'] = '';
						$r['realname'] = '';
						$r['uid'] = '';
						$r['mobile'] = '';
						$r['openid'] = '';
						$r['nickname'] = '';
						$r['mrealname'] = '';
						$r['mmobile'] = '';
						$r['address'] = '';
						$r['address_province'] = '';
						$r['address_city'] = '';
						$r['address_area'] = '';
						$r['address_street'] = '';
						$r['address_address'] = '';
						$r['paytype'] = '';
						$r['dispatchname'] = '';
						$r['dispatchprice'] = '';
						$r['goodsprice'] = '';
						$r['status'] = '';
						$r['createtime'] = '';
						$r['sendtime'] = '';
						$r['finishtime'] = '';
						if (0 < $g['sendtype']) 
						{
							$r['expresssn'] = $g['expresssn'] . ' ';
							$r['express'] = $g['express'];
						}
						else 
						{
							$r['expresssn'] = '';
							$r['express'] = '';
						}
						$r['deductprice'] = '';
						$r['deductcredit2'] = '';
						$r['deductenough'] = '';
						$r['changeprice'] = '';
						$r['changedispatchprice'] = '';
						$r['price'] = '';
						$r['order_diyformdata'] = '';
					}
					$r['goods_title'] = $g['title'];
					$r['goods_goodssn'] = $g['goodssn'];
					$r['goods_optiontitle'] = $g['optiontitle'];
					$r['goods_total'] = $g['total'];
					$r['goods_price1'] = $g['price'] / $g['total'];
					$r['goods_price2'] = $g['realprice'] / $g['total'];
					$r['goods_rprice1'] = $g['price'];
					$r['goods_rprice2'] = $g['realprice'];
					$r['goods_costprice'] = (($g['costprice'] == 0 ? '' : $g['costprice']));
					$r['goods_diyformdata'] = $g['goods_diyformdata'];
					foreach ($diy_title_data as $key => $value ) 
					{
						$field = 'goods_' . $key;
						$diy_value = $g[$field];
						if ((15 < strlen($diy_value)) && is_numeric($diy_value)) 
						{
							$diy_value = '`' . $diy_value;
						}
						$r[$field] = $diy_value;
					}
					$exportlist[] = $r;
				}
			}
			unset($r);
			m('excel')->export($exportlist, array('title' => '订单数据', 'columns' => $columns));
		}
		if (($condition != ' o.uniacid = :uniacid and o.ismr=0 and o.deleted=0 and o.isparent=0') || !(empty($sqlcondition))) 
		{
			if ($searchfield == 'member') 
			{
				$openidArr = pdo_fetchall('SELECT openid FROM ' . tablename('ewei_shop_member') . ' WHERE uniacid = ' . $_W['uniacid'] . $memberCondition);
				if (!(empty($openidArr))) 
				{
					foreach ($openidArr as $openid ) 
					{
						$openids[] = $openid['openid'];
					}
					$inOpenid = '\'' . implode('\',\'', $openids) . '\'';
					$orderPrice = pdo_fetch('SELECT count(1) as count,sum(price) as sumprice FROM ' . tablename('ewei_shop_order') . ' o WHERE o.uniacid = ' . $_W['uniacid'] . ' AND o.deleted=0 AND o.isparent=0 AND o.openid IN (' . $inOpenid . ')' . $timeCondition);
				}
				else 
				{
					$orderPrice['sumprice'] = 0;
				}
				$totalmoney = $orderPrice['sumprice'];
				$total = $orderPrice['count'];
			}
			else if ($searchfield == 'address') 
			{
				$orderPrice = pdo_fetch('SELECT count(1) as count,sum(o.price) as sumprice FROM ' . tablename('ewei_shop_order') . ' o left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id WHERE o.uniacid = ' . $_W['uniacid'] . '  AND o.deleted=0 AND o.isparent=0 ' . $priceCondition . $statuscondition);
				$totalmoney = $orderPrice['sumprice'];
				$total = $orderPrice['count'];
				if ($orderPrice['count'] == 0) 
				{
					$totalmoney = 0;
				}
			}
			else if ($searchfield == 'location') 
			{
				$orderPrice = pdo_fetch('SELECT count(1) as count,sum(o.price) as sumprice FROM ' . tablename('ewei_shop_order') . ' o left join ' . tablename('ewei_shop_member_address') . ' a on o.addressid = a.id WHERE o.uniacid = ' . $_W['uniacid'] . ' AND o.deleted=0 AND o.isparent=0 ' . $priceCondition . $statuscondition);
				$totalmoney = $orderPrice['sumprice'];
				$total = $orderPrice['count'];
				if ($orderPrice['count'] == 0) 
				{
					$totalmoney = 0;
				}
			}
			else 
			{
				$t = pdo_fetch('SELECT COUNT(DISTINCT(o.id)) as count, ifnull(sum(o.price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' o ' . ' left join ' . tablename('ewei_shop_order_refund') . ' r on r.id =o.refundid ' . ' left join ' . tablename('ewei_shop_saler') . ' s on s.openid = o.verifyopenid and s.uniacid=o.uniacid' . ' left join ' . tablename('ewei_shop_member') . ' sm on sm.openid = s.openid and sm.uniacid=s.uniacid' . ' ' . $sqlcondition . ' WHERE ' . $condition . ' ' . $statuscondition, $paras);
				$total = $t['count'];
				$totalmoney = $t['sumprice'];
			}
		}
		else 
		{
			$t = pdo_fetch('SELECT COUNT(*) as count, ifnull(sum(price),0) as sumprice   FROM ' . tablename('ewei_shop_order') . ' WHERE uniacid = :uniacid and ismr=0 and deleted=0 and isparent=0 ' . $status_condition, $paras);
			$total = $t['count'];
			$totalmoney = $t['sumprice'];
		}
		$pager = pagination2($total, $pindex, $psize);
		$stores = pdo_fetchall('select id,storename from ' . tablename('ewei_shop_store') . ' where uniacid=:uniacid ', array(':uniacid' => $uniacid));
		$r_type = array('退款', '退货退款', '换货');
		load()->func('tpl');
		$member_list = pdo_getall('ewei_shop_member');
		include $this->template('order/list');
	}
	public function main() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData('', 'main');
	}
	public function status0() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(0, 'status0');
	}
	public function status1() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(1, 'status1');
	}
	public function status2() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(2, 'status2');
	}
	public function status3() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(3, 'status3');
	}
	public function status4() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(4, 'status4');
	}
	public function status5() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(5, 'status5');
	}
	public function status_1() 
	{
		global $_W;
		global $_GPC;
		$orderData = $this->orderData(-1, 'status_1');
	}
	public function ajaxgettotals() 
	{
		global $_GPC;
		$merch = intval($_GPC['merch']);
		$totals = m('order')->getTotals($merch);
		$result = ((empty($totals) ? array() : $totals));
		show_json(1, $result);
	}
	public function updateChildOrderPay() 
	{
		global $_W;
		$params = array();
		$params[':uniacid'] = $_W['uniacid'];
		$sql = 'select id,parentid from ' . tablename('ewei_shop_order') . ' where parentid>0 and status>0 and paytype=0 and uniacid=:uniacid';
		$list = pdo_fetchall($sql, $params);
		if (!(empty($list))) 
		{
			foreach ($list as $k => $v ) 
			{
				$params[':orderid'] = $v['parentid'];
				$sql1 = 'select paytype from ' . tablename('ewei_shop_order') . ' where id=:orderid and status>0 and paytype>0 and uniacid=:uniacid';
				$item = pdo_fetch($sql1, $params);
				if (0 < $item['paytype']) 
				{
					pdo_update('ewei_shop_order', array('paytype' => $item['paytype']), array('id' => $v['id']));
				}
			}
		}
	}
}

?>