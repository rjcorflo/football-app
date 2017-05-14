<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use RJ\PronosticApp\Util\MessageResult;

class MessageResultTransformer
{
    public function transform(MessageResult $messageResult)
    {
        return [
            'error'      => (bool) $messageResult->hasError(),
            'descripcion'   => $messageResult->getDescription(),
            'mensajes'    => $messageResult->getMessages()
        ];
    }
}