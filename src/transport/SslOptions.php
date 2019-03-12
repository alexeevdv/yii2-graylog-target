<?php

namespace alexeevdv\yii\graylog\transport;

use Gelf\Transport\SslOptions as GelfSslOptions;
use Yii;
use yii\base\Configurable;

class SslOptions extends GelfSslOptions implements Configurable
{
    public $verifyPeer = true;

    public $allowSelfSigned = false;

    public $caFile = null;

    public $ciphers = null;

    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }
    }
}
