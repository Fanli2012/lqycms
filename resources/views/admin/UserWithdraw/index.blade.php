@extends('admin.layouts.app')
@section('title', '提现申请列表')

@section('content')
<h2 class="sub-header">提现申请列表</h2>

<form name="listarc"><div class="table-responsive"><table class="table table-hover">
<thead><tr class="info">
<th>ID</th>
<th>用户名</th>
<th>提现金额</th>
<th>姓名</th>
<th>收款方式</th>
<th>收款账号</th>
<th>申请时间</th>
<th>状态</th>
<th>操作</th>
</tr></thead>
<tbody>
<?php if($posts){foreach($posts as $row){ ?><tr>
<td><?php echo $row->id; ?></td>
<td><?php echo $row->user->user_name; ?><br><?php if($row->user->mobile){echo 'TEL:'.$row->user->mobile;} ?></td>
<td><font color="red"><?php echo $row->money; ?></font></td>
<td><?php echo $row->name; ?></td>
<td><?php echo $row->method; ?></td>
<td>账号：<?php echo $row->account;if($row->bank_name){echo '<br>银行名称：'.$row->bank_name;}if($row->bank_place){echo '<br>开户行：'.$row->bank_place;} ?></td>
<td><?php echo date('Y-m-d H:i:s',$row->add_time); ?></td>
<td><?php echo $row->status_text; ?></td>
<td><?php if($row->status==0){ ?><a href="javascript:change_status(<?php echo $row->id; ?>,'1');">成功</a>&nbsp;<a href="javascript:change_status(<?php echo $row->id; ?>,'0');">拒绝</a><?php } ?></td>
</tr><?php }} ?>
</tbody></table></div><!-- 表格结束 --></form><!-- 表单结束 -->

<nav aria-label="Page navigation">{{ $posts->links() }}</nav>

<script type="text/javascript" src="<?php echo env('APP_URL'); ?>/js/layer/layer.js"></script>
<script>
function change_status(id,type)
{
    //询问框
    layer.confirm('您确定要执行此操作吗？', {
        btn: ['确定','取消'] //按钮
    }, function(){
        var url = window.location.href;
        $.post('<?php echo route('admin_userwithdraw_change_status'); ?>',{id:id,type:type},function(res){
            if(res.code==0)
            {
                location.href = url;
            }
            else
            {
                
            }
            
            //提示层
            layer.msg(res.msg,{
                time: 20000, //2s后自动关闭
            });
        });
    }, function(){
        
    });
}
</script>
@endsection