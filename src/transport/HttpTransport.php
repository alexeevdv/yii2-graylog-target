<?php

namespace alexeevdv\yii\graylog\transport;

use Gelf\Transport\HttpTransport as GelfHttpTransport;
use Yii;
use yii\base\Configurable;
use yii\di\Instance;

class HttpTransport extends GelfHttpTransport implements Configurable
{
    public $host = GelfHttpTransport::DEFAULT_HOST;

    public $port = GelfHttpTransport::DEFAULT_PORT;

    public $path = GelfHttpTransport::DEFAULT_PATH;

    /**
     * @var SslOptions
     */
    public $sslOptions = null;

    // TODO authentication
    // TODO proxy
    // TODO create from url

    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
        $this->init();
        parent::__construct($this->host, $this->port, $this->path, $this->sslOptions);
    }

    public function init()
    {
        if ($this->sslOptions !== null) {
            $this->sslOptions = Instance::ensure($this->sslOptions, SslOptions::class);
        }
    }
}
