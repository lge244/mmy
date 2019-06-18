<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('mmanage/common', TEMPLATE_INCLUDEPATH)) : (include template('mmanage/common', TEMPLATE_INCLUDEPATH));?>

<div class='fui-page fui-page-current'>
    <div class="fui-header fui-header-success">
        <div class="fui-header-left">
            <a class="back"></a>
        </div>
        <div class="title">设置</div>
        <div class="fui-header-right"></div>
    </div>
    <div class='fui-content navbar'>

        <?php  if(!empty($member)) { ?>
            <div class="fui-title">商城用户</div>
            <div class="fui-list-group">
                <a class="fui-list external" href="<?php  echo mobileUrl('member')?>">
                    <div class="fui-list-media external">
                        <img src="<?php  echo $member['avatar'];?>" class="round">
                    </div>
                    <div class="fui-list-inner">
                        <div class="title"><?php  echo $member['nickname'];?></div>
                        <div class="subtitle">
                            <?php  if($member['bindrole']) { ?>
                                <span class="fui-label fui-label-success">已绑定</span>
                            <?php  } else { ?>
                                <span class="fui-label fui-label-default">未绑定</span>
                            <?php  } ?>
                        </div>
                    </div>
                    <div class="angle"></div>
                </a>
            </div>
        <?php  } ?>

        <div class="fui-title">操作员设置</div>
        <div class="fui-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label">登录账号</div>
                <div class="fui-cell-info"><?php  echo $roleuser['username'];?></div>
                <div class="fui-cell-remark noremark">不可修改</div>
            </div>
        </div>
        <div class="fui-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label">真实姓名</div>
                <div class="fui-cell-info">
                    <input type="text" placeholder="请输入真实姓名" class="fui-input" value="<?php  echo $roleuser['realname'];?>" id="realname" />
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">手机号</div>
                <div class="fui-cell-info">
                    <input type="tel" placeholder="请输入手机号" class="fui-input" value="<?php  echo $roleuser['mobile'];?>" maxlength="11" id="mobile" />
                </div>
            </div>
        </div>

        <div class="fui-cell-group">
            <div class="fui-cell">
                <div class="fui-cell-label">修改密码</div>
                <div class="fui-cell-info">
                    <input type="password" placeholder="请输入密码(不输入则不修改)" class="fui-input" id="password" />
                </div>
            </div>
            <div class="fui-cell">
                <div class="fui-cell-label">重复密码</div>
                <div class="fui-cell-info">
                    <input type="password" placeholder="请重复输入密码" class="fui-input" id="password2" />
                </div>
            </div>
        </div>

        <div class="btn btn-success block" id="btn-submit">保存设置</div>
        <div class="btn btn-danger block" id="btn-logout">退出登录</div>
    </div>
    <script language="javascript">
        require(['../addons/ewei_shopv2/plugin/mmanage/static/js/base.js'],function(modal){
            modal.initPerson();
        });
    </script>
</div>
<?php  $this->footerMenus(null, $texts)?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<!--4000097827-->