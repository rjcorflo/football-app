<?php

namespace RJ\PronosticApp\Aspect;

use Go\Aop\Aspect;
use Go\Aop\Intercept\MethodInvocation;
use Psr\Log\LoggerInterface;
use Go\Lang\Annotation\Before;
use Go\Lang\Annotation\After;

class LoggerAspect implements Aspect
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * @Before("@execution(RJ\FootballApp\Aspect\Annotation\Logger)")
     */
    public function logBeforeMethod(MethodInvocation $invocation)
    {
        $this->logger->error('ANTES -Mensaje de entrada' . $invocation->getMethod());
    }

    /**
     * @After("@execution(RJ\FootballApp\Aspect\Annotation\Logger)")
     */
    public function logAfterMethod(MethodInvocation $invocation)
    {
        $this->logger->error('DESPUES -Mensaje de entrada' . $invocation->getMethod());
    }
}
