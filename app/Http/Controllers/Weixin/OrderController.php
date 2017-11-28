<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;

class OrderController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //订单列表
    public function orderList(Request $request)
	{
        $pagesize = 10;
        $offset = 0;
        
        if(isset($_REQUEST['page'])){$offset = ($_REQUEST['page']-1)*$pagesize;}
        
        $status = $request->input('status','');
        
        $postdata = array(
            'limit'  => $pagesize,
            'offset' => $offset,
            'status' => $status, //0或者不传表示全部，1待付款，2待发货,3待收货,4待评价,5退款/售后
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/order_list";
		$res = curl_request($url,$postdata,'GET');
        $data['list'] = $res['data']['list'];
        
        $data['totalpage'] = ceil($res['data']['count']/$pagesize);
        
        if(isset($_REQUEST['page_ajax']) && $_REQUEST['page_ajax']==1)
        {
    		$html = '';
            
            if($res['data']['list'])
            {
                foreach($res['data']['list'] as $k => $v)
                {
                    $html .= '<li><a href="'.$v['goods']['goods_detail_url'].'"><span class="goods_thumb"><img alt="'.$v['goods']['title'].'" src="'.env('APP_URL').$v['goods']['litpic'].'"></span></a>';
                    $html .= '<div class="goods_info"><p class="goods_tit">'.$v['goods']['title'].'</p>';
                    $html .= '<p class="goods_price">￥<b>'.$v['goods']['price'].'</b></p>';
                    $html .= '<p class="goods_des fr"><span id="del_history" onclick="delconfirm(\''.route('weixin_user_goods_history_delete',array('id'=>$v['id'])).'\')">删除</span></p>';
                    $html .= '</div></li>';
                }
            }
            
    		exit(json_encode($html));
    	}
        
        return view('weixin.order.orderList', $data);
    }
	
    //订单支付
    public function pay($id)
	{
        //获取订单详情
        $postdata = array(
            'order_id' => $id, //要支付的订单id
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/order_detail";
		$res = curl_request($url,$postdata,'GET');
        $data['order_detail'] = $res['data'];
        $data['order_id'] = $id;
        
        /* if(!$res['code']!=0){$this->error_jump('订单不存在或已过期');} */
        
        //获取会员信息
        $postdata = array(
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/user_info";
		$res = curl_request($url,$postdata,'GET');
        $data['user_info'] = $res['data'];
        
        //判断余额是否足够
        $is_balance_enough = 1; //足够
        if($data['order_detail']['total_price']>$data['user_info']['money']){$is_balance_enough = 0;}
        $data['is_balance_enough'] = $is_balance_enough;
        
		return view('weixin.order.pay', $data);
	}
    
    public function dopay(Request $request)
	{
        $order_id = $request->input('order_id','');
        $payment_id = $request->input('payment_id','');
        
        if($order_id == '' || $order_id == '')
        {
            $this->error_jump(ReturnData::PARAMS_ERROR);
        }
        
        $url = '';
        
        if($payment_id == 1) //余额支付
        {
            $url = '';
        }
        elseif($payment_id == 2) //微信支付
        {
            $url = route('weixin_order_wxpay',array('order_id'=>$order_id));
        }
        
        if($url == '')
        {
            $this->error_jump('订单不存在或已过期');
        }
        else
        {
            header('Location: '.$url);
            exit;
        }
    }
    
    public function orderWxpay(Request $request)
	{
        $order_id = $request->input('order_id','');
        
        //获取订单详情
        $postdata = array(
            'order_id' => $order_id, //要支付的订单id
            'access_token' => $_SESSION['weixin_user_info']['access_token']
		);
        $url = env('APP_API_URL')."/order_detail";
		$res = curl_request($url,$postdata,'GET');
        $data['order_detail'] = $res['data'];
        $data['order_id'] = $order_id;
        
        if(!$res['code']!=0){$this->error_jump('订单不存在或已过期');}
        
        //微信支付-start
        require_once(resource_path('org/wxpay/WxPayConfig.php')); // 导入微信配置类
        require_once(resource_path('org/wxpay/WxPayPubHelper.class.php')); // 导入微信支付类
        
		$body = '订单支付';//订单详情
		$out_trade_no = $data['order_detail']['order_sn'];//订单号
		$total_fee = floatval($data['order_detail']['order_amount']*100);//价格0.01
        $attach = 'pay_type=2'; //pay_type=2订单支付
		$notify_url = route('weixin_wxpay_notify');//通知地址
		$wxconfig= \WxPayConfig::wxconfig();
        
		//=========步骤1：网页授权获取用户openid============
		$jsApi = new \JsApi_pub($wxconfig);
		$openid = $jsApi->getOpenid();
		//=========步骤2：使用统一支付接口，获取prepay_id============
		//使用统一支付接口
        $unifiedOrder = new \UnifiedOrder_pub($wxconfig);
		//设置统一支付接口参数
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//spbill_create_ip已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$unifiedOrder->setParameter("openid","$openid");//微信用户
		$unifiedOrder->setParameter("body","$body");//商品描述
		$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号
		$unifiedOrder->setParameter("total_fee","$total_fee");//总金额
		$unifiedOrder->setParameter("attach","$attach"); //附加数据，选填，在查询API和支付通知中原样返回，可作为自定义参数使用，示例：a=1&b=2
        $unifiedOrder->setParameter("notify_url","$notify_url");//通知地址
		$unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
		$prepay_id = $unifiedOrder->getPrepayId();
		//=========步骤3：使用jsapi调起支付============
		$jsApi->setPrepayId($prepay_id);
		$jsApiParameters = $jsApi->getParameters();
        
		$data['jsApiParameters'] = $jsApiParameters;
        $data['returnUrl'] = route('weixin_order_list'); //支付完成要跳转的url，跳转到用户订单列表页面
        
        return view('weixin.order.orderWxpay', $data);
    }
}