<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;

//二维码,如果输出乱码就转成base64输出
class QrcodeController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    public function createSimpleQrcode(Request $request)
	{
        //参数
        $url = $request->input('url','');
        $size = $request->input('size', 150);
        $is_binary = $request->input('is_binary',0); //0表示不是二进制，1表示二进制流base64
        
        if($url=='')
		{
            return ReturnData::create(ReturnData::PARAMS_ERROR);
        }
        
        if($is_binary==1){return Helper::qrcode($url,$size);}
        
		return '<img src="'.Helper::qrcode($url,$size).'">';
    }
    
    //二维码
	public function qrcode()
	{
		$url = $_REQUEST['url'];
		
		$url = str_replace("%26","&",$url);
		$url = str_replace("%3F","?",$url);
		$url = str_replace("%3D","=",$url);
		
        require_once(resource_path('org/phpqrcode/phpqrcode.php'));
        
		return \QRcode::png($url,false,"H",6);
	}
}