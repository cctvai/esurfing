# 关于
中国电信天翼开放平台 第三方PHP SDK 
https://github.com/wenpeng/esurfing

# 使用
```
use Wenpeng\Esurfing\Client;
$client = new Client($appID, $appSecret);
```

## 模板短信
```
use Wenpeng\Esurfing\Request\TemplateSMS;
$sms = new TemplateSMS($client);

// 发送短信
$result = $sms->send(模板编号, 手机号码, 模板参数);

// 发送状态
$status = $sms->status($result->idertifier);
```
