<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Util\MessageResult;

class MessageResultTransformer extends TransformerAbstract
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