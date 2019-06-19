<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class shareholderDetails_EweiShopV2Page extends WebPage
{
    public function main()
    {
        $info = pdo_get("content",array('id'=>2),array('content'));

        include $this->template();
    }
}