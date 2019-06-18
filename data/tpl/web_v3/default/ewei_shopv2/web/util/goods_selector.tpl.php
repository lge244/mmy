<?php defined('IN_IA') or exit('Access Denied');?><table class="table" cellspacing="0" width="100%">
    <thead>
    <tr>
        <td>
            商品
        </td>
        <td>
            商品价格
        </td>
        <td>
            库存
        </td>
        <td>
            操作
        </td>
    </tr>
    </thead>
    <tbody class="ui-sortable container">
    <?php  if(empty($list)) { ?>
    <tr>
        <td colspan="4" style="text-align: center">
            查不到任何商品
        </td>
    </tr>
    <?php  } ?>
    <?php  if(is_array($list)) { foreach($list as $key => $goods) { ?>
        <tr>
            <td>
                <img src="<?php  echo tomedia($goods['thumb'])?>"
                     style="width:30px;height:30px;float:left;margin-right:12px">
                <?php  echo $goods['title'];?>
            </td>
            <td>
                ¥<?php  echo $goods['marketprice'];?>
            </td>
            <td>
                <?php  echo $goods['total'];?>
            </td>
            <td>
                <a href="javascript:void(0);" class="label label-primary selectit" data-id="<?php  echo $goods['id'];?>" data-json='<?php  echo json_encode($goods);?>'>
                    选择
                </a>
            </td>
        </tr>
    <?php  } } ?>
    </tbody>
</table>
<div style="text-align:right;width:100%;position: absolute;bottom: 0;right:30px;">
    <div>
        <ul class="pagination pagination-centered">
            <?php  if(is_array($page_num_arr)) { foreach($page_num_arr as $k => $num) { ?>
            <li <?php  if($num == $page) { ?>class="active"<?php  } ?>>
                <a href="javascript:;" page="<?php  echo $num;?>" class="pager-nav">
                    <?php  echo $num;?>
                </a>
            </li>
            <?php  } } ?>
            <li>
                <a href="javascript:;" page="<?php  echo $page+1?>" class="pager-nav">
                    下一页»
                </a>
            </li>
            <li>
                <a href="javascript:;" page="<?php  echo $total;?>" class="pager-nav" class="page-raduis">
                    尾页
                </a>
            </li>
            <li>
                <input type="text" class="page-raduis" value="1">
            </li>
            <li>
                <a href="javascript:;" page="1" class="pager-nav">
                    跳转
                </a>
            </li>
        </ul>
        <span class="record">共<?php  echo $count;?>条记录</span>
    </div>
</div>

