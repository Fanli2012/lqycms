@extends('admin.layouts.app')
@section('title', '订单详情')

@section('content')
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/layer/layer.js"></script>

<div class="bg-info" style="margin:10px 0;padding:10px;">
    <div class="form-inline">
        <div class="form-group">
            当前可执行操作：
        </div>
        <?php if($post['order_status'] == 0 && $post['shipping_status'] == 0 && $post['pay_status'] == 1){ ?><button class="btn btn-info" onclick="fahuo_layer(<?php echo $post['id']; ?>)">发货</button><?php } ?>
        <?php if($post['order_status'] == 0 && $post['pay_status'] == 0){ ?><button class="btn btn-success" onclick="change_status(<?php echo $post['id']; ?>,2)">设为已付款</button><?php } ?>
        <?php if($post['order_status'] == 0 && $post['refund_status'] == 0 && $post['shipping_status'] == 1 && $post['pay_status'] == 1){ ?><button class="btn btn-primary" onclick="change_status(<?php echo $post['id']; ?>,4)">设为已收货</button><?php } ?>
        <?php if($post['order_status'] == 0 && $post['pay_status'] == 0){ ?><button class="btn btn-danger" onclick="change_status(<?php echo $post['id']; ?>,7)">设为无效</button><?php } ?>
        <?php if($post['order_status'] == 3 && $post['refund_status'] == 1){ ?><button class="btn btn-danger" onclick="change_status(<?php echo $post['id']; ?>,8)">设为已退货</button><?php } ?>
        <button class="btn btn-warning" onclick="javascript:history.back(-1);">返回</button>
    </div>
    <div style="clear:both;"></div>
</div>
<script>
function fahuo_layer(order_id)
{
    //自定页
    layer.open({
        title: '发货管理',
        shadeClose: true, //开启遮罩关闭
        content: '快递方式：<select name="shipping_id" id="shipping_id"><option value="0">无须物流</option><?php if($kuaidi){foreach($kuaidi as $k=>$v){ ?><option value="<?php echo $v->id ?>"><?php echo $v->name ?></option><?php }} ?></select><br>快递单号：<input size="30" type="text" name="shipping_sn" id="shipping_sn" placeholder="">'
        ,btn: ['确认', '取消']
        ,yes: function(index, layero){
            var shipping_id = $("#shipping_id").val();
            var shipping_sn = $("#shipping_sn").val();
            
            if(shipping_id!=0){if(shipping_sn==''){layer.msg('请填写快递单号');return false;}}
            
            $.post('<?php echo route('admin_order_change_shipping'); ?>',{id:order_id,shipping_id:shipping_id,shipping_sn:shipping_sn},function(res)
            {
                if(res.code==0)
                {
                    $.post('<?php echo route('admin_order_change_status'); ?>',{id:order_id,status:3},function(res)
                    {
                        if(res.code==0)
                        {
                            layer.msg('操作成功');
                            window.location.reload();
                        }
                        else
                        {
                            layer.msg('操作失败');
                            return false;
                        }
                    },'json');
                }
                else
                {
                    layer.msg('操作失败');
                    return false;
                }
            },'json');
            
            layer.close(index);
        }
        ,btn2: function(index, layero){
            
        }
        ,cancel: function(){
            //右上角关闭回调
        }
    });
}

function change_status(order_id,status)
{
    $.post('<?php echo route('admin_order_change_status'); ?>',{id:order_id,status:status},function(res)
    {
        if(res.code==0)
        {
            layer.msg('操作成功');
            window.location.reload();
        }
        else
        {
            layer.msg('操作失败');
            return false;
        }
    },'json');
}
</script>

