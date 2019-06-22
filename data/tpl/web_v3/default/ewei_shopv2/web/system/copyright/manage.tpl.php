<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<div class="page-header">
    当前位置：<span class="text-primary">管理端底部版权</span>
</div>

   <div class="page-content">
       <form id="dataform" action="" method="post" class="form-horizontal form-validate">

           <div class="form-group">
               <label class="col-lg control-label">选择公众号</label>
               <div class="col-sm-9">
                   <select id='wechatid' name='wechatid' class='form-control select2' onchange="location.href= '<?php  echo webUrl('system/copyright/manage')?>&wechatid=' + $(this).val()" >
                       <option value=''></option>
                       <?php  if(is_array($wechats)) { foreach($wechats as $we) { ?>
                       <option value='<?php  echo $we['uniacid'];?>' <?php  if($_GPC['wechatid']==$we['uniacid']) { ?>selected<?php  } ?>><?php  echo $we['name'] ?></option>
                       <?php  } } ?>
                       <option value='-1' <?php  if($_GPC['wechatid']==-1 || empty($_GPC['wechatid'])) { ?>selected<?php  } ?>>全部公众号</option>
                   </select>
               </div>
           </div>
           <div class="form-group">
               <label class="col-lg control-label">LOGO</label>
               <div class="col-sm-9">
                   <?php  echo tpl_form_field_image2('logo',$copyrights['logo'])?>
               </div>
           </div>
           <div class="form-group">
               <label class="col-lg control-label">页面标题</label>
               <div class="col-sm-9">
                   <input type="text" class="form-control" name="title" value="<?php  echo $copyrights['title'];?>" />
               </div>
           </div>

           <div class="form-group">
               <label class="col-lg control-label">底部版权</label>
               <div class="col-sm-9">
                   <?php  echo tpl_ueditor('copyright',$copyrights['copyright'])?>
               </div>
           </div>

           <div class="form-group">
               <label class="col-lg control-label"></label>
               <div class="col-sm-9">
                   <input id="btn_submit" type="submit" value="保存" class="btn btn-primary"/>

               </div>
           </div>



       </form>
   </div>

 

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>

<!--OTEzNzAyMDIzNTAzMjQyOTE0-->