<?php

namespace RJ\PronosticApp\Util\General;

class MessageResult
{
    protected $error = false;

    protected $description = "";

    /**
     * @var string[]
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

    public function addMessage(string $message) : void
    {
        $this->messages[] = $message;
    }

    public function getMessages() : array
    {
        return $this->messages;
    }
}
