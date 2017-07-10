<?php

namespace RJ\PronosticApp\App\Console\Commands;

use Robo\Tasks;
use Symfony\Component\Console\Input\InputOption;

/**
 * Provide development commands.
 */
class DevelopmentCommands extends Tasks
{
    /**
     * Launch php-cs-fixer for source files.
     *
     * @param string $directory     Directory with files to be processed.
     */
    public function developmentFix($directory = 'src')
    {
        $this->taskExec('php-cs-fixer fix')->arg($directory)->run();
    }

    /**
     * Launch application tests.
     */
    public function developmentTest()
    {
        $this->taskCodecept()->run();
    }

    /**
     * Prepare project for development.
     */
    public function developInit()
    {
        /**
         * @var \Robo\Collection\CollectionBuilder $collection
         */
        $collection = $this->collectionBuilder();

        $collection->addTask($this->taskGitStack()->checkout('development'))
            ->addTask($this->taskComposerUpdate())
            ->addTask($this->taskBowerUpdate())
            ->run();
    }

    /**
     * Launch development environment, php server and watchers.
     */
    public function developStart()
    {
        $this->taskServer()->dir('public')
            ->background()
            ->run();

        $this->taskWatch()
            ->monitor('composer.json', function () {
                $this->taskComposerUpdate()->run();
            })
            ->run();
    }

    /**
     * Run test and push code to develop branch.
     *
     * @param string $commitMesage Commit message.
     * @option $add Options for add command.
     */
    public function developPublish(
        $commitMesage = 'Auto commit',
        $options = ['add|a' => InputOption::VALUE_REQUIRED]
    ) {
        $this->stopOnFail();

        $this->taskCodecept()->run();

        $task = $this->taskGitStack();

        if ($options['add']) {
            $task->add($options['add'])
                ->commit($commitMesage);
        }

        $task->push()
            ->run();
    }

    /**
     * Test application.
     */
    public function test()
    {
        $this->taskCodecept()->coverageHtml()->run();
    }

    /**
     * Deploy application.
     *
     * @param array $options
     * @option $no-tests        Don't launch tests before deploy.
     */
    public function developmentDeploy($options = ['no-tests' => false])
    {
        $tasks = [];

        if (!$options['no-tests']) {
            $tasks[] = $this->taskCodecept();
        }

        $tasks[] = $this->taskExec('dep')->dir('vendor/bin')->arg('deploy')->arg('development');

        $builder = $this->collectionBuilder();
        $builder->addTaskList($tasks)->run();
    }
}
