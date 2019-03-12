<?php

namespace tests\unit\transport;

use alexeevdv\yii\graylog\transport\SslOptions;
use Gelf\Transport\SslOptions as GelfSslOptions;
use yii\di\Instance;

class SslOptionsTest extends \Codeception\Test\Unit
{
    public function testInstanceEnsure()
    {
        /** @var SslOptions $sslOptions */
        $sslOptions = Instance::ensure([
            'verifyPeer' => false,
            'allowSelfSigned' => true,
            'caFile' => 'ca_file',
            'ciphers' => 'SHA512',
        ], SslOptions::class);

        $this->assertInstanceOf(GelfSslOptions::class, $sslOptions);
        $this->assertEquals(false, $sslOptions->getVerifyPeer());
        $this->assertEquals(true, $sslOptions->getAllowSelfSigned());
        $this->assertEquals('ca_file', $sslOptions->getCaFile());
        $this->assertEquals('SHA512', $sslOptions->getCiphers());
    }
}
