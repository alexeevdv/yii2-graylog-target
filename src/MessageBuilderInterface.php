<?php

namespace alexeevdv\yii\graylog;

use Gelf\Message;

/**
 * Interface MessageBuilderInterface
 * @package alexeevdv\yii\graylog
 */
interface MessageBuilderInterface
{
    /**
     * @param Target $target
     * @param array $message
     * @return Message
     */
    public function build(Target $target, $message);
}
