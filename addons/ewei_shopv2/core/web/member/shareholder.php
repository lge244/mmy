<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Shareholder_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $member = pdo_getall('ewei_shop_member', array('level' => 6));

        include $this->template();
    }

    public function add()
    {
        $member = pdo_getall('ewei_shop_member', array('mobile !=' => ''), array('id', 'openid', 'nickname'));
        include $this->template();
    }

    public function post()
    {
        global $_GPC;

        $a = pdo_update('ewei_shop_member', array('shareholder' => $_GPC['status'],'shareholder_time'=>time()), array('openid' => $_GPC['uid']));

        if ($a) {
            exit(json_encode(array('code' => 0, 'msg' => '恭喜成为股东！')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '当前网络出错！请稍后重试！')));
    }
}