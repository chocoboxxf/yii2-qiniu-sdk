# yii2-qiniu-sdk
基于Yii2实现的七牛云存储API SDK（使用官方SDK）（目前开发中）

环境条件
--------
- >= PHP 5.4
- >= Yii 2.0
- cURL extension

安装
----

添加下列代码在``composer.json``文件中并执行``composer update --no-dev``操作

```json
{
    "require": {
       "chocoboxxf/yii2-qiniu-sdk": "dev-master"
    }
}
```

使用示例
--------

文件上传 API

```php
// 全局使用
// 在config/main.php配置文件中定义component配置信息
'components' => [
  .....
  'qiniu' => [ // 
    'class' => 'chocoboxxf\Qiniu\Qiniu',
    'accessKey' => 'Access Key',
    'secretKey' => 'Secret Key',
    'domain' => '七牛域名',
    'bucket' => '空间名',
    'secure' => false, // 是否使用HTTPS，默认为false
  ]
  ....
]
....
// 根据文件路径上传
$ret = Yii::$app->qiniu->putFile('img/test.jpg', __DIR__.'/test.jpg');
if ($ret['code'] === 0) {
    // 上传成功
    $url = $ret['result']['url']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg
} else {
    // 上传失败
    $code = $ret['code']; // 错误码
    $message = $ret['message']; // 错误信息
}
....
// 根据文件内容上传
$fileData = file_get_contents(__DIR__.'test.jpg');
$ret = Yii::$app->qiniu->put('img/test.jpg', $fileData);
if ($ret['code'] === 0) {
    // 上传成功
    $url = $ret['result']['url']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg
} else {
    // 上传失败
    $code = $ret['code']; // 错误码
    $message = $ret['message']; // 错误信息
}
```

```
// 局部调用
$qiniu = Yii::createObject([
    'class' => 'chocoboxxf\Qiniu\Qiniu',
    'accessKey' => 'Access Key',
    'secretKey' => 'Secret Key',
    'domain' => '七牛域名',
    'bucket' => '空间名',
    'secure' => false, // 是否使用HTTPS，默认为false
]);
// 根据文件路径上传
$ret = $qiniu->putFile('img/test.jpg', __DIR__.'/test.jpg');
if ($ret['code'] === 0) {
    // 上传成功
    $url = $ret['result']['url']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg
} else {
    // 上传失败
    $code = $ret['code']; // 错误码
    $message = $ret['message']; // 错误信息
}
....
// 根据文件内容上传
$fileData = file_get_contents(__DIR__.'test.jpg');
$ret = $qiniu->putFile('img/test.jpg', $fileData);
if ($ret['code'] === 0) {
    // 上传成功
    $url = $ret['result']['url']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg
} else {
    // 上传失败
    $code = $ret['code']; // 错误码
    $message = $ret['message']; // 错误信息
}
....
```