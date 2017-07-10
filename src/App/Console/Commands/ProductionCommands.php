<?php

namespace RJ\PronosticApp\App\Console\Commands;

use Robo\Tasks;

class ProductionCommands extends Tasks
{
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