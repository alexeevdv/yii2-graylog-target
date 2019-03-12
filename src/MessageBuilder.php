<?php

namespace alexeevdv\yii\graylog;

use Exception;
use Gelf\Message;
use Psr\Log\LogLevel;
use yii\base\BaseObject;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;
use yii\log\Logger;

class MessageBuilder extends BaseObject implements MessageBuilderInterface
{
    public function build(Target $target, $message)
    {
        list($text, $level, $category, $timestamp) = $message;

        $gelfMessage = new \Gelf\Message;
        $gelfMessage
            ->setLevel($this->mapLogLevel($level))
            ->setTimestamp($timestamp)
            ->setFacility($target->facility)
            ->setAdditional('category', $category)
            ->setFile('unknown')
            ->setLine(0)
        ;

        if (is_string($text)) {
            $gelfMessage = $gelfMessage->setShortMessage($text);
        } elseif ($text instanceof Exception) {
            $gelfMessage = $this->fillMessageWithExceptionData($gelfMessage, $text);
        } else {
            $gelfMessage = $this->fillMessageWithArrayData($gelfMessage, $text);
        }

        if (isset($message[4]) && is_array($message[4])) {
            $gelfMessage = $this->fillMessageWithStackTrace($gelfMessage, $message[4]);
        }

        return $gelfMessage;
    }

    private function mapLogLevel($yiiLevel)
    {
        return ArrayHelper::getValue([
            Logger::LEVEL_TRACE => LogLevel::DEBUG,
            Logger::LEVEL_PROFILE_BEGIN => LogLevel::DEBUG,
            Logger::LEVEL_PROFILE_END => LogLevel::DEBUG,
            Logger::LEVEL_INFO => LogLevel::INFO,
            Logger::LEVEL_WARNING => LogLevel::WARNING,
            Logger::LEVEL_ERROR => LogLevel::ERROR,
        ], $yiiLevel, LogLevel::INFO);
    }

    private function fillMessageWithExceptionData(Message $message, Exception $exception)
    {
        $message->setShortMessage('Exception ' . get_class($exception) . ': ' . $exception->getMessage());
        $message->setFullMessage((string) $exception);
        $message->setLine($exception->getLine());
        $message->setFile($exception->getFile());
        return $message;
    }

    private function fillMessageWithArrayData(Message $message, array $array)
    {
        $short = ArrayHelper::remove($array, 'short');
        $full = ArrayHelper::remove($array, 'full');
        $additional = ArrayHelper::remove($array, 'additional');

        if ($short !== null) {
            $message->setShortMessage($short);
            $message->setFullMessage(VarDumper::dumpAsString($array));
        } else {
            $message->setShortMessage(VarDumper::dumpAsString($array));
        }

        if ($full !== null) {
            $message->setFullMessage(VarDumper::dumpAsString($full));
        }

        if (is_array($additional)) {
            foreach ($additional as $key => $val) {
                if (is_string($key)) {
                    if (!is_string($val)) {
                        $val = VarDumper::dumpAsString($val);
                    }
                    $message->setAdditional($key, $val);
                }
            }
        }
        return $message;
    }

    private function fillMessageWithStackTrace(Message $message, array $stacktrace)
    {
        $traces = [];
        foreach ($stacktrace as $index => $trace) {
            $traces[] = "{$trace['file']}:{$trace['line']}";
            if ($index === 0) {
                $message->setFile($trace['file']);
                $message->setLine($trace['line']);
            }
        }
        $message->setAdditional('trace', implode("\n", $traces));

        return $message;
    }
}
