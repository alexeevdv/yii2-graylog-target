<?php

namespace alexeevdv\yii\graylog\transport;

use Gelf\Transport\TcpTransport as GelfTcpTransport;
use Yii;
use yii\base\Configurable;
use yii\di\Instance;

class TcpTransport extends GelfTcpTransport implements Configurable
{
    public $host = GelfTcpTransport::DEFAULT_HOST;

    public $port = GelfTcpTransport::DEFAULT_PORT;

    // TODO specify timeout

    /**
     * @var SslOptions
     */
    public $sslOptions = null;

    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        $this->init();
        parent::__construct($this->host, $this->port, $this->sslOptions);
    }

    public function init()
    {
        if ($this->sslOptions !== null) {
            $this->sslOptions = Instance::ensure($this->sslOptions, SslOptions::class);
        }
    }
}
