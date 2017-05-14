<?php

namespace RJ\PronosticApp\Aspect;

use Go\Core\AspectContainer;
use Go\Core\AspectKernel;
use Psr\Container\ContainerInterface;

class ApplicationAspect extends AspectKernel
{
    /**
     * @var ContainerInterface
     */
    private $containerInterface;

    public function setContainer(ContainerInterface $containerInterface)
    {
        $this->containerInterface = $containerInterface;
    }

    protected function configureAop(AspectContainer $container)
    {
        foreach ($this->containerInterface->get('aop.aspects') as $aspects) {
            $container->registerAspect($aspects);
        }
    }
}
