<?php
namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Common\ReturnData;
use App\Common\Helper;

class ImageController extends BaseController
{
    public $path;
    
    public function __construct()
    {
        parent::__construct();
        
        $this->path = '/uploads/'.date('Y/m',time());
    }
    
    //阿里云OSS图片上传
    public function ossImageUpload()
    {
        $res = $this->aliyunOSSFileUpload($_FILES);
        
        if($res['code'] == 1)
        {
            $this->success($res['data']);
        }
        
        $this->error($res['msg']);
    }
    
    /**
     * 多文件上传，成功返回路径，不含域名
     * 格式1：
     * <input type="file" name="file1">
     * <input type="file" name="file2">
     * <input type="file" name="file3">
     * 格式2：
     * <input type="file" name="file[]">
     * <input type="file" name="file[]">
     * <input type="file" name="file[]">
     */
    public function imageUpload(Request $request)
	{
        $res = [];
        $files = $_FILES;//得到传输的数据
        
        if($files)
        {
            // 对上传文件数组信息处理
            $files = $this->dealFiles($files);
            
            foreach($files as $key=>$file)
            {
                $type = strtolower(substr(strrchr($file["name"], '.'), 1)); //文件后缀
                
                $image_path = $this->path.'/'.date('Ymdhis',time()).rand(1000,9999).'.'.$type;
                $uploads_path = $this->path; //存储路径
                
                $allow_type = array('jpg','jpeg','gif','png','doc','docx','txt','pdf'); //定义允许上传的类型
                
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
                if ($file["size"] < 2048000)
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
                    return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'文件不得超过2M');
                }
                
                $res[] = $image_path;
            }
        }
        
        return ReturnData::create(ReturnData::SUCCESS,$res);
    }
    
    public function aliyunOSSFileUpload($files)
    {
        $res = [];
        
        //$files = $_FILES;//得到传输的数据
        $path = 'data/uploads/'.date('Y/m',time());
        
        if($files)
        {
            // 对上传文件数组信息处理
            $files = $this->dealFiles($files);
            
            foreach($files as $key=>$file)
            {
                $type = strtolower(substr(strrchr($file["name"], '.'), 1)); //文件后缀

                $image_path = $path.'/'.date('Ymdhis',time()).rand(1000,9999).'.'.$type;
                $uploads_path = $path; //存储路径

                $allow_type = array('jpg','jpeg','gif','png','doc','docx','txt','pdf'); //定义允许上传的类型

                //判断文件类型是否被允许上传
                if(!in_array($type, $allow_type))
                {
                    //如果不被允许，则直接停止程序运行
                    //$this->error('文件格式不正确');
                    return ['code'=>0,'msg'=>'文件格式不正确','data'=>''];
                }
                
                //判断是否是通过HTTP POST上传的
                if(!is_uploaded_file($file['tmp_name']))
                {
                    //如果不是通过HTTP POST上传的
                    //$this->error('上传失败');
                    return ['code'=>0,'msg'=>'上传失败','data'=>''];
                }

                //文件小于1M
                if ($file["size"] < 2048000)
                {
                    if ($file["error"] > 0)
                    {
                        //$this->error($file["error"]);
                        return ['code'=>0,'msg'=>$file["error"],'data'=>''];
                    }
                    else
                    {
                        /* if(!file_exists(substr(ROOT_PATH, 0, -1).$uploads_path))
                        {
                            Helper::createDir(substr(ROOT_PATH, 0, -1).$uploads_path); //创建文件夹;
                        }

                        move_uploaded_file($file["tmp_name"], substr(ROOT_PATH, 0, -1).$image_path); */
                        
                        $image = AliyunOSS::uploadFile($image_path, $file['tmp_name']);
                        if($image && $image['code']==1){}else{/* $this->error('系统错误'); */return ['code'=>0,'msg'=>'系统错误','data'=>''];}
                    }
                }
                else
                {
                    //$this->error('文件不得超过2M');
                    return ['code'=>0,'msg'=>'文件不得超过2M','data'=>''];
                }
                
                $res[$key] = $image['data']['oss-request-url'];
            }
        }
        else
        {
            //$this->error('参数错误');
            return ['code'=>0,'msg'=>'参数错误','data'=>''];
        }
        
        return ['code'=>1,'msg'=>'操作成功','data'=>$res];
    }
    
    /**
     * 转换上传文件数组变量为正确的方式
     * @access public
     * @param array $files 上传的文件变量
     * @return array
     */
    public function dealFiles($files)
    {
        $fileArray = [];
        $n         = 0;
        foreach ($files as $key => $file) {
            if (is_array($file['name'])) {
                $keys  = array_keys($file);
                $count = count($file['name']);
                for ($i = 0; $i < $count; $i++) {
                    $fileArray[$n]['key'] = $key;
                    foreach ($keys as $_key) {
                        $fileArray[$n][$_key] = $file[$_key][$i];
                    }
                    $n++;
                }
            } else {
                $fileArray = $files;
                break;
            }
        }
        
        return $fileArray;
    }
    
    /**
     * base64图片上传，成功返回路径，不含域名，只能单图上传
     * @param string img base64字符串
     * @return string
     */
    public function base64ImageUpload(Request $request)
	{
        $res = [];
        $base64_img = $_POST['img'];
        
        if($base64_img)
        {
            if(preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_img, $result))
            {
                $type = $result[2];
                if(in_array($type, array('jpeg','jpg','gif','bmp','png')))
                {
                    $image_path = $this->path.'/'.date('Ymdhis',time()).rand(1000,9999).'.'.$type;
                    $uploads_path = $this->path; //存储路径
                    
                    if(!file_exists($this->public_path.$uploads_path))
                    {
                        Helper::createDir($this->public_path.$uploads_path); //创建文件夹;
                    }
                    
                    if(file_put_contents($this->public_path.$image_path, base64_decode(str_replace($result[1], '', $base64_img))))
                    {
                        return ReturnData::create(ReturnData::SUCCESS,null,$image_path);
                    }
                    else
                    {
                        return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'图片上传失败');
                    }
                }
                else
                {
                    //文件类型错误
                    return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'图片上传类型错误');
                }
            }
            else
            {
                //文件错误
                return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'文件错误');
            }
        }
        
        return ReturnData::create(ReturnData::SYSTEM_FAIL,null,'请上传文件');
    }
}