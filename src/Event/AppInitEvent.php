<?php

namespace RJ\PronosticApp\Event;

use Symfony\Component\EventDispatcher\Event;

class AppInitEvent extends Event
{
    const NAME = 'app.initialized';
}
