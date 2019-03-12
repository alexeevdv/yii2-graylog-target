<?php

namespace tests\unit\transport;

use alexeevdv\yii\graylog\transport\UdpTransport;
use Gelf\Transport\UdpTransport as GelfUdpTransport;
use yii\di\Instance;

class UdpTransportTest extends \Codeception\Test\Unit
{
    public function testInstanceEnsure()
    {
        /** @var UdpTransport $transport */
        $transport = Instance::ensure([
            'host' => '127.0.1.1',
            'port' => 1234,
            'chunkSize' => 321,
        ], UdpTransport::class);

        $this->assertInstanceOf(GelfUdpTransport::class, $transport);
        $this->assertEquals('127.0.1.1', $transport->host);
        $this->assertEquals(1234, $transport->port);
        $this->assertEquals(321, $transport->chunkSize);
    }
}
