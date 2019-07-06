<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<link rel="stylesheet" type="text/css"
      href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon.css?v=2.0.0">
<link rel="stylesheet" type="text/css"
      href="../addons/ewei_shopv2/template/mobile/default/static/css/coupon-new.css?v=2017030302">
<link rel="stylesheet" href="../addons/ewei_shopv2/static/js/dist/swiper/swiper.min.css">
<link rel="stylesheet" href="../addons/ewei_shopv2/template/mobile/default/static/css/style.css"/>
<link rel="stylesheet" type="text/css" href="../addons/ewei_shopv2/plugin/live/static/css/living.css?v=20170628"/>

<body ontouchstart="">

<div class="fui-page-group ">
    <div class="fui-page  fui-page-current" id="fui-page-1554275708948">
        <div class="fui-header">
            <div class="fui-header-left">
                <a class="back" onclick="location.back()"></a>
            </div>
            <div class="title">推广中心</div>
            <div class="fui-header-right"></div>
        </div>
        <div class='fui-content member-page navbar'>
            <div style="overflow: hidden;height: 7.5rem;position: relative;background: #fff">
                <div class="headinfo" style="z-index:100;border: none;">
                    <a class="setbtn" href="<?php  echo mobileUrl('member/info')?>" data-nocache='true'><i class="icon icon-shezhi"></i></a>
                    <div class="child">
                        <div class="title">我的上级</div>
                        <div class="num"><?php  echo $fmember['nickname'];?></div>
                    </div>
                    <div class="child userinfo">
                        <a href="<?php  echo mobileUrl('member/info')?>" data-nocache="true" style="color: white;">
                            <div class="face"><img src="<?php  echo $member['avatar'];?>" onerror="this.src='../addons/ewei_shopv2/static/images/noface.png'"/></div>
                            <div class="name"><?php  echo $member['nickname'];?></div>
                        </a>
                        <div class="level" <?php  if(!empty($_W['shopset']['shop']['levelurl'])) { ?>onclick='location.href="<?php  echo $_W['shopset']['shop']['levelurl'];?>"'<?php  } ?>>
                        <?php  if(empty($level['id'])) { ?>
                        [<?php  if(empty($_W['shopset']['shop']['levelname'])) { ?>普通会员<?php  } else { ?><?php  echo $_W['shopset']['shop']['levelname'];?><?php  } ?>]
                        <?php  } else { ?>
                        [<?php  echo $level['levelname'];?>]
                        <?php  } ?>
                        <?php  if(!empty($_W['shopset']['shop']['levelurl'])) { ?><i class='icon icon-question1' style='font-size:0.65rem'></i><?php  } ?>
                    </div>
                </div>
                <div class="child">
                   <a href="<?php  echo mobileUrl('member/team',array('id'=>$member['id']))?>">
                        <div class="title">我的团队</div>
<!--                        <div class="num"><?php  echo number_format($member['invite'],0)?>人</div>-->
                    </a>
                </div>
            </div>
            <div class="member_header"></div>
        </div>
        <div style="margin-top:70px;color: #000;">
            <p style="font-size: 1rem; margin-left: 30px;">如何推广 ？</p>
            <ul style=" margin-left: 50px; list-style-type:none; margin-top: 10px;">
                <li>
                    <div  style="margin-left: 20px;margin-top: 10px;display: inline-block" >
                        <?php  if($member['level'] == 0) { ?>
                        <img id="share_img" src="../addons/ewei_shopv2/template/mobile/default/download/img/down-bg.jpg" width='130' alt='链接二维码'>
                        <?php  } else { ?>
                        <img id="share_img" src="<?php  echo m('qrcode')->createQrcode($url)?>" width='130' alt='链接二维码'>
                        <?php  } ?>
                    </div>
                    <button style=" border: 0px; background: #ff0011; color: white; padding: 7px 20px;" onclick="save()">点击保存</button>
                </li>
            </ul>
        </div>
    </div>
</div>
</body>
<script>
    function copyUrl() {
        var Url = document.getElementById("share_url");
        Url.select(); // 选择对象
        document.execCommand("Copy"); // 执行浏览器复制命令
        alert("复制成功！");
    }
    function save() {
        var img = document.getElementById("share_img");
        var alink = document.createElement("a");
        alink.href = img.src;
        alink.click();
    }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
