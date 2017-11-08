<?php
namespace App\Http\Controllers\Weixin;

use App\Http\Controllers\Weixin\CommonController;
use Illuminate\Http\Request;

class WxPayController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
	
    //微信支付回调
    public function wxpayNotify(Request $request)
	{
        require_once(resource_path('org/wxpay/WxPayPubHelper.class.php'));
        
		return view('weixin.cart.index', $data);
	}
}