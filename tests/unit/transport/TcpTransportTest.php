<?php

namespace tests\unit\transport;

use alexeevdv\yii\graylog\transport\TcpTransport;
use Gelf\Transport\SslOptions as GelfSslOptions;
use Gelf\Transport\TcpTransport as GelfTcpTransport;
use yii\di\Instance;

class TcpTransportTest extends \Codeception\Test\Unit
{
    public function testInstanceEnsure()
    {
        /** @var TcpTransport $transport */
        $transport = Instance::ensure([
            'host' => 'localhost',
            'port' => 1234,
            'sslOptions' => [
                'caFile' => 'ca_file',
            ],
        ], TcpTransport::class);
        $this->assertInstanceOf(GelfTcpTransport::class, $transport);
        $this->assertEquals('localhost', $transport->host);
        $this->assertEquals(1234, $transport->port);
        $this->assertInstanceOf(GelfSslOptions::class, $transport->sslOptions);
        $this->assertEquals('ca_file', $transport->sslOptions->getCaFile());
    }
}
