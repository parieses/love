<?php
namespace console\controllers;

require_once dirname(dirname(__DIR__)).'/websocket/Events.php';
use GatewayWorker\BusinessWorker;
use GatewayWorker\Gateway;
use GatewayWorker\Register;
use Workerman\Worker;
use yii\console\Controller;
use yii\helpers\Console;

/**
 *
 * @uses
 *      start: php yii workerman-web-socket -s start -d
 *      status: php yii workerman-web-socket -s status
 * Class WorkermanWebSocketController
 *
 * @package app\commands
 */
class WorkermanWebSocketController extends Controller
{
    public $send;
    public $daemon;
    public $gracefully;

    // 这里不需要设置，会读取配置文件中的配置
    public $config = [];
    private $ip = '127.0.0.1';
    private $wsPort = '7272';  //websocket port
    private $registerPort = '1236';//register port
    private $name = 'ChatGateway';
    private $gatewayCount = 4;
    private $gatewayStartPort = '2300';
    private $pingInterval = 10;
    private $pingData = '{"type":"ping"}';

    public function options($actionID)
    {
        return ['send', 'daemon', 'gracefully'];
    }

    public function optionAliases()
    {
        return [
            's' => 'send',
            'd' => 'daemon',
            'g' => 'gracefully',
        ];
    }

    //./yii workerman-web-socket -s start -d
    public function actionIndex()
    {
        if ('start' == $this->send) {
            try {
                $this->start($this->daemon);
            } catch (\Exception $e) {
                $this->stderr($e->getMessage() . "\n", Console::FG_RED);
            }
        } else if ('stop' == $this->send) {
            $this->stop();
        } else if ('restart' == $this->send) {
            $this->restart();
        } else if ('reload' == $this->send) {
            $this->reload();
        } else if ('status' == $this->send) {
            $this->status();
        } else if ('connections' == $this->send) {
            $this->connections();
        }
    }

    public function initWorker()
    {
        $ip = isset($this->config['ip']) ? $this->config['ip'] : $this->ip;
        $port = isset($this->config['wsPort']) ? $this->config['wsPort'] : $this->wsPort;
        $name = isset($this->config['name']) ? $this->config['name'] : $this->name;
        $gatewayCount = isset($this->config['gatewayCount']) ? $this->config['gatewayCount'] : $this->gatewayCount;
        $gatewayStartPort = isset($this->config['gatewayStartPort']) ? $this->config['gatewayStartPort'] : $this->gatewayStartPort;
        $pingInterval = isset($this->config['pingInterval']) ? $this->config['pingInterval'] : $this->pingInterval;
        $pingData = isset($this->config['pingData']) ? $this->config['pingData'] : $this->pingData;

        $registerPort = isset($this->config['registerPort']) ? $this->config['registerPort'] : $this->registerPort;

        /**
         * 先 register
         */
        // register 服务必须是text协议
        $register = new Register("text://0.0.0.0:{$registerPort}");

        /**
         * 再gateway
         */
        // gateway 进程
        $gateway = new Gateway("Websocket://0.0.0.0:{$port}");
        // 设置名称，方便status时查看
        $gateway->name = $name . 'Gateway';
        // 设置进程数，gateway进程数建议与cpu核数相同
        $gateway->count = $gatewayCount;
        // 分布式部署时请设置成内网ip（非127.0.0.1）
        $gateway->lanIp = "{$ip}";
        // 内部通讯起始端口。假如$gateway->count=4，起始端口为2300
        // 则一般会使用2300 2301 2302 2303 4个端口作为内部通讯端口
        $gateway->startPort = $gatewayStartPort;
        // 心跳间隔
        $gateway->pingInterval = $pingInterval;
        // 心跳数据
        $gateway->pingData = $pingData;
        // 服务注册地址
        $gateway->registerAddress = "{$ip}:{$registerPort}";

        /**
         * 最后business
         */
        // businessWorker 进程
        $worker = new BusinessWorker();
        // worker名称
        $worker->name = $name . 'BusinessWorker';
        // businessWorker进程数量
        $worker->count = $gatewayCount;
        // 服务注册地址
        $worker->registerAddress = "{$ip}:{$registerPort}";
        //处理消息的 相应的类
        $worker->eventHandler = 'websocket\Events';
    }

    /**
     * workman websocket start
     */
    public function start()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'start';
        if ($this->daemon) {
            $argv[2] = '-d';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket restart
     */
    public function restart()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'restart';
        if ($this->daemon) {
            $argv[2] = '-d';
        }

        if ($this->gracefully) {
            $argv[2] = '-g';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket stop
     */
    public function stop()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'stop';
        if ($this->gracefully) {
            $argv[2] = '-g';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket reload
     */
    public function reload()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'reload';
        if ($this->gracefully) {
            $argv[2] = '-g';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket status
     */
    public function status()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'status';
        if ($this->daemon) {
            $argv[2] = '-d';
        }

        // Run worker
        Worker::runAll();
    }

    /**
     * workman websocket connections
     */
    public function connections()
    {
        $this->initWorker();
        // 重置参数以匹配Worker
        global $argv;
        $argv[0] = $argv[1];
        $argv[1] = 'connections';

        // Run worker
        Worker::runAll();
    }

}
