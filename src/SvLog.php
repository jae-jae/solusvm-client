<?php
/**
 * Created by PhpStorm.
 * User: x
 * Date: 16-12-7
 * Time: 下午4:47
 */

namespace Jaeger;

use Monolog\Logger;
use Monolog\Handler\StreamHandler;

class SvLog
{
    private $logger;
    public function __construct($handler)
    {
        $this->logger = new Logger('SolusVm');
        $this->pushHandler($handler);
    }

    public function pushHandler($handler)
    {
        if(is_string($handler))
        {
            $handler = new StreamHandler($handler,Logger::INFO);
        }
        $this->logger->pushHandler($handler);
    }

    public function log($action,$data)
    {
        if($action == 'status')
        {
            $status = $data['statusmsg'];
            if($status == 'online'){
                $this->logger->info("check server status({$status}):",$data);
            }else{
                $this->logger->error("check server status({$status}):",$data);
            }
        }else{
            $this->logger->notice("{$action} server:",$data);
        }
    }
}