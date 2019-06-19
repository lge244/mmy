<?php
if (!defined('IN_IA')) {
    exit('Access Denied');
}

class LevelDetails_EweiShopV2Page extends WebPage
{
    public function main(){
        $info = pdo_get("content",array('id'=>1),array('content'));
        dump(htmlspecialchars_decode($info['content']));
        include $this->template();
    }

    public function add(){
        global $_GPC;
        $content = $_GPC['content'];
        if($_GPC['ids'] == 1){
            $title = "代理入口详情";
        }else{
            $title = "股东描述";
        }
        $ct = pdo_get('content',array('id'=>$_GPC['ids']),array('content'));

        if(empty($ct)){
            $res = pdo_insert('content',array('content'=> $content,'title'=>$title,'addtime'=>time()));
        }else{
            $res = pdo_update("content",array('content'=>$content,'title'=>$title,'addtime'=>time()),array('id'=>$_GPC['ids']));
        }

        if ($res){
            exit(json_encode(array('code'=>0,'msg'=>'保存成功!')));
        }
        exit(json_encode(array('code'=>1,'msg'=>'网络错误! 请稍后重试!')));
    }
}