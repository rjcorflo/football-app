<?php

namespace RJ\PronosticApp\Persistence\PersistenceRedBean\Util;

use RedBeanPHP\SimpleModel;

class RedBeanUtils
{
    /**
     * @param SimpleModel[] $beans Beans from database.
     * @return array Models associated to beans retrieved.
     */
    public static function boxArray(array $beans) : array
    {
        $models = [];

        foreach ($beans as $bean) {
            $models[] = $bean->box();
        }

        return $models;
    }
}
