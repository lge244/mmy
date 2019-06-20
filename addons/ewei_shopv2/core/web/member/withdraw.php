<?php
if (!(defined('IN_IA'))) {
    exit('Access Denied');
}

class Withdraw_EweiShopV2Page extends WebPage
{
    public function main()
    {


        global $_W;
        global $_GPC;
        $withdraw_list = pdo_getall('ewei_shop_withdraw');
        foreach ($withdraw_list as $k => $v) {
            $withdraw_list[$k] += pdo_get('ewei_shop_member', array('id' => $v['uid']), array('nickname'));
        }

        include $this->template();
    }

    public function reject()
    {
        global $_W;
        global $_GPC;
        $status = 2;
        $res = pdo_update('ewei_shop_withdraw',array('status'=>$status),array('id'=>$_GPC['id']));
        $withdraw = pdo_get('ewei_shop_withdraw',array('id'=>$_GPC['id']));
        if ($res){
            pdo_update('ewei_shop_member',array('brokerage'=>$withdraw['money']),array('id'=>$withdraw['uid']));
            exit(json_encode(array('code'=>0,'msg'=>'驳回成功')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'驳回失败，网络错误')));
    }
    public function confirm()
    {
        global $_W;
        global $_GPC;
        $status = 1;
        $res = pdo_update('ewei_shop_withdraw',array('status'=>$status),array('id'=>$_GPC['id']));
        if ($res){
            exit(json_encode(array('code'=>0,'msg'=>'发款成功')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'发款失败 ，网络错误')));

    }

}
