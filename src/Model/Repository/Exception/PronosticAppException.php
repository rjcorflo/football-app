<?php

namespace RJ\PronosticApp\Model\Repository\Exception;

use RJ\PronosticApp\Util\General\ErrorCodes;
use RJ\PronosticApp\Util\General\MessageResult;

/**
 * Base exception class PronosticAppException
 * @package RJ\PronosticApp\Model\Repository\Exception
 */
abstract class PronosticAppException extends \Exception
{
    protected $messages = [];

    /**
     * @param int $code
     * @param null|string $observations
     */
    public function addMessageWithCode(int $code, ?string $observations) : void
    {
        $message['code'] = $code;
        $message['obs'] = $observations;

        $this->messages[] = $message;
    }

    /**
     * @param null|string $observations
     */
    public function addDefaultMessage(?string $observations) : void
    {
        $message['code'] = ErrorCodes::DEFAULT;
        $message['obs'] = $observations;

        $this->messages[] = $message;
    }

    /**
     * @return array
     */
    public function getMessages() : array
    {
        return $this->messages;
    }

    /**
     * @return MessageResult
     */
    public function convertToMessageResult() : MessageResult
    {
        $result = new MessageResult();
        $result->isError();
        $result->setDescription($this->getMessage());

        foreach ($this->messages as $message) {
            $result->addMessageWithCode($message['code'], $message['obs']);
        }

        return $result;
    }
}
