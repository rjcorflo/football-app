<?php

namespace RJ\PronosticApp\App\Console\Commands;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Tools\Console\Command\MappingDescribeCommand;
use Doctrine\ORM\Tools\Console\ConsoleRunner;
use Robo\Robo;
use Robo\Tasks;

/**
 * Test commands.
 */
class TestCommands extends Tasks
{
    /**
     * Testing console.
     *
     * @param string $name      Provide a name.
     * @param array $options
     * @option $yell            Yell the name!
     */
    public function testSay($name, $options = ['yell|y' => false])
    {
        $this->io()->title('Testing application');

        $message = 'Hello, ' . $name;

        if ($options['yell']) {
            $message = strtoupper($message);
        }

        $this->io()->text($message);
    }

    /**
     * Describe mapping of entity.
     *
     * @param string $entityName    Entity name.
     */
    public function testDescribe($entityName)
    {
        /** @var EntityManager $em */
        $em = Robo::getContainer()->get('persistence');

        $helper = ConsoleRunner::createHelperSet($em);

        $command = new MappingDescribeCommand();
        $command->setHelperSet($helper);
        $this->taskSymfonyCommand($command)->arg('entityName', $entityName)->run();
    }
}
