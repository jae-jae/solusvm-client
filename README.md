# solusvm-client
SolusVM PHP Api,PHP control vps　reboot, shutdown, boot, status。－通过PHP来管理和控制VPS

可用于检测服务器状态，检测拓机并重启服务器。

# Install 安装
```
composer require jaeger/solusvm-client
```
# Code Example 例子

### 1.基本用法 
```php
$vm = new \Jaeger\SolusVm([
    //SolusVM server api url - 服务器SolusVM控制面板的API地址　
    'server_api_url' => 'https://xxxx.com/api/client/command.php',
    //API Key
    'key' => '*****',
    //API Hash
    'hash' => '*****'
]);

//reboot server - 重启服务器
$rt = $vm->reboot();
//$rt = $vm->action('reboot');

//shutdown server - 服务器关机
$rt = $vm->shutdown();

//boot server - 服务器开机
$rt = $vm->boot();

//get server status - 获取服务器状态(是否在线)
$rt = $vm->status();

$rt = $vm->shutdownAndBoot();

//Check if the server is ofline, and reboot the server if the ofline
//检测服务器是否拓机，如果拓机则重启服务器
$rt = $vm->checkAndReboot();

```
### 2.Log 记录日志

本项目使用的日志系统为`Monolog`.

see `Monolog` [documents](https://github.com/Seldaek/monolog/blob/HEAD/doc/02-handlers-formatters-processors.md) .

```php

$vm = new \Jaeger\SolusVm([
    'server_api_url' => 'https://xxxx.com/api/client/command.php',
    'key' => '*****',
    'hash' => '*****',

    //log path - 日志文件路径
    'log' => './log/vm.log'
]);

//or 

$logHandler = new \Monolog\Handler\StreamHandler('./log/vm.log',\Monolog\Logger::INFO);

$vm = new \Jaeger\SolusVm([
       'server_api_url' => 'https://xxxx.com/api/client/command.php',
       'key' => '*****',
       'hash' => '*****',

       //log handler
       'log' => $logHandler
]);

```
Just do it,不需要其它额外操作，这样配置后，项目就可以自动记录日志了。


# Author
Jaeger <JaegerCode@gmail.com>
