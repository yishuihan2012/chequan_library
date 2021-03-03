<?php
/**
 *发送企业微信消息
 */
namespace chequan\library\handler;

use chequan\library\Log;

use chequan\library\Request;

class SendWxMsg
{
	public static function getWxConfig(){
                $config = require(__DIR__."/../config/WxConfig.php");
        	$config['redirect_uri'] = urlencode("http://crm.mayizhixing.com/");
                return $config;
                $this->code = $_GET['code'];
                $this->getAccessToken();
                $this->msg_url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$this->access_token}";

                $this->msg_signature = $_GET['msg_signature'];
                $this->timestamp = $_GET['timestamp'];
                $this->nonce = $_GET['nonce'];
                
	}
	public static function getAccessToken($config){
                $token_config = require_once(__DIR__."/../config/tokenConfig.php");
                if(!$token_config || $token_config===1 || ($token_config['expire_time']<time())) {
                    $res=Request::curl("https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid={$config['corpid']}&corpsecret={$config['corpsecret']}",'GET');
                    if($res && $res=json_decode($res,true)){
                        $access_token=$res['access_token'];
                        file_put_contents(__DIR__."/../config/tokenConfig.php", "<?php return array('expire_time'=>".(time()+$res['expires_in']).", 'access_token'=>'".$access_token."');?>");
                    }else{
                        return false;
                    }     
                } else {
                    $access_token = $token_config['access_token'];
                }
                return $access_token;
	}
	public static  function sendText($touser, $content,$toparty='', $totag='', $safe=0){
	        $config=self::getWxConfig();
                $token=self::getAccessToken($config);
                if(!$token){
                        Log::log("收信人:".implode(',', $touser).'内容:'.$content.'返回：获取token失败','sendMsg','sendResult');
                        return false;
                }
                $msg['touser'] = $touser == '@all' ?: implode('|', $touser);
                $msg['toparty'] = !$toparty?$toparty:implode('|', $toparty);
                $msg['totag'] = !$totag?$toparty:implode('|', $totag);
                $msg['agentid'] = $config['agentid'];
		$msg['text']['content'] = $content;
		$msg['msgtype']="text";
		$result=Request::curl("https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$token}",'POST',json_encode($msg));
                Log::log("收信人:".implode(',', $touser).'内容:'.$content.'返回：'.$result,'sendMsg','sendResult');
		if ($result) {
			$result = json_decode($result,true);
			if (!$result || !empty($result['errcode'])) {
				$this->errCode = $result['errcode'];
				$this->errMsg = $result['errmsg'];
				return false;
			}
			return true;;
		}  
		return false;
	}
}
