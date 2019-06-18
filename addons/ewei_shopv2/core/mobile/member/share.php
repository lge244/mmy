<?php
if (!(defined('IN_IA')))
{
    exit('Access Denied');
}
class Share_EweiShopV2Page extends MobileLoginPage
{
    public function main()
    {
        global $_W;
        global $_GPC;
        $member = m('member')->getMember($_W['openid'], true);
        $level = m('member')->getLevel($_W['openid']);
        $fmember = pdo_fetch('select * from ' . tablename('ewei_shop_member') . ' where id=:id limit 1', array(':id' => $member['fid']));
        $url ="http://".$_SERVER['SERVER_NAME']."/app/index.php?i=2&c=entry&m=ewei_shopv2&do=mobile&r=account.register"."&uid=".$member['id'];

        include $this->template();
    }
}
?>