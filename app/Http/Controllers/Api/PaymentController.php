<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;
use App\Http\Model\Payment;

class PaymentController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //获取支付方式列表
    public function paymentList(Request $request)
	{
        //参数
        $data['status'] = $request->input('status', -1);
        
        $res = Payment::getList($data);
		if(!$res)
		{
			return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$res);
		}
        
		return ReturnData::create(ReturnData::SUCCESS,$res);
    }
}