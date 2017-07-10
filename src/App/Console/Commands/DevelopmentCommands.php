<?php

namespace USaq\App\Console\Commands;

use Robo\Tasks;

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
