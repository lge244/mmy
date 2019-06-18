<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Tallage_EweiShopV2Page extends WebPage
{
    public function main()
    {
              $purchase_tax = pdo_get('ewei_shop_purchase_tax');
        include $this->template();
    }

    public function post()
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
}