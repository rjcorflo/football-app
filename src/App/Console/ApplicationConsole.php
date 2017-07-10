<?php

namespace USaq\App\Console;

use Consolidation\AnnotatedCommand\CommandFileDiscovery;
use Psr\Container\ContainerInterface;
use Robo\Application;
use Robo\Common\ConfigAwareTrait;
use Robo\Config\Config;
use Robo\Robo;
use Robo\Runner;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Application class for console.
 *
 * Use {@link http://robo.li Robo} as framework.
 */
class ApplicationConsole
{
    use ConfigAwareTrait;

    /**
     * @var Runner
     */
    private $runner;

    /**
     * Commands for the runner.
     *
     * @var array
     */
    private $commands = [];

    /**
     * ApplicationConsole constructor.
     *
     * @param Config $config
     * @param InputInterface|null $input
     * @param OutputInterface|null $output
     * @param ContainerInterface $applicationContainer
     */
    public function __construct(
        Config $config,
        InputInterface $input = null,
        OutputInterface $output = null,
        ContainerInterface $applicationContainer
    ) {
        // Create application.
        $this->setConfig($config);
        $application = new Application('My Application', $config->get('version'));

        // Create and configure container.
        $container = Robo::createDefaultContainer($input, $output, $application, $config);
        // Add container application using delegate lookup
        $container->delegate($applicationContainer);

        // Instantiate Robo Runner.
        $this->runner = new Runner();
        $this->runner->setContainer($container);

        // Add commands
        $this->registerCommands();
    }

    /**
     * Register all commands from src/App/Commands on application.
     */
    protected function registerCommands()
    {
        $discovery = new CommandFileDiscovery();
        $discovery->setSearchPattern('/.*Commands(s){0,1}.php/');
        $commandList = $discovery->discover('src/App/Console/Commands', '\USaq\App\Console\Commands');

        foreach ($commandList as $command) {
            $this->commands[] = $this->runner->getContainer()->get($command);
        }
    }

    /**
     * Launch application.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        $status_code = $this->runner->run($input, $output, null, $this->commands);
        return $status_code;
    }
}
