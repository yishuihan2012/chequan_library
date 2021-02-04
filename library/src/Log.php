<?php
namespace chequan\library;
class Log{
	protected  static  function log($data,$path='default',$name='log'){
		if (extension_loaded('SeasLog')){
			    SeasLog::info($data);
		}else{
			file_put_contents(__DIR__."/../storage/logs/".$path."/".date('Y').'/'.date('m-d')."/".$name.".log", '['.date('Y-m-d H:i:s').']'.$data.PHP_EOL);
		}
	}
}