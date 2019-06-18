<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Index_EweiShopV2Page extends WebPage
{
    public function main()
    {
        global $_W;
        if ($_W['user']['jobid'] == 2) {
            $list = pdo_getall('service_rebate_record', array('uid' => $_W['user']['uid']));
            foreach ($list as $k => $v) {
                $member = pdo_get('ewei_shop_member',array('id'=>$v['mid']),array('realname','mobile','nickname'));
                $list[$k]['mid'] = $member;
            }
        } else {
            $list = pdo_getall('service_rebate_record');
            foreach ($list as $k => $v) {
                $member = pdo_get('ewei_shop_member',array('id'=>$v['mid']),array('realname','mobile','nickname'));
                $list[$k]['mid'] = $member;
            }
        }

        include $this->template();
    }
}