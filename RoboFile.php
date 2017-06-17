<?php

use Symfony\Component\Console\Input\InputOption;

/**
 * This is project's console commands configuration for Robo task runner.
 *
 * @see http://robo.li/
 */
class RoboFile extends \Robo\Tasks
{
    use \RJ\Robo\Task\Rocketeer\loadTasks;

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
     * Publish on master on Github.
     *
     * @option $release Pass major, minor or patch to submit a tag.
     */
    public function productionPublish(
        $options = ['release' => InputOption::VALUE_REQUIRED]
    ) {
        if ($options['release']) {
            $releaseType = $options['release'];
            if ($releaseType !== 'major' && $releaseType !== 'minor' && $releaseType !== 'patch') {
                $this->say('Version must be major, minor or patch');
                return;
            }
        }

        /**
         * @var \Robo\Collection\CollectionBuilder $collection
         */
        $collection = $this->collectionBuilder();

        $this->stopOnFail(true);

        if ($options['release']) {
            $this->say("Releasing application ...");
        } else {
            $this->say('Publishing application on GitHub ... ');
        }

        $collection
            ->addTask($this->taskGitStack()
                ->checkout('master')
                // Merge with dev using theirs on conflicts
                ->merge('--X theirs development'))
            ->addTask($this->taskGitStack()
                ->add('-A')
                ->commit("[MASTER] Auto-update")
                ->pull()
                ->push())
            ->addTask($this->taskGitStack()->pull())
            ->run();

        if ($options['release']) {
            $file = __DIR__ . '/.semver';
            $this->taskSemVer($file)
                ->increment($options['release'])
                ->run();

            $release = $this->taskSemVer($file)->__toString();

            $this->taskGitStack()
                ->tag($release)
                ->push('origin', $release)
                ->run();

            $this->say("Completed publication of release $release.");
        } else {
            $this->say('Publish completed.');
        }
    }

    /**
     * Deploy application.
     *
     * @option $on Connections
     * @option $stage Stages
     */
    public function productionDeploy(
        $options = ['release' => null, 'on' => 'production', 'stage' => 'test']
    ) {
        if (!is_string($options['on']) || !is_string($options['stage'])) {
            $this->say('Options on and stage must be strings.');
            return;
        }

        if ($options['release']) {
            $releaseType = $options['release'];
            if ($releaseType !== 'major' && $releaseType !== 'minor' && $releaseType !== 'patch') {
                $this->say('Version must be major, minor or patch');
                return;
            }

            $this->productionPublish(['release' => $releaseType]);
        }

        $this->taskRocketeerDeploy()
            ->on($options['on'])
            ->stages($options['stage'])
            ->run();
    }
}
