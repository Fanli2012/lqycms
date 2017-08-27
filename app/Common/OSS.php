<?php
namespace App\Common;

use JohnLui\AliyunOSS;

class OSS
{

    private $ossClient;

    public function __construct($isInternal = false)
    {
        $serverAddress   = $isInternal ? config('app.ossServerInternal') : config('app.ossServer');
        $this->ossClient = AliyunOSS::boot(
            $serverAddress,
            config('app.AccessKeyId'),
            config('app.AccessKeySecret')
        );
    }

    public static function upload($ossKey, $filePath, $bucket = '')
    {
        $isInternal = config('app.isInternal');
        !$bucket && $bucket = config('app.ossBucket');
        $oss = new OSS($isInternal); // 上传文件使用内网，免流量费
        $oss->ossClient->setBucket($bucket);
        $oss->ossClient->uploadFile($ossKey, $filePath);
    }

    /**
     * 直接把变量内容上传到oss
     *
     * @param        $osskey
     * @param        $content
     * @param string $bucket
     */
    public static function uploadContent($osskey, $content, $bucket = '')
    {
        $isInternal = config('app.isInternal');
        !$bucket && $bucket = config('app.ossBucket');
        $oss = new OSS($isInternal); // 上传文件使用内网，免流量费
        $oss->ossClient->setBucket($bucket);
        $oss->ossClient->uploadContent($osskey, $content);
    }

    /**
     * 删除存储在oss中的文件
     *
     * @param string $ossKey 存储的key（文件路径和文件名）
     * @param string $bucket
     *
     * @return bool
     */
    public static function deleteObject($ossKey, $bucket = '')
    {
        $isInternal = config('app.isInternal');
        !$bucket && $bucket = config('app.ossBucket');
        $oss = new OSS($isInternal); // 上传文件使用内网，免流量费
        return $oss->ossClient->deleteObject($bucket, $ossKey);
    }

    /**
     * 复制存储在阿里云OSS中的Object
     *
     * @param string $sourceBuckt 复制的源Bucket
     * @param string $sourceKey   - 复制的的源Object的Key
     * @param string $destBucket  - 复制的目的Bucket
     * @param string $destKey     - 复制的目的Object的Key
     *
     * @return Models\CopyObjectResult
     */
    public function copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
    {
        $oss = new OSS(true); // 上传文件使用内网，免流量费

        return $oss->ossClient->copyObject($sourceBuckt, $sourceKey, $destBucket, $destKey);
    }

    /**
     * 移动存储在阿里云OSS中的Object
     *
     * @param string $sourceBuckt 复制的源Bucket
     * @param string $sourceKey   - 复制的的源Object的Key
     * @param string $destBucket  - 复制的目的Bucket
     * @param string $destKey     - 复制的目的Object的Key
     *
     * @return Models\CopyObjectResult
     */
    public function moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey)
    {
        $oss = new OSS(true); // 上传文件使用内网，免流量费

        return $oss->ossClient->moveObject($sourceBuckt, $sourceKey, $destBucket, $destKey);
    }

    public static function getUrl($ossKey, $bucket = '')
    {
        !$bucket && $bucket = config('app.ossBucket');
        $oss = new OSS();
        $oss->ossClient->setBucket($bucket);
        return $oss->ossClient->getUrl($ossKey, new \DateTime("+1 day"));
    }

    public static function createBucket($bucketName)
    {
        $oss = new OSS();
        return $oss->ossClient->createBucket($bucketName);
    }

    public static function getAllObjectKey($bucketName)
    {
        $oss = new OSS();
        return $oss->ossClient->getAllObjectKey($bucketName);
    }

}