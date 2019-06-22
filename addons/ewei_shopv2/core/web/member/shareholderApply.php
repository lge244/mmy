<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class shareholderApply_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $member = pdo_getall('gudong_apply');
        include $this->template();
    }

    public function pass(){
        global $_GPC;
        $uid = pdo_get('gudong_apply',array('id'=>$_GPC['id']),array('uid'));
        $res = pdo_update("ewei_shop_member",array('level'=>6,'shareholder_time'=>time()),array('id'=>$uid['uid']));
        if($res){
            pdo_delete("gudong_apply",array('id'=>$_GPC['id']));
            exit(json_encode(['code'=>1,'msg'=>"审核成功"]));
        }else{
            exit(json_encode(['code'=>0,'msg'=>"审核失败"]));
        }
    }
}