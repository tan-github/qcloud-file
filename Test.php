<?php
require_once __DIR__.'/vendor/autoload.php';
date_default_timezone_set('PRC');

/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2021/5/27
 * Time: 15:59
 */

class Test
{
    public function test2()
    {
        /*************************** 测试 *******************************/
        $config = array(
            'bucket' => 'xxxxxxxx',
            'app_id' => 'xxxxxxxx',
            'secret_id' => 'xxxxxxxx',//"云 API 密钥 SecretId";
            'secret_key' => 'xxxxxxxx',//"云 API 密钥 SecretKey";
            'time_out' => 30,
            'region' => 'xxxxxxxx',//设置一个默认的存储桶地域
        );
        $test = new \Qcloud\QcloudFile($config);
        $rs = $test->putFile('test/test_file', 'testfile.txt');

        var_dump($rs);
    }
}

(new Test())->test2();