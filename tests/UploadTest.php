<?php
/**
 * 七牛云文件上传API测试
 * User: chocoboxxf
 * Date: 15/12/5
 * Time: 下午10:55
 */
namespace chocoboxxf\Qiniu\Tests;

use Yii;

class UploadTest extends \PHPUnit_Framework_TestCase
{
    public function testPutFile()
    {
        $qiniu = Yii::createObject([
            'class' => 'chocoboxxf\Qiniu\Qiniu',
            'accessKey' => 'Access Key',
            'secretKey' => 'Secret Key',
            'domain' => '七牛域名',
            'bucket' => '空间名',
            'secure' => false,
        ]);
        $ret = $qiniu->putFile('img/test.jpg', __DIR__.'/data/qiniu.jpg');
        $this->assertEquals(401, $ret['code']);
    }

    public function testPutFileData()
    {
        $qiniu = Yii::createObject([
            'class' => 'chocoboxxf\Qiniu\Qiniu',
            'accessKey' => 'Access Key',
            'secretKey' => 'Secret Key',
            'domain' => '七牛域名',
            'bucket' => '空间名',
            'secure' => true,
        ]);
        $fileData = file_get_contents(__DIR__.'/data/qiniu.jpg');
        $ret = $qiniu->put('img/test.jpg', $fileData);
        $this->assertEquals('bad token', $ret['message']);
    }
}
