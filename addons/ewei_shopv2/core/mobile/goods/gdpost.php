<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class Gdpost_EweiShopV2Page extends MobilePage
{
    public function main(){

        include $this->template();
    }

}