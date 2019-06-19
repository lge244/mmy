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

}