<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class List_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_GPC;
        $oid = pdo_get('ewei_shop_member',array('id'=>$_GPC['id']),array('openid'));
        $info = pdo_getall("ewei_shop_order",array('openid'=>$oid['openid']));
        $purchase_tax = pdo_get("ewei_shop_purchase_tax");
        foreach ($info as $ki=>$vi){
            $info[$ki]['tax'] = $vi['goodsprice'] * $purchase_tax['purchase_tax'] * 0.01;
        }

        include $this->template();
    }
}