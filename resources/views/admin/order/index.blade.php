@extends('admin.layouts.app')
@section('title', '订单列表')

@section('content')
<script language="javascript" type="text/javascript" src="http://<?php echo env('APP_DOMAIN'); ?>/js/My97DatePicker/WdatePicker.js"></script>

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
        <button class="btn btn-warning" onclick="show_search()">高级</button>
    </div>
    
    <div class="form-inline" style="display:inline;float:right;">
        <div class="form-group">
            <label for="min_addtime">导出列表:</label>
            <input size="15" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" class="form-control" id="min_addtime" name="min_addtime" placeholder="开始时间">
        </div>
        <div class="form-group">
            <input size="15" onclick="WdatePicker({el:this,dateFmt:'yyyy-MM-dd HH:mm:ss'})" type="text" class="form-control" id="max_addtime" name="max_addtime" placeholder="结束时间">
        </div>
        <button onclick="javascript:output();" class="btn btn-success">导出</button>
    </div>
    <div style="clear:both;"></div>
</div>

<div class="table-responsive"><table class="table table-striped table-hover">
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