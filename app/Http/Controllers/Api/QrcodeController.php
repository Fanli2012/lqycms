<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;

//二维码
class QrcodeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function createSimpleQrcode(Request $request)
	{
        //参数
        $url = $request->input('url');
        $size = $request->input('size', 150);
        
		return '<img src="'.Helper::qrcode($url,$size).'">';
    }
}