<h3 class="sub-header">基本信息</h3>
<!-- 表格开始 -->
<div class="table-responsive"><table class="table table-hover table-bordered">
<thead><tr class="info">
<th>订单编号</th>
<th>订单状态</th>
<th>下单人</th>
<th>下单时间</th>
<th>支付方式</th>
<th>支付时间</th>
<th>配送方式</th>
<th>快递单号</th>
<th>发货时间</th>
</tr></thead>
<tbody>
<tr>
    <td><?php echo $post['order_sn']; ?></td>
    <td><font color="red"><?php echo $post['order_status_text']; ?></font></td>
    <td><?php if($post['user']['mobile']){echo $post['user']['mobile'];}else{echo $post['user']['user_name'];} ?></td>
    <td><?php echo date('Y-m-d H:i:s',$post['add_time']); ?></td>
    <td><?php echo $post['pay_name']; ?></td>
    <td><?php if($post['pay_time']){echo date('Y-m-d H:i:s',$post['pay_time']);} ?></td>
    <td><?php echo $post['shipping_name']; ?></td>
    <td><?php echo $post['shipping_sn']; ?></td>
    <td><?php if($post['shipping_time']){echo date('Y-m-d H:i:s',$post['shipping_time']);} ?></td>
</tr>
<tr>
    <td colspan="1">订单来源：<?php echo $post['place_type_text']; ?></td>
	<td colspan="8">客户留言：<?php echo $post['message']; ?></td>
</tr>
</tbody>
</table></div><!-- 表格结束 -->

<h3 class="sub-header">收货人信息</h3>
<!-- 表格开始 -->
<div class="table-responsive"><table class="table table-hover table-bordered">
<thead><tr class="info">
<th>收货人姓名</th>
<th>电话</th>
<th>详细地址</th>
</tr></thead>
<tbody>
<tr>
    <td><?php echo $post['name']; ?></td>
    <td><?php echo $post['mobile']; ?></td>
    <td><?php echo $post['province_name'].$post['city_name'].$post['district_name'].' '.$post['address']; ?></td>
</tr>
</tbody>
</table></div><!-- 表格结束 -->

<h3 class="sub-header">商品信息</h3>
<!-- 表格开始 -->
<div class="table-responsive"><table class="table table-striped table-hover table-bordered">
<thead><tr class="info">
<th>商品缩略图</th>
<th>商品名称</th>
<th>商品价格</th>
<th>数量</th>
<th>合计</th>
<th>退货/退款</th>
<th>退货退款理由</th>
</tr></thead>
<tbody>
<?php if($post['goodslist']){foreach($post['goodslist'] as $k=>$v){ ?>
<tr>
    <td width="98px"><img src="<?php echo $v['goods_img']; ?>" style="width:80px;height:60px;"></td>
    <td><?php echo $v['goods_name']; ?></td>
    <td><?php echo $v['goods_price']; ?></td>
    <td><?php echo $v['goods_number']; ?></td>
    <td><font color="red"><?php echo $v['goods_price']*$v['goods_number']; ?></font></td>
    <td><?php echo $v['refund_status_text']; ?></td>
    <td><?php echo $v['refund_reason']; ?></td>
</tr>
<?php }} ?>
</tbody>
</table></div><!-- 表格结束 -->

<?php if(empty($post['invoice']) || $post['invoice']!=0){ ?>
<h3 class="sub-header">发票信息</h3>
<!-- 表格开始 -->
<div class="table-responsive"><table class="table table-hover table-bordered">
<thead><tr class="info">
<th>发票类型</th>
<th>发票抬头</th>
<th>纳税人识别号</th>
</tr></thead>
<tbody>
<tr>
    <td><?php echo $post['invoice_text']; ?></td>
    <td><?php echo $post['invoice_title']; ?></td>
    <td><?php echo $post['invoice_taxpayer_number']; ?></td>
</tr>
</tbody>
</table></div><!-- 表格结束 -->
<?php } ?>

<h3 class="sub-header">费用结算</h3>
<!-- 表格开始 -->
<div class="table-responsive"><table class="table table-hover table-bordered">
<thead><tr class="info">
<th>商品总金额</th>
<th>邮费</th>
<th>优惠券</th>
<th>积分</th>
<th>其它费用</th>
<th>应付金额</th>
</tr></thead>
<tbody>
<tr>
    <td><?php echo $post['goods_amount']; ?></td>
    <td>+<?php echo $post['shipping_fee']; ?></td>
    <td>-<?php echo $post['bonus_money']; ?></td>
    <td>-<?php echo $post['integral_money']; ?></td>
    <td>-<?php echo $post['discount']; ?></td>
    <td><font color="red"><?php echo $post['order_amount']; ?></font></td>
</tr>
</tbody>
</table></div><!-- 表格结束 -->

@endsection