@extends('admin.layouts.app')
@section('title', '订单列表')

@section('content')
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/My97DatePicker/WdatePicker.js"></script>
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/layer/layer.js"></script>

<form name="listarc" action="" method="get">
<div class="bg-info" style="margin:10px 0;padding:10px;">
    <div class="form-inline" style="display:inline;float:left;">
        <div class="form-group">
            <label for="order_sn">订单号:</label>
            <input size="15" type="text" class="form-control" id="order_sn" name="order_sn" placeholder="">
        </div>
        <div class="form-group">
            <label for="name">收货人:</label>
            <input size="5" type="text" class="form-control" id="name" name="name" placeholder="">
        </div>
        <button type="submit" class="btn btn-success">查询</button>
        <button type="button" onclick="output_excel()" class="btn btn-warning">导出EXCEL</button>
    </div>
<script>
function output_excel()
{
    layer.open({
        title: '导出EXCEL',
        area: ['400px', '360px'],
        shadeClose: true, //开启遮罩关闭
        content: '<form id="output-excel" action="<?php echo route('admin_order_output_excel'); ?>" method="get"><div class="form-inline"><div class="form-group"><label for="min_addtime">时　间：</label><input size="18" onclick="WdatePicker({el:this,dateFmt:\'yyyy-MM-dd HH:mm:ss\'})" type="text" class="form-control" id="min_addtime" name="min_addtime" placeholder="开始时间"></div> - <div class="form-group"><input size="18" onclick="WdatePicker({el:this,dateFmt:\'yyyy-MM-dd HH:mm:ss\'})" type="text" class="form-control" id="max_addtime" name="max_addtime" placeholder="结束时间"></div></div><div class="form-inline mt10"><div class="form-group"><label for="num">数　量：</label><input size="4" type="text" class="form-control" id="num" name="num" value="100" placeholder=""></div></div><div class="form-inline mt10"><div class="form-group"><label for="status">订单状态：</label><select id="status" class="form-control" name="status"><option value ="0">全部</option><option value ="1">待付款</option><option value="2">待发货</option><option value="3">待收货</option><option value="4">交易成功</option><option value="5">退款中</option></select></div></div><div class="form-inline mt10"><div class="form-group"><label for="name">收货人：</label><input size="8" type="text" class="form-control" id="name" name="name" placeholder=""></div></div><div class="form-inline mt10"><div class="form-group"><label for="order_sn">订单号：</label><input size="20" type="text" class="form-control" id="order_sn" name="order_sn" placeholder=""></div></div></form>'
        ,btn: ['导出', '取消']
        ,yes: function(index, layero){
            
            
            $('#output-excel').submit();
            layer.close(index);
        }
        ,btn2: function(index, layero){
            
        }
        ,cancel: function(){
            //右上角关闭回调
        }
    });
}
</script>
    <div style="clear:both;"></div>
</div>

<div class="table-responsive"><table class="table table-hover">
<thead><tr>
<th>订单编号SN-ID</th>
<th>支付信息</th>
<th>收货人</th>
<th>订单状态</th>
<th>来源</th>
<th>管理</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?>
<tr>
    <td><a href="<?php echo route('admin_order_detail',array('id'=>$row->id)); ?>"><?php echo $row->order_sn.'-'.$row->id; ?></a>, 金额：<?php echo $row->order_amount; ?><br>下单时间：<?php echo date('Y-m-d H:i:s',$row->add_time); ?></td>
    <td><?php if($row->pay_money){echo '支付金额：'.$row->pay_money;} ?><?php if($row->out_trade_no){echo ', 流水号：'.$row->out_trade_no;} ?><?php if($row->pay_name){echo '<br><font color="green">'.$row->pay_name.'</font>, ';} ?><?php if($row->pay_time){echo '支付时间：'.date('Y-m-d H:i:s',$row->pay_time);} ?></td>
    <td><?php echo $row->name.'[TEL:'.$row->mobile.']'; ?><br><?php echo $row->province_name; ?><?php echo $row->city_name; ?><?php echo $row->district_name; ?></td>
    <td><?php if($row->order_status_text=='待发货'){echo '<font color="red">'.$row->order_status_text.'</font>';}else{echo $row->order_status_text;} ?></td>
    <td><?php if($row->place_type==1){echo 'pc';}elseif($row->place_type==2){echo 'weixin';}elseif($row->place_type==3){echo 'app';}elseif($row->place_type==4){echo 'wap';} ?></td>
    <td><a href="<?php echo route('admin_order_detail',array('id'=>$row->id)); ?>">详情</a></td>
</tr>
<?php }} ?>
</tbody>
</table></div><!-- 表格结束 --></form><!-- 表单结束 -->
@endsection