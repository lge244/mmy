<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Gudong_EweiShopV2Page extends MobilePage
{
    public function main(){
        $info = pdo_get('content',array('id'=>2),array('content'));

        include $this->template();
    }

    public function add(){
        global  $_GPC;
        global $_W;
        $ratio = pdo_get('shop_shareholder_rule');
        $data['ratio'] = $ratio['pshareholder_ratio'];
        $data['nickname'] = $_W['ewei_shopv2_member']['realname'];
        $data['time'] = time();
        $data['mobile'] = $_W['ewei_shopv2_member']['mobile'];
        $res = pdo_insert("gudong_apply",$data);
        if($res){
            return json_encode(['code'=>1,'msg'=>"申请成功,请等待后台审核"]);
        }else{
            return json_encode(['code'=>0,'msg'=>"申请失败"]);
        }
    }

}