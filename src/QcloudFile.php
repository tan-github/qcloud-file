<?php
namespace Qcloud;

require dirname(__FILE__) . '/../vendor/autoload.php';

class QcloudFile{

    private $cosClient;
    private $bucket='';
    private $appId='';
    private $secretId= ""; //"云 API 密钥 SecretId";
    private $secretKey = ""; //"云 API 密钥 SecretKey";
    private $timeOut=30;
    private $region = ""; //设置一个默认的存储桶地域
    public function __construct($qcloud_params)
    {
        $this->bucket = $qcloud_params['bucket'];
        $this->appId = $qcloud_params['app_id'];
        $this->secretId = $qcloud_params['secret_id'];
        $this->secretKey = $qcloud_params['secret_key'];
        $this->timeOut = $qcloud_params['time_out'];
        $this->region = $qcloud_params['region'];

        $this->cosClient = new \Qcloud\Cos\Client(
            array(
                'region' => $this->region,
                'schema' => 'http', //协议头部，默认为http
                'credentials'=> array(
                    'secretId'  => $this->secretId ,
                    'secretKey' => $this->secretKey,
                    'appId'=>$this->appId,
                    'timeout'=>$this->timeOut
                )
            )
        );
    }

    public function putFile($key,$localFile){

        $data=array(
            'status'=>0
        );
        if(!file_exists($localFile)){
            $data=array(
                'msg'=>"文件不存在"
            );
            return $data;
        }

        if(!$body=fopen($localFile, 'rb')){
            $data=array(
                'msg'=>"文件拒绝访问"
            );
            return $data;
        }
        try {
            $result = $this->cosClient->upload($this->bucket, $key, $body);

            if($result && isset($result['Location']) && $result['Location']){
                $data['status']=1;
                $data['url']=$result['Location'];
            }
        } catch (\Exception $e) {
            // 请求失败
            //echo($e);
            $data['msg']=$e;
        }
        return $data;
    }
}