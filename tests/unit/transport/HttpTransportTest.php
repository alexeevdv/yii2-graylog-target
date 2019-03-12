<?php

namespace tests\unit\transport;

use alexeevdv\yii\graylog\transport\HttpTransport;
use Gelf\Transport\HttpTransport as GelfHttpTransport;
use Gelf\Transport\SslOptions as GelfSslOptions;
use yii\di\Instance;

class HttpTransportTest extends \Codeception\Test\Unit
{
    public function testInstanceEnsure()
    {
        /** @var HttpTransport $transport */
        $transport = Instance::ensure([
            'host' => 'localhost',
            'port' => 1234,
            'path' => '/path',
            'sslOptions' => [
                'caFile' => 'ca_file',
            ],
        ], HttpTransport::class);
        $this->assertInstanceOf(GelfHttpTransport::class, $transport);
        $this->assertEquals('localhost', $transport->host);
        $this->assertEquals(1234, $transport->port);
        $this->assertEquals('/path', $transport->path);
        $this->assertInstanceOf(GelfSslOptions::class, $transport->sslOptions);
        $this->assertEquals('ca_file', $transport->sslOptions->getCaFile());
    }
}
