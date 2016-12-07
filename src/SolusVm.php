<?php

namespace Jaeger;

use GuzzleHttp\Client;


class SolusVm
{
    private $config = [
        'server_api_url' => 'http://xxx.com/api/client/command.php',
        'key' => '',
        'hash' => '',
        'log' => './log/vm.log'
    ];

    private $http;
    private $logger;

    public function __construct($config)
    {
        $this->config = $config;

        $this->http = new Client();

    }

    public function action($action)
    {
        $response = $this->http->request('POST',$this->config['server_api_url'],[
            'form_params' => [
                'key' => $this->config['key'],
                'hash' => $this->config['hash'],
                'action' => $action
            ]
        ]);
        $rt = $this->string2array((string)$response->getBody());
        $this->log($action,$rt);
        return $rt;
    }

    /**
     * 重启
     * @return array
     */
    public function reboot()
    {
        return $this->action('reboot');
    }

    /**
     * 关机
     * @return array
     */
    public function shutdown()
    {
        return $this->action('shutdown');
    }

    /**
     * 开机
     * @return array
     */
    public function boot()
    {
        return $this->action('boot');
    }

    /**
     * 查看状态
     * @return array
     */
    public function status()
    {
        return $this->action('status');
    }

    /**
     * 关机然后启动
     * @return array
     */
    public function shutdownAndBoot()
    {
        $this->shutdown();
        return $this->boot();
    }

    /**
     * 检查主机是否宕机，如果宕机则重启主机
     */
    public function checkAndReboot()
    {
        $rt = $this->status();
        if($rt['statusmsg'] != 'online'){
            $this->shutdownAndBoot();
        }
    }

    private function log($action,$data)
    {
        if(!empty($this->config['log']))
        {
            if(empty($this->logger))
            {
                $this->logger = new SvLog($this->config['log']);
            }
            $this->logger->log($action,$data);
        }
    }

    private function string2array($xml)
    {
        preg_match_all('/<(.*?)>([^<]+)<\/\\1>/i', $xml, $match);
        $result = array();
        foreach ($match[1] as $x => $y)
        {
            $result[$y] = $match[2][$x];
        }
        return $result;
    }
}