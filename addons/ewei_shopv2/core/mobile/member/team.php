<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Team_EweiShopV2Page extends MobilePage
{
    public function main()
    {
        global $_GPC;
        $info = pdo_getall("ewei_shop_member",array('fid'=>$_GPC['id']));
        include $this->template();
    }
}