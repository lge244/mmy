<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Record_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $record = pdo_getall('shop_goods_record');
        foreach ($record as $k => $v) {
            $record[$k]['member'] = pdo_get('users',array('uid'=>$v['uid']),array('username','truename'));
        }
        include $this->template();
    }
}