<?php

namespace tests\unit;

use alexeevdv\yii\graylog\Publisher;
use Gelf\MessageValidatorInterface;
use Gelf\Transport\TransportInterface;
use yii\di\Instance;

class PublisherTest extends \Codeception\Test\Unit
{
    public function testInstanceEnsure()
    {
        $transports = [
            $this->makeEmpty(TransportInterface::class),
            $this->makeEmpty(TransportInterface::class),
            $this->makeEmpty(TransportInterface::class),
        ];
        $messageValidator = $this->makeEmpty(MessageValidatorInterface::class);
        /** @var Publisher $publisher */
        $publisher = Instance::ensure([
            'transports' => $transports,
            'messageValidator' => $messageValidator,
        ], Publisher::class);

        $this->assertEquals($messageValidator, $publisher->getMessageValidator());
        $this->assertCount(3, $publisher->getTransports());
    }
}
