<?php

namespace RJ\PronosticApp\WebResource\Fractal\Serializer;

use League\Fractal\Serializer\ArraySerializer;

class NoDataArraySerializer extends ArraySerializer
{
    /**
     * @inheritDoc
     */
    public function collection($resourceKey, array $data)
    {
        return $data;
    }
}
