<?php

namespace alexeevdv\yii\graylog\transport;

use Gelf\Transport\UdpTransport as GelfUdpTransport;
use Yii;
use yii\base\Configurable;

class UdpTransport extends GelfUdpTransport implements Configurable
{
    public $host = GelfUdpTransport::DEFAULT_HOST;

    public $port = GelfUdpTransport::DEFAULT_PORT;

    public $chunkSize = GelfUdpTransport::CHUNK_SIZE_LAN;

    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        parent::__construct($this->host, $this->port, $this->chunkSize);
    }
}
