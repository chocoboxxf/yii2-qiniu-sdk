<?php
/**
 * 七牛云SDK
 * User: chocoboxxf
 * Date: 15/12/5
 * Time: 下午4:32
 */
namespace chocoboxxf\Qiniu;

use Yii;
use yii\base\Component;
use yii\base\InvalidConfigException;
use Qiniu\Auth;
use Qiniu\Storage\UploadManager;


class Qiniu extends Component
{
    const CODE_SUCCESS = 0; // 正常返回时使用"0"作为code
    const MESSAGE_SUCCESS = 'ok'; // 正常返回时使用"ok"作为message

    public $accessKey; // Access Key

    public $secretKey; // Secret Key

    public $domain; // 七牛域名

    public $bucket; // 使用的空间

    public $secure = false; // 是否使用HTTPS，默认不使用

    protected $auth;

    protected $managers;

    public function init()
    {
        parent::init();
        if (!isset($this->accessKey)) {
            throw new InvalidConfigException('请先配置Access Key');
        }
        if (!isset($this->secretKey)) {
            throw new InvalidConfigException('请先配置Secret Key');
        }
        if (!isset($this->domain)) {
            throw new InvalidConfigException('请先配置您的七牛域名');
        }
        if (!isset($this->bucket)) {
            throw new InvalidConfigException('请先配置使用的Bucket');
        }
        $this->auth = new Auth($this->accessKey, $this->secretKey);
        $this->managers = [];
    }

    /**
     * 使用文件内容上传
     * @param $fileName 目标文件名
     * @param $fileData 文件内容
     * @return mixed
     */
    public function put($fileName, $fileData)
    {
        if (!isset($this->managers['upload'])) {
            $this->managers['upload'] = new UploadManager();
        }
        $uploadToken = $this->auth->uploadToken($this->bucket);
        list($ret, $err) = $this->managers['upload']->put($uploadToken, $fileName, $fileData);
        // 正常情况
        if (is_null($err)) {
            return [
                'code' => self::CODE_SUCCESS,
                'message' => self::MESSAGE_SUCCESS,
                'result' => [
                    'hash' => $ret['hash'],
                    'key' => $ret['key'],
                    'url' => sprintf('%s%s/%s',
                        $this->secure ? 'https://' : 'http://',
                        rtrim($this->domain, '/'),
                        $fileName
                    ),
                ],
            ];
        }
        // 错误情况
        return [
            'code' => $err->code(),
            'message' => $err->message(),
            'result' => [
                'hash' => '',
                'key' => '',
                'url' => '',
            ],
        ];
    }

    /**
     * 使用文件路径上传
     * @param $fileName 目标文件名
     * @param $filePath 本地文件路径
     * @return mixed
     */
    public function putFile($fileName, $filePath)
    {
        if (!isset($this->managers['upload'])) {
            $this->managers['upload'] = new UploadManager();
        }
        $uploadToken = $this->auth->uploadToken($this->bucket);
        list($ret, $err) = $this->managers['upload']->putFile($uploadToken, $fileName, $filePath);

        // 正常情况
        if (is_null($err)) {
            return [
                'code' => self::CODE_SUCCESS,
                'message' => self::MESSAGE_SUCCESS,
                'result' => [
                    'hash' => $ret['hash'],
                    'key' => $ret['key'],
                    'url' => sprintf('%s%s/%s',
                        $this->secure ? 'https://' : 'http://',
                        rtrim($this->domain, '/'),
                        $fileName
                    ),
                ],
            ];
        }
        // 错误情况
        return [
            'code' => $err->code(),
            'message' => $err->message(),
            'result' => [
                'hash' => '',
                'key' => '',
                'url' => '',
            ],
        ];
    }

}