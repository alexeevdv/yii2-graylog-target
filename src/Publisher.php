<?php

namespace alexeevdv\yii\graylog;

use Gelf\MessageValidatorInterface;
use Gelf\Publisher as GelfPublisher;
use Gelf\Transport\TransportInterface;
use Yii;
use yii\base\Configurable;
use yii\di\Instance;
use yii\helpers\ArrayHelper;

class Publisher extends GelfPublisher implements Configurable
{
    /**
     * @var MessageValidatorInterface
     */
    public $messageValidator = null;

    public function __construct($config = [])
    {
        $transportConfigs = ArrayHelper::remove($config, 'transports', []);

        if (!empty($config)) {
            Yii::configure($this, $config);
        }

        if ($this->messageValidator !== null) {
            $this->messageValidator = Instance::ensure($this->messageValidator, MessageValidatorInterface::class);
        }

        parent::__construct(null, $this->messageValidator);

        foreach ($transportConfigs as $transportConfig) {
            $this->addTransport(Instance::ensure($transportConfig, TransportInterface::class));
        }
    }
}
