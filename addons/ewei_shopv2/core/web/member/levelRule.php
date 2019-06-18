<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class LevelRule_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $goods = pdo_getall('ewei_shop_goods', array('status' => 1, 'deleted' => 0), array('id', 'title'));
        $agency_rule = pdo_get('shop_agency_rule');
        include $this->template();
    }

    public function add()
    {
        global $_GPC;

        $res = pdo_update('shop_agency_rule',array('agency_purchase_time'=>$_GPC['agency_purchase_time'],'agency_goodsid'=>$_GPC['agency_goodsid'],'agency_ratio'=>$_GPC['agency_ratio']));

        if ($res){
            exit(json_encode(array('code'=>0,'msg'=>'规则保存成功!')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'网络错误! 请稍后重试!')));
    }
}