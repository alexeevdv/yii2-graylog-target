# yii2-graylog-target

[![Build Status](https://github.com/alexeevdv/yii2-graylog-target/workflows/build/badge.svg)](https://github.com/alexeevdv/yii2-graylog-target/actions)
[![Total Downloads](https://poser.pugx.org/alexeevdv/yii2-graylog-target/downloads)](https://packagist.org/packages/alexeevdv/yii2-graylog-target)
![PHP 7.3](https://img.shields.io/badge/PHP-7.3-green.svg)
![PHP 8.0](https://img.shields.io/badge/PHP-8.0-green.svg)
![PHP 8.1](https://img.shields.io/badge/PHP-8.1-green.svg)
![PHP 8.2](https://img.shields.io/badge/PHP-8.2-green.svg)
![PHP 8.3](https://img.shields.io/badge/PHP-8.3-green.svg)
![PHP 8.4](https://img.shields.io/badge/PHP-8.4-green.svg)
![PHP 8.5](https://img.shields.io/badge/PHP-8.5-green.svg)

Yii2 graylog2 log target

## Installation

The preferred way to install this extension is through [composer](https://getcomposer.org/download/).

Either run

```bash
$ composer require alexeevdv/yii2-graylog-target
```

or add

```
"alexeevdv/yii2-graylog-target": "^0.2"
```

to the ```require``` section of your `composer.json` file.

## Configuration

```php

'components' => [
    'log' => [
        'targets' => [
            [
                'class' => alexeevdv\yii\graylog\Target::class,
                'publisher' => [
                    'class' => alexeevdv\yii\graylog\Publisher::class,
                    'categories' => ['application'],
                    'facility' => 'my-application',
                    'transports' => [
                        [
                            'class' => alexeevdv\yii\graylog\transport\UdpTransport::class,
                            'host' => '192.168.1.1',
                            'port' => 1234,
                            'chunkSize' => 4321,
                        ],
                        [
                            'class' => alexeevdv\yii\graylog\transport\TcpTransport::class,
                            'host' => '192.168.1.2',
                            'port' => 1234,
                            'sslOptions' => [
                                'allowSelfSigned' => true,
                                'verifyPeer' => false,
                            ],
                        ]
                    ],
                ],
            ],
        ],
    ],
],
```

## Transports

### UDP transport

```php
$transport = new alexeevdv\yii\graylog\transport\UdpTransport([
    // Host name or IP. Default to 127.0.0.1
    'host' => 'graylog.example.org',
    // UDP port. Default to 12201
    'port' => 1234,
    // UDP chunk size. Default to 8154
    'chunkSize' => 4321,
]);
```

### TCP transport

```php
$transport = new alexeevdv\yii\graylog\transport\TcpTransport([
    // Host name or IP. Default to 127.0.0.1
    'host' => 'graylog.example.org',
    // TCP port. Default to 12201
    'port' => 12201,
    // SSL options. (optional)
    'sslOptions' => [
        // Default to true
        'verifyPeer' => false,
        // Default to false
        'allowSelfSigned' => true,
        // Default to null
        'caFile' => '/path/to/ca.file',
        // Default to null
        'ciphers' => 'TLS_AES_256_GCM_SHA384:TLS_CHACHA20_POLY1305_SHA256:TLS_AES_128_GCM_SHA256',
    ],
]);
```

### HTTP transport

```php
$transport = new alexeevdv\yii\graylog\transport\HttpTransport([
    // Host name or IP. Default to 127.0.0.1
    'host' => 'graylog.example.org',
    // HTTP port. Default to 12202
    'port' => 12202,
    // Query path. Default to /gelf
    'path' => '/my/custom/greylog',
    // SSL options. (optional)
    'sslOptions' => [
        // Default to true
        'verifyPeer' => false,
        // Default to false
        'allowSelfSigned' => true,
        // Default to null
        'caFile' => '/path/to/ca.file',
        // Default to null
        'ciphers' => 'TLS_AES_256_GCM_SHA384:TLS_CHACHA20_POLY1305_SHA256:TLS_AES_128_GCM_SHA256',
    ],
]);
```
