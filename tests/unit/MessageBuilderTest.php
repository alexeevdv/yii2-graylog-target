<?php

namespace tests\unit;

use alexeevdv\yii\graylog\MessageBuilder;
use alexeevdv\yii\graylog\Target;
use Exception;
use yii\log\Logger;

class MessageBuilderTest extends \Codeception\Test\Unit
{
    public function testBuildSimpleStringMessage()
    {
        $builder = new MessageBuilder;
        $gelfMessage = $builder->build($this->make(Target::class), [
            'Text message',
            Logger::LEVEL_ERROR,
            'application',
            1552400424,
        ]);
        $this->assertArraySubset([
            'short_message' => 'Text message',
            'level' => 3,
            'timestamp' => 1552400424.0,
            'facility' => 'yii2',
            'file' => 'unknown',
            'line' => 0,
            '_category' => 'application',
        ], $gelfMessage->toArray());
    }

    public function testBuildExceptionMessage()
    {
        $exception = new Exception('Kaboom');
        $builder = new MessageBuilder;
        $gelfMessage = $builder->build($this->make(Target::class), [
            $exception,
            Logger::LEVEL_WARNING,
            'application',
            1552400424,
        ]);

        $this->assertArraySubset([
            'short_message' => 'Exception Exception: Kaboom',
            'level' => 4,
            'timestamp' => 1552400424.0,
            'facility' => 'yii2',
            'file' => __FILE__,
            'line' => 34,
            '_category' => 'application',
        ], $gelfMessage->toArray());
    }

    public function testBuildSimpleTextWithStackTrace()
    {
        $builder = new MessageBuilder;
        $gelfMessage = $builder->build($this->make(Target::class), [
            'Text message',
            Logger::LEVEL_INFO,
            'application',
            1552400424,
            [
                ['file' => 'file1', 'line' => 12],
                ['file' => 'file2', 'line' => 33],
            ]
        ]);
        $this->assertArraySubset([
            'short_message' => 'Text message',
            'level' => 6,
            'timestamp' => 1552400424.0,
            'facility' => 'yii2',
            'file' => 'file1',
            'line' => 12,
            '_category' => 'application',
        ], $gelfMessage->toArray());
    }

    public function testBuildArray()
    {
        $builder = new MessageBuilder;
        $gelfMessage = $builder->build($this->make(Target::class), [
            [
                'short' => 'Short message',
                'full' => 'Full message',
                'additional' => [
                    'field1' => 'value1',
                    'field2' => [0, 1, 2]
                ],
            ],
            Logger::LEVEL_TRACE,
            'application',
            1552400424,
        ]);
        $this->assertArraySubset([
            'short_message' => 'Short message',
            'level' => 7,
            'timestamp' => 1552400424.0,
            'facility' => 'yii2',
            'file' => 'unknown',
            'line' => 0,
            '_category' => 'application',
        ], $gelfMessage->toArray());
    }

    public function testBuildGenericArray()
    {
        $builder = new MessageBuilder;
        $gelfMessage = $builder->build($this->make(Target::class), [
            [
                'First',
                'Second'
            ],
            Logger::LEVEL_PROFILE,
            'application',
            1552400424,
        ]);

        $this->assertArraySubset([
            'level' => 7,
            'timestamp' => 1552400424.0,
            'facility' => 'yii2',
            'file' => 'unknown',
            'line' => 0,
            '_category' => 'application',
        ], $gelfMessage->toArray());
    }
}
