<?php

namespace RJ\PronosticApp\Util\General;

class MessageResult
{
    const DEFAULT = 0;
    const INVALID_MAIL = 1;
    const INVALID_USERNAME = 2;

    protected $error = false;

    protected $description = "";

    /**
     * @var MessageItem[]
     */
    protected $messages = [];

    public function setError(bool $error)
    {
        $this->error = $error;
    }

    public function isError() : void
    {
        $this->error = true;
    }

    public function hasError() : bool
    {
        return $this->error;
    }

    public function setDescription(string $description) : void
    {
        $this->description = $description;
    }

    public function getDescription() : string
    {
        return $this->description;
    }

    public function addMessage(MessageItem $message) : void
    {
        $this->messages[] = $message;
    }

    public function addMessageWithCode(int $code, ?string $observations) : void
    {
        $message = new MessageItem();
        $message->setCode($code);
        $message->setObservation($observations);

        $this->messages[] = $message;
    }

    /**
     * @return MessageItem[]
     */
    public function getMessages() : array
    {
        return $this->messages;
    }
}
