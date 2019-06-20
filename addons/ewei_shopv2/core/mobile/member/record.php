<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Record_EweiShopV2Page extends MobileLoginPage
{
    public function main()
    {
        global $_W;
        $list1 = pdo_getall('share_record', array('fid' => $_W['ewei_shopv2_member']['fid']));
        foreach ($list1 as $key => $value) {
            $list1[$key]['member_info'] = pdo_get('ewei_shop_member',array('id'=>$value['uid']),array('realname','nickname'));
        }
        $list2 = pdo_getall('participation_record');


        include $this->template();
    }

    public function share()
    {
        global $_W;

        $list = pdo_getall('share_record', array('fid' => $_W['ewei_shopv2_member']['fid']));
        foreach ($list as $key => $value) {
            $list[$key]['member_info'] = pdo_get('ewei_shop_member',array('id'=>$value['uid']),array('realname','nickname'));
        }

        include $this->template();
    }

    public function shareholderrecord()
    {
        $list = pdo_getall('participation_record');

        include $this->template();
    }

    public function withdraw()
    {
        global $_W;
        $list = pdo_getall('ewei_shop_withdraw',array('uid'=>$_W['ewei_shopv2_member']['id']));

        include $this->template();
    }
}