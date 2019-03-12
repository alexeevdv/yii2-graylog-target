<?php

namespace alexeevdv\yii\graylog;

use Gelf\MessageValidatorInterface;
use Gelf\Publisher as GelfPublisher;
use Gelf\Transport\TransportInterface;
use Yii;
use yii\base\Configurable;
use yii\di\Instance;

class Publisher extends GelfPublisher implements Configurable
{
    /**
     * @var TransportInterface[]
     */
    public $transports = [];

    /**
     * @var MessageValidatorInterface
     */
    public $messageValidator = null;

    public function __construct($config = [])
    {
        if (!empty($config)) {
            Yii::configure($this, $config);
        }

        if ($this->messageValidator !== null) {
            $this->messageValidator = Instance::ensure($this->messageValidator, MessageValidatorInterface::class);
        }

        parent::__construct(null, $this->messageValidator);

        foreach ($this->transports as $transportConfig) {
            $this->addTransport(Instance::ensure($transportConfig, TransportInterface::class));
        }
    }
}
