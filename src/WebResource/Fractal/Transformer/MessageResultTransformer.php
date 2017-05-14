<?php

namespace WebResource\Fractal\Transformer;

use Util\MessageResult;

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