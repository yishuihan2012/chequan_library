<?php

namespace chequan\library\core;
/**
 * 
 */
class SendWxMsg 
{
	public function __construct(){
		 if(!$config) {
            $config = _conf('weixinWork');
        }
        $this->corpid = $config['corpid'];
        $this->corpsecret = $config['corpsecret'];
        $this->agentid = $config['agentid'];
        $this->token = $config['token'];
        $this->encodingaeskey = $config['encodingaeskey'];
		$this->redirect_uri = urlencode("http://crm.mayizhixing.com/");
        $this->code = $_GET['code'];
        $this->getAccessToken();
        $this->msg_url = "https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token={$this->access_token}";

        $this->msg_signature = $_GET['msg_signature'];
        $this->timestamp = $_GET['timestamp'];
        $this->nonce = $_GET['nonce'];
	}
	protected static function getAccessToken(){
		
	}
	protected static  function sendText($touser, $content,$toparty='', $totag='', $safe=0){
		$msg['touser'] = $touser == '@all' ?: implode('|', $touser);
        $msg['toparty'] = !$toparty?$toparty:implode('|', $toparty);
        $msg['totag'] = !$totag?$toparty:implode('|', $totag);
        $msg['agentid'] = $this->agentid;
		$msg['text']['content'] = $content;
		$msg['msgtype']="text";
		$result=$this->http_post($this->msg_url,json_encode($msg));
		file_put_contents(ROOT_PATH.'/tmp/sendText.log', "收信人:".implode(',', $touser).'内容:'.$content.'返回：'.$result.PHP_EOL,FILE_APPEND);
		// var_dump($result);die;
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
	protected static function log(){

	}

}