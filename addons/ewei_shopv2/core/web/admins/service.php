<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Service_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $service_ratio = pdo_get('service');

        include $this->template();
    }

    public function post()
    {
        global $_GPC;

        $res = pdo_update('service', array('service_ratio' => $_GPC['service_ratio']));

        if ($res) {
            exit(json_encode(array('code' => 0, 'msg' => '规则保存成功!')));
        }
        exit(json_encode(array('code' => 1, 'msg' => '网络错误! 请稍后重试!')));
    }
}