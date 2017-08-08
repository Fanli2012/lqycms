<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Token;

class IndexController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //安卓升级信息
	public function andriodUpgrade()
	{
		$res = array(
			'appname'       => 'lqycms', //app名字
			'serverVersion' => 2, //服务器版本号
            'serverFlag'    => 1, //服务器标志
			'lastForce'     => 0, //是否强制更新，0不强制，1强制
            'updateurl'     => 'http://api.52danchuang.com/wap/app-release.apk', //apk下载地址
			'upgradeinfo'   => '描述：3.0.0' //版本更新的描述
		);

		return ReturnData::create(ReturnData::SUCCESS, $res);
	}
    
    
}
