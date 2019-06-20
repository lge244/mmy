<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_header', TEMPLATE_INCLUDEPATH)) : (include template('_header', TEMPLATE_INCLUDEPATH));?>
<script src="../addons/ewei_shopv2/static/js/dist/ueditor/ueditor.config.js" type="text/javascript"></script>
<script src="../addons/ewei_shopv2/static/js/dist/ueditor/ueditor.all.js" type="text/javascript"></script>
<div class="form-group">
    <label class="col-sm-1 control-label">代理描述：</label>
    <div class="input-group col-sm-7">
        <script id="editor" name="content" style="height:500px;" type="text/plain" >
            <?php  if(empty($info.content)) { ?><?php  } else { ?><?php  echo htmlspecialchars_decode($info['content'])?><?php  } ?>
        </script>
    </div>
</div>
<div class="form-group">
    <label class="col-lg control-label"></label>
    <div class="col-sm-9 col-xs-12">
        <input type="submit" id="btn" value="保存" class="btn btn-primary submit"/>
    </div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('_footer', TEMPLATE_INCLUDEPATH)) : (include template('_footer', TEMPLATE_INCLUDEPATH));?>
<script>
    var ue = UE.getEditor('editor');
        ue.ready(function() {
    });



    $('.submit').click(function(){
        $.post("<?php  echo webUrl('member/levelDetails/add')?>",{
            "content":ue.getContent(),
            "ids":1,
        },function (res) {
            if(res.code == 0){
                tip.msgbox.suc(res.msg)
                window.location.reload();
            }else{
                tip.msgbox.err(res.msg)
            }
        },'json')

    });
</script>
