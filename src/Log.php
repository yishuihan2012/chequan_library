<?php
namespace chequan\library;
class Log{
	public  static  function log($data,$path='default',$name='log'){
		if (extension_loaded('SeasLog')){
			    SeasLog::info($data);
		}else{
            $saveDir=__DIR__."/../../../../storage/logs/".$path."/".date('Y').'/'.date('m-d')."/";
            if(!is_dir($saveDir)) mkdir($saveDir, 0777, true);
            file_put_contents($saveDir.$name.".log", '['.date('Y-m-d H:i:s').']'.$data.PHP_EOL,FILE_APPEND);
		}
	}
}
