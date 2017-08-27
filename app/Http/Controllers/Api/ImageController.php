<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\CommonController;
use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;

class ImageController extends CommonController
{
    public function __construct()
    {
        parent::__construct();
    }
    
    //文件上传，成功返回路径，不含域名
    public function imageUpload(Request $request)
	{
        $file = $_FILES['file'];//得到传输的数据
        
        $type = strtolower(substr(strrchr($file["name"], '.'), 1)); //文件后缀
        
        $image_path = '/uploads/'.date('Y/m',time()).'/'.date('Ymdhis',time()).rand(1000,9999).'.'.$type;
        $uploads_path = '/uploads/'.date('Y/m',time()); //存储路径
        
        $allow_type = array('jpg','jpeg','gif','png','doc','docx','txt'); //定义允许上传的类型
        
        //判断文件类型是否被允许上传
        if(!in_array($type, $allow_type))
        {
            //如果不被允许，则直接停止程序运行
            return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'文件格式不正确');
        }
        
        //判断是否是通过HTTP POST上传的
        if(!is_uploaded_file($file['tmp_name']))
        {
            //如果不是通过HTTP POST上传的
            return ReturnData::create(ReturnData::SYSTEM_FAIL);
        }
        
        //文件小于1M
        if ($file["size"] < 1024000)
        {
            if ($file["error"] > 0)
            {
                return ReturnData::create(ReturnData::SYSTEM_FAIL,null,$file["error"]);
            }
            else
            {
                if(!file_exists(base_path('public').$uploads_path))
                {
                    Helper::createDir(base_path('public').$uploads_path); //创建文件夹;
                }
                
                move_uploaded_file($file["tmp_name"], base_path('public').$image_path);
            }
        }
        else
        {
            return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'文件不得超过1M');
        }
        
        return ReturnData::create(ReturnData::SUCCESS,$image_path);
    }
}