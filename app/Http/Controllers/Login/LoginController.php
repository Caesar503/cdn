<?php

namespace App\Http\Controllers\Login;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\User;
use Illuminate\Support\Str;
use App\Model\Goods;
class LoginController extends Controller
{
    public function login()
    {
        return view('login.login');
    }
    public function logindo(Request $request)
    {
        if(!$request->username||!$request->pwd){
            $arr = [
                'err'=>4,
                'msg'=>'参数不完整！'
            ];
            die(json_encode($arr,JSON_UNESCAPED_UNICODE));
        }

        $data = [
            'username'=>$request->username,
            'pwd'=>$request->pwd
        ];

        /*
         * 获取私钥
         */
        $pr_k = openssl_get_privatekey("file://".storage_path('app/keys/rsa_private_key.pem'));
        //签名
        openssl_sign(json_encode($data),$sign,$pr_k);
        $sign = base64_encode($sign);
        $url="http://5.test.com/loginCheck?sign=".$sign;
        $ch = curl_init($url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($ch,CURLOPT_POST,true);
        curl_setopt($ch,CURLOPT_POSTFIELDS,base64_encode(json_encode($data)));
        curl_setopt($ch,CURLOPT_HTTPHEADER,['Content-Type:text/plain']);
        $res = curl_exec($ch);
        echo curl_errno($ch);
        echo "<hr>";
        /*
         * 解密
         */
        openssl_private_decrypt(base64_decode($res),$res1,$pr_k);
        $res2 = json_decode($res1,true);
        print_r($res2);
        curl_close($ch);
//        $res = Goods::get()->toArray();
//        return view('goods.index',['res'=>$res,'token'=>$res2['token']]);
    }
    public function loginCheck()
    {
        $sign = $_GET['sign'];
        $arr = base64_decode(file_get_contents("php://input"));
        /*
        * 获取公钥
        */
        $pu_k = openssl_get_publickey("file://".storage_path('app/keys/rsa_public_key.pem'));
//        dump($pu_k);die;
        /*
         * 验证签名
         */
        $res = openssl_verify($arr,base64_decode($sign),$pu_k);
        $arr = json_decode($arr,true);
        if(!$res){
            $info = User::where('username',$arr['username'])->first();
            if($info){
                if($info->pwd!=$arr['pwd']){
                    $res1 = [
                        'err'=>5,
                        'msg'=>'该用户不存在或者密码错误！'
                    ];
                }else{
                    //生成token
                    $token = Str::random('8').substr(time(),5,10).$info['id'];
                    $res1 = [
                        'err'=>1,
                        'msg'=>'登陆成功！',
                        'token'=>$token
                    ];
                }
            }else{
                $res1 = [
                    'err'=>5,
                    'msg'=>'该用户不存在！'
                ];
            }
        }else{
            $res1 = [
                'err'=>5,
                'msg'=>'参数丢失或者不完整！'
            ];
        }
        /*
         * 加密数据
         */
        openssl_public_encrypt(json_encode($res1),$info,$pu_k);
        echo base64_encode($info);
    }
}
