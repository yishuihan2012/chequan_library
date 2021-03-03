# chequan_library

1.存入日志
```
use chequan\library\Log;
Log::log($data,$path='default',$name='log');
# data：数据，path:自定义文件夹，name:自定义文件名
```
2:发送企业微信消息
```
use chequan\library\SendMessage;
SendMessage::sendWxMsg(['XuChengCheng'],"test");
##发送人为一维数组，支持多人同时发送
```
3. curl请求
```
use chequan\library\Request;
Request::curl($url,'post',$data,$header);
# 支持get和post请求

```
4. 暂无

