<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\CommonController;
use App\Http\Model\Order;
use App\Http\Model\OrderGoods;
use App\Http\Model\User;
use App\Http\Model\Region;
use DB;
use App\Common\ReturnData;
use Illuminate\Http\Request;

class OrderController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    public function index()
    {
        $res = '';
		$where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
                $query->where(function ($query2){$query2->where('order_sn', 'like', '%'.$_REQUEST['keyword'].'%')->orWhere("name", "like", '%'.$_REQUEST['keyword'].'%')->orWhere("mobile", "like", '%'.$_REQUEST['keyword'].'%');});
            }
            
            if(isset($_REQUEST["mobile"]))
			{
				$query->where('mobile', 'like', '%'.$_REQUEST['mobile'].'%');
			}
			
            if(isset($_REQUEST["order_sn"]))
			{
				$query->where('order_sn', 'like', '%'.$_REQUEST['order_sn'].'%');
			}
			
            if(isset($_REQUEST["name"]))
			{
				$query->where("name", "like", '%'.$_REQUEST['name'].'%');
			}
            
            //0或者不传表示全部，1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后
			if(isset($_REQUEST["status"]))
			{
                if($_REQUEST["status"] == 1)
                {
                    $query->where(array('order_status'=>0,'pay_status'=>0));
                }
                elseif($_REQUEST["status"] == 2)
                {
                    $query->where(array('order_status'=>0,'shipping_status'=>0,'pay_status'=>1));
                }
                elseif($_REQUEST["status"] == 3)
                {
                    $query->where(array('order_status'=>0,'refund_status'=>0,'shipping_status'=>1,'pay_status'=>1));
                }
                elseif($_REQUEST["status"] == 4)
                {
                    $query->where(array('order_status'=>3,'refund_status'=>0,'shipping_status'=>2,'is_comment'=>0));
                }
                elseif($_REQUEST["status"] == 5)
                {
                    $query->where(array('order_status'=>3,'refund_status'=>1));
                }
			}
			
			$query->where('is_delete', 0); //未删除
        };
		
        $posts = parent::pageList('order', $where);
		foreach($posts as $key=>$value)
        {
            $order_status_arr = model('Order')->getOrderStatusAttr($value);
            $posts[$key]->order_status_text = $order_status_arr?$order_status_arr['text']:'';
            $posts[$key]->order_status_num = $order_status_arr?$order_status_arr['num']:'';
            
            $posts[$key]->province_name = model('Region')->getRegionName(['id'=>$value->province]);
            $posts[$key]->city_name = model('Region')->getRegionName(['id'=>$value->city]);
            $posts[$key]->district_name = model('Region')->getRegionName(['id'=>$value->district]);
        }
		
        $data['posts'] = $posts;
        
        return view('admin.order.index', $data);
    }
    
    public function detail()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = Order::where('id', $id)->first();
		
        if($data['post'])
        {
            $order_status_arr = model('Order')->getOrderStatusAttr($data['post']);
            $data['post']['order_status_text'] = $order_status_arr?$order_status_arr['text']:'';
            $data['post']['order_status_num'] = $order_status_arr?$order_status_arr['num']:'';
            
            $data['post']['province_name'] = model('Region')->getRegionName(['id'=>$data['post']->province]);
            $data['post']['city_name'] = model('Region')->getRegionName(['id'=>$data['post']->city]);
            $data['post']['district_name'] = model('Region')->getRegionName(['id'=>$data['post']->district]);
            
            $data['post']['invoice_text'] = model('Order')->getInvoiceAttr($data['post']);
            $data['post']['place_type_text'] = model('Order')->getPlaceTypeAttr($data['post']);
            
            $data['post']['user'] = User::where(array('id'=>$data['post']['user_id']))->first(); //下单人信息
            
            $order_goods = OrderGoods::where(array('order_id'=>$data['post']['id']))->get(); //订单商品列表
            
            foreach($order_goods as $k=>$v)
            {
                $order_goods[$k]['refund_status_text'] = model('OrderGoods')->getRefundStatusAttr($v);
            }
            
            $data['post']['goodslist'] = $order_goods;
        }
        //echo '<pre>';print_r($data['post']);exit;
        $data['kuaidi'] = DB::table('kuaidi')->where(['status'=>0])->orderBy('listorder', 'asc')->get();
        
        return view('admin.order.detail', $data);
    }
    
    public function doadd()
    {
        $_POST['add_time'] = time();//更新时间
        $_POST['click'] = rand(200,500);//点击
        
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
        if(Order::insert($_POST))
        {
            success_jump('添加成功', route('admin_order'));
        }
		else
		{
			error_jump('添加失败！请修改后重新添加');
		}
    }
    
    public function add()
    {
        return view('admin.order.add');
    }
    
    public function edit()
    {
        if(!empty($_GET["id"])){$id = $_GET["id"];}else{$id="";}
        if(preg_match('/[0-9]*/',$id)){}else{exit;}
        
        $data['id'] = $id;
		$data['post'] = Order::where('id', $id)->first();
		
        return view('admin.order.edit', $data);
    }
    
    public function doedit()
    {
        if(!empty($_POST["id"])){$id = $_POST["id"];unset($_POST["id"]);}else {$id="";exit;}
        
		unset($_POST["_token"]);
        if(isset($_POST['editorValue'])){unset($_POST['editorValue']);}
		
        if(Order::where('id', $id)->update($_POST))
        {
            success_jump('修改成功', route('admin_order'));
        }
		else
		{
			error_jump('修改失败！请修改后重新添加');
		}
    }
    
    public function del()
    {
		if(!empty($_GET["id"])){$id = $_GET["id"];}else{error_jump("删除失败！请重新提交");} //if(preg_match('/[0-9]*/',$id)){}else{exit;}
		
		if(Order::whereIn("id", explode(',', $id))->update(array('is_delete'=>1)))
        {
            success_jump('删除成功');
        }
		else
		{
			error_jump("删除失败！请重新提交");
		}
    }
    
    //发货修改物流信息
    public function changeShipping(Request $request)
    {
		if(isset($_POST["id"]) && !empty($_POST["id"])){$id = $_POST["id"];}else{return ReturnData::create(ReturnData::PARAMS_ERROR);}
		
        $data['shipping_id'] = $request->input('shipping_id', '');
        $data['shipping_sn'] = $request->input('shipping_sn', '');
        
        if($data['shipping_id'] == ''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
        if($data['shipping_id'] == 0)
        {
            $data['shipping_name'] = '无须物流';
            unset($data['shipping_sn']);
        }
        else
        {
            if($data['shipping_sn'] == ''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
            
            $data['shipping_name'] = DB::table('kuaidi')->where('id', $data['shipping_id'])->value('name');
        }
        
        if(DB::table('order')->where(['id'=>$id,'shipping_status'=>0])->update($data) === false)
        {
            return ReturnData::create(ReturnData::SYSTEM_FAIL);
        }
        
		return ReturnData::create(ReturnData::SUCCESS);
    }
    
    //修改订单状态
    public function changeStatus(Request $request)
    {
		if(isset($_POST["id"]) && !empty($_POST["id"])){$id = $_POST["id"];}else{return ReturnData::create(ReturnData::PARAMS_ERROR);}
		$status = $request->input('status', '');
        if($status==''){return ReturnData::create(ReturnData::PARAMS_ERROR);}
        
		//2设为已付款，3发货，4设为已收货，7设为无效，8同意退款
        if($status==2)
        {
            $data['pay_status'] = 1;
            
            //...
        }
        elseif($status==3)
        {
            $data['shipping_status'] = 1;
        }
        elseif($status==4)
        {
            $data['order_status'] = 3;
            $data['shipping_status'] = 2;
            
            //...
        }
        elseif($status==7)
        {
            $data['order_status'] = 2;
            
            //返库存
            if(!Order::returnStock($id)){return ReturnData::create(ReturnData::SYSTEM_FAIL);}
        }
        elseif($status==8)
        {
            $data['refund_status'] = 2;
            
            $order = DB::table('order')->where('id', $id)->first();
            if($order->pay_money>0)
            {
                //返余额
                //增加用户余额
                DB::table('user')->where(array('id'=>$order->user_id))->increment('money', $order->pay_money);
                //添加用户余额记录
                DB::table('user_money')->insert(array('user_id'=>$order->user_id,'type'=>0,'money'=>$order->pay_money,'des'=>'退货-返余额','user_money'=>DB::table('user')->where(array('id'=>$order->user_id))->value('money'),'add_time'=>time()));
            }
            
            //返库存
            if(!Order::returnStock($id)){return ReturnData::create(ReturnData::SYSTEM_FAIL);}
        }
        
        if(DB::table('order')->where('id', $id)->update($data) === false)
        {
            return ReturnData::create(ReturnData::SYSTEM_FAIL);
        }
        
        return ReturnData::create(ReturnData::SUCCESS);
    }
    
    //导出订单Excel
    public function outputExcel(Request $request)
    {
        $res = '';
		$where = function ($query) use ($res) {
			if(isset($_REQUEST["keyword"]))
			{
				$query->where('order_sn', 'like', '%'.$_REQUEST['keyword'].'%')->orWhere("name", "like", '%'.$_REQUEST['keyword'].'%')->orWhere("mobile", "like", '%'.$_REQUEST['keyword'].'%');
			}
            
            if(isset($_REQUEST["min_addtime"]) && isset($_REQUEST["max_addtime"]) && !empty($_REQUEST["min_addtime"]) && !empty($_REQUEST["max_addtime"]))
			{
				$query->where('add_time', '>=', $_REQUEST['min_addtime'])->where('add_time', '<=', $_REQUEST["max_addtime"]);
			}
            
            if(isset($_REQUEST["mobile"]))
			{
				$query->where('mobile', 'like', '%'.$_REQUEST['mobile'].'%');
			}
			
            if(isset($_REQUEST["order_sn"]))
			{
				$query->where('order_sn', 'like', '%'.$_REQUEST['order_sn'].'%');
			}
			
            if(isset($_REQUEST["name"]))
			{
				$query->where("name", "like", '%'.$_REQUEST['name'].'%');
			}
            
            //0或者不传表示全部，1待付款，2待发货,3待收货,4待评价(确认收货，交易成功),5退款/售后
			if(isset($_REQUEST["status"]))
			{
                if($_REQUEST["status"] == 1)
                {
                    $query->where(array('order_status'=>0,'pay_status'=>0));
                }
                elseif($_REQUEST["status"] == 2)
                {
                    $query->where(array('order_status'=>0,'shipping_status'=>0,'pay_status'=>1));
                }
                elseif($_REQUEST["status"] == 3)
                {
                    $query->where(array('order_status'=>0,'refund_status'=>0,'shipping_status'=>1));
                }
                elseif($_REQUEST["status"] == 4)
                {
                    $query->where(array('order_status'=>3,'refund_status'=>0));
                }
                elseif($_REQUEST["status"] == 5)
                {
                    $query->where(array('order_status'=>3,'refund_status'=>1));
                }
			}
			
			$query->where('is_delete', 0); //未删除
        };
        
        $cellData = [];
        array_push($cellData,['ID','订单号','时间','状态','商品总价','应付金额','支付金额','收货人','地址','电话','订单来源']);
        $order_list = DB::table('order')->where($where)->orderBy('id', 'desc')->get();
        if($order_list)
        {
            foreach($order_list as $k=>$v)
            {
                $order_status_arr = Order::getOrderStatusText(object_to_array($v, 1));
                $order_list[$k]->order_status_text = $order_status_arr?$order_status_arr['text']:'';
                $order_list[$k]->order_status_num = $order_status_arr?$order_status_arr['num']:'';
                
                $order_list[$k]->province_name = Region::getRegionName($v->province);
                $order_list[$k]->city_name = Region::getRegionName($v->city);
                $order_list[$k]->district_name = Region::getRegionName($v->district);
                $order_list[$k]->place_type_text = Order::getPlaceTypeText(['place_type'=>$v->place_type]);
                
                array_push($cellData,[$v->id,$v->order_sn,date('Y-m-d H:i:s',$v->add_time),$order_list[$k]->order_status_text,$v->goods_amount,$v->order_amount,$v->pay_money,$v->name,$order_list[$k]->province_name.$order_list[$k]->city_name.$order_list[$k]->district_name.' '.$v->address,$v->mobile,$order_list[$k]->place_type_text]);
            }
        }
        
        //导出EXCEL
		\Excel::create('订单列表',function($excel) use ($cellData){
            // Set the title
            $excel->setTitle('order list');
            // Chain the setters
            $excel->setCreator('FLi')->setCompany('FanCheng');
            // Call them separately
            $excel->setDescription('A demonstration to change the file properties');
            
			//第一个工作簿，Sheet1是工作簿的名称
			$excel->sheet('Sheet1', function($sheet) use ($cellData){
				$sheet->rows($cellData);
			});
		})->download('xls');
    }
}