<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Agency_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_W;
        $member = m('member')->getMember($_W['openid'], true);
        if(!$member['relaname'] || !$member['province'] || !$member['city']){
	        echo "<script>alert('请填写详细信息！');window.location.href='/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=member.info';</script>";
	        return false;
        }
        if($member['level'] != 6){
            $info = pdo_get('content', array('id' => 1), array('content'));
            if($member['level'] == 5){
                $ids = pdo_get("shop_agency_rule", array(), array('agency_goodsid'));
                $gids = json_decode($ids['agency_goodsid'],true);
                for($i = 0;$i < count($gids);$i ++){
                    $goods[] = pdo_get("ewei_shop_goods",array('id'=>$gids[$i]),array('id','title','thumb','marketprice'));
                }
            }else{
                $ids = pdo_get("ewei_shop_member_level", array('uniacid' => 2,'level'=>1), array('goodsid'));
                $gids = json_decode($ids['goodsid'],true);
                for($i = 0;$i < count($gids);$i ++){
                    $goods[] = pdo_get("ewei_shop_goods",array('id'=>$gids[$i]),array('id','title','thumb','marketprice'));
                }
            }
            include $this->template();
        }else{
            echo "<script>alert('你已经成为股东！');history.go(-1);</script>";
        }


    }

}