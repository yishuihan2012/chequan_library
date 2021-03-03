<?php
namespace chequan\library;

use chequan\library\handler\sendWxMsg;
class SendMessage{
	public  static function sendSms(){

	}	
	public static function sendWxMsg($user,$data){
		sendWxMsg::send($user,$data);

	}
	public static function sendEmail(){

	}
}
