<?php  if( !defined("IN_IA") )
{
    exit( "Access Denied" );
}
class Succ_EweiShopV2Page extends MobileLoginPage
{
    public function main(){
        global $_GPC;
        global $_W;
        $orderid = $_GPC['orderid'];
        $member = m('member')->getMember($_W['openid'], true);
        $g = pdo_getall("ewei_shop_member_level",array(),array('goodsid'));
        foreach ($g as $k=>$v){
	        $gid = json_decode($v['goodsid'],true);
	        $gs = pdo_get("ewei_shop_order_goods",array('orderid'=>$orderid),array('goodsid'));
	        if(is_array($gid)){
		        if(in_array($gs['goodsid'],$gid)){
			        if ($member['fid'] != 0) {
				        $commission = m("order")->shareCommission($orderid, $member['id']);
				        $info1 = pdo_get("ewei_shop_member", array('id' => $member['fid']), array('brokerage', 'past_brokerage', 'share_money'));
				        //修改上级的分润佣金
				        pdo_update("ewei_shop_member", array('brokerage' => $info1['brokerage'] + $commission['share2commission'], 'past_brokerage' => $info1['past_brokerage'] + $commission['share2commission'], 'share_money' => $info1['share_money'] + $commission['share2commission']), array('id' => $member['fid']));
				        pdo_insert("share_record", array('uid' => $member['id'], 'fid' => $member['fid'], 'money' => $commission['share2commission'], 'type' => 0, 'time' => time()));
				        //
				        $f = pdo_get("ewei_shop_member", array('id' => $member['fid']), array('fid'));
				        $info2 = pdo_get("ewei_shop_member", array('id' => $f['fid']), array('brokerage', 'past_brokerage', 'share_money'));

				        if ($f['fid'] != 0) {
					        pdo_update("ewei_shop_member", array('brokerage' => $info2['brokerage'] + $commission['share3commission'], 'past_brokerage' => $info2['past_brokerage'] + $commission['share3commission'], 'share_money' => $info2['share_money'] + $commission['share3commission']), array('id' => $f['fid']));
					        pdo_insert("share_record", array('uid' => $member['id'], 'fid' => $f['fid'], 'money' => $commission['share3commission'], 'type' => 0, 'time' => time()));
				        }
			        }
		        }
	        }else{
		        if($gid == $gs['goodsid']){
			        dump('g='.'-1');
			        if ($member['fid'] != 0) {
				        dump('g='.'-2');
				        $commission = m("order")->shareCommission($orderid, $member['id']);
				        $info1 = pdo_get("ewei_shop_member", array('id' => $member['fid']), array('brokerage', 'past_brokerage', 'share_money'));
				        //修改上级的分润佣金
				        pdo_update("ewei_shop_member", array('brokerage' => $info1['brokerage'] + $commission['share2commission'], 'past_brokerage' => $info1['past_brokerage'] + $commission['share2commission'], 'share_money' => $info1['share_money'] + $commission['share2commission']), array('id' => $member['fid']));

				        pdo_insert("share_record", array('uid' => $member['id'], 'fid' => $member['fid'], 'money' => $commission['share2commission'], 'type' => 0, 'time' => time()));

				        //
				        $f = pdo_get("ewei_shop_member", array('id' => $member['fid']), array('fid'));
				        $info2 = pdo_get("ewei_shop_member", array('id' => $f['fid']), array('brokerage', 'past_brokerage', 'share_money'));

				        if ($f['fid'] != 0) {
					        pdo_update("ewei_shop_member", array('brokerage' => $info2['brokerage'] + $commission['share3commission'], 'past_brokerage' => $info2['past_brokerage'] + $commission['share3commission'], 'share_money' => $info2['share_money'] + $commission['share3commission']), array('id' => $f['fid']));
					        pdo_insert("share_record", array('uid' => $member['id'], 'fid' => $f['fid'], 'money' => $commission['share3commission'], 'type' => 0, 'time' => time()));
				        }
			        }
		        }
            }
        }
    }
}