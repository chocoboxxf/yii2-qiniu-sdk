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

设置方法
--------

```php
// 全局使用
// 在config/main.php配置文件中定义component配置信息
'components' => [
  .....
  'qiniu' => [ 
      'class' => 'chocoboxxf\Qiniu\Qiniu',
      'accessKey' => 'Access Key',
      'secretKey' => 'Secret Key',
      'domain' => '七牛域名',
      'bucket' => '空间名',
      'secure' => false, // 是否使用HTTPS，默认为false
  ]
  ....
]
// 代码中调用
$result = Yii::$app->qiniu->putFile('img/test.jpg', __DIR__.'/test.jpg');
....
```

```php
// 局部调用
$qiniu = Yii::createObject([
    'class' => 'chocoboxxf\Qiniu\Qiniu',
    'accessKey' => 'Access Key',
    'secretKey' => 'Secret Key',
    'domain' => '七牛域名',
    'bucket' => '空间名',
    'secure' => false, // 是否使用HTTPS，默认为false
]);
$result = $qiniu->putFile('img/test.jpg', __DIR__.'/test.jpg');
....
```

使用示例
--------

上传文件（通过路径）

```php
$ret = Yii::$app->qiniu->putFile('img/test.jpg', __DIR__.'/test.jpg');
if ($ret['code'] === 0) {
    // 上传成功
    $url = $ret['result']['url']; // 目标文件的URL地址，如：http://[七牛域名]/img/test.jpg
} else {
    // 上传失败
    $code = $ret['code']; // 错误码
    $message = $ret['message']; // 错误信息
}
```

上传文件（通过内容）

```php
$fileData = file_get_contents(__DIR__.'/test.jpg');
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

获取私有文件下载链接

```php
$fileList = [
    'http://domain/private-file1.jpg',
    'http://domain/private-file2.jpg',
    'http://domain/private-file3.jpg',
];
$urlMaps = Yii::$app->qiniu->batchDownload($fileList);
foreach ($urlMaps as $fileUrl => $downloadUrl) {
    // TODO
}
```