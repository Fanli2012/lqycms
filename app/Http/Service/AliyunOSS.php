<?php
// +----------------------------------------------------------------------
// | 阿里云OSS服务
// +----------------------------------------------------------------------
namespace App\Http\Service;
require_once base_path('resources/org/OSS').'/OssClient.php';
require_once base_path('resources/org/OSS/Core').'/OssException.php';
use OSS\OssClient;
use OSS\Core\OssException;

class AliyunOSS
{
    const OSS_ACCESS_ID = 'LTAIqMYGJYT5U7ij';
    const OSS_ACCESS_KEY = 'yuQvyKywTaZ2ncx6hkSfr836GtETfd';
    const OSS_ENDPOINT = 'oss-cn-shenzhen.aliyuncs.com';
    const OSS_TEST_BUCKET = 'cheyoubao';
    /**
     * 根据Config配置，得到一个OssClient实例
     *
     * @return OssClient 一个OssClient实例
     */
    public static function getOssClient()
    {
        try {
            $ossClient = new \OssClient(self::OSS_ACCESS_ID, self::OSS_ACCESS_KEY, self::OSS_ENDPOINT, false);
        } catch (\OssException $e) {
            return ['code'=>1, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return $ossClient;
    }

    public static function getBucketName()
    {
        return self::OSS_TEST_BUCKET;
    }

    /**
     * 工具方法，创建一个存储空间，如果发生异常直接exit
     */
    public static function createBucket()
    {
        $ossClient = self::getOssClient();
        if (is_null($ossClient)) exit(1);
        $bucket = self::getBucketName();
        $acl = OssClient::OSS_ACL_TYPE_PUBLIC_READ;
        try {
            $res = $ossClient->createBucket($bucket, $acl);
        } catch (\OssException $e) {
            return ['code'=>1, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return ['code'=>0, 'msg'=>'操作成功', 'data'=>$res];
    }
    
    /**
     * 上传指定的本地文件内容
     *
     * @param OssClient $ossClient OssClient实例
     * @param string $bucket 存储空间名称
     * @return null
     */
    public static function uploadFile($object, $filePath)
    {
        //$object = "oss-php-sdk-test/upload-test-object-name.txt";
        //$filePath = __FILE__;
        $options = array();
        $ossClient = self::getOssClient();
        $bucket = self::getBucketName();
        
        try {
            //self::createBucket(); //如果没创建存储空间，先用这行执行创建存储空间
            $res = $ossClient->uploadFile($bucket, $object, $filePath, $options);
        } catch (\OssException $e) {
            return ['code'=>1, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return ['code'=>0, 'msg'=>'操作成功', 'data'=>$res];
    }
    
    /**
     * 把本地变量的内容到文件
     *
     * 简单上传,上传指定变量的内存值作为object的内容
     *
     * @param OssClient $ossClient OssClient实例
     * @param string $bucket 存储空间名称
     * @return null
     */
    public static function putObject($object, $filePath)
    {
        //$object = "oss-php-sdk-test/upload-test-object-name.txt";
        $content = file_get_contents($filePath);
        $options = array();
        $ossClient = self::getOssClient();
        $bucket = self::getBucketName();
        
        try {
            $res = $ossClient->putObject($bucket, $object, $content, $options);
        } catch (\OssException $e) {
            return ['code'=>1, 'msg'=>$e->getMessage(), 'data'=>''];
        }
        
        return ['code'=>0, 'msg'=>'操作成功', 'data'=>$res];
    }
}