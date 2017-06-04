<?php

namespace RJ\PronosticApp\WebResource\Fractal\Transformer;

use League\Fractal\TransformerAbstract;
use RJ\PronosticApp\Util\General\MessageItem;
use RJ\PronosticApp\Util\General\MessageResult;

/**
 * Class MessageResultTransformer
 * @package RJ\PronosticApp\WebResource\Fractal\Transformer
 */
class MessageResultTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'mensajes'
    ];

    /**
     * @param MessageResult $messageResult
     * @return array
     */
    public function transform(MessageResult $messageResult)
    {
        return [
            'error'      => (bool) $messageResult->hasError(),
            'descripcion'   => $messageResult->getDescription()
        ];
    }

    /**
     * Include messages.
     *
     * @param MessageResult $message
     * @return \League\Fractal\Resource\Collection
     */
    public function includeMensajes(MessageResult $message)
    {
        $items = $message->getMessages();

        return $this->collection($items, function (MessageItem $item) {
            return [
                'code' => $item->getCode(),
                'obs' => $item->getObservation()
            ];
        });
    }
}
