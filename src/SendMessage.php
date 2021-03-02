<?php
namespace chequan\library;

use chequan\library\handler\sendWxMsg;
class SendMessage{
	protected static function sendSms(){

	}	
	protected static function sendWxMsg(){
		sendWxMsg::send($config,$user,$data);

	}
	protected static function sendEmail(){

	}
}
