<?php
/**
 * 七牛云文件批量下载API测试
 * User: chocoboxxf
 * Date: 16/3/7
 * Time: 下午10:13
 */
namespace chocoboxxf\Qiniu\Tests;

use Yii;

class BatchDownloadTest extends \PHPUnit_Framework_TestCase
{
    public function testDownload()
    {
        $qiniu = Yii::createObject([
            'class' => 'chocoboxxf\Qiniu\Qiniu',
            'accessKey' => 'Access Key',
            'secretKey' => 'Secret Key',
            'domain' => '七牛域名',
            'bucket' => '空间名',
            'secure' => false,
        ]);
        $input = [
            'http://domain/private-file1',
            'http://domain/private-file2',
        ];
        $ret = $qiniu->batchDownload($input);
        var_dump($ret);
    }
}
