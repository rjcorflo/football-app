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
        /*$this->taskGitStack()
            ->checkout('development')
            ->pull()
            ->run();*/

        $this->taskServer()->dir('public')
            ->background()
            ->run();

        $this->taskWatch()
            ->monitor('composer.json', function () {
                $this->taskComposerUpdate()->run();
            })
            ->monitor('assets/stylesheets/scss', function () {
                $this->assetsCompileScss();
            })
            ->monitor('assets/scripts', function () {
                $this->assetsCompileScripts();
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
     * Compile bower and support libraries.
     *
     * @option $minify Minify output.
     */
    public function assetsCompileLibraries($options = ['minify|m' => false])
    {
        /**
         * @var \Robo\Collection\CollectionBuilder $collection
         */
        $collection = $this->collectionBuilder();

        $dir = $collection->workDir('public/external-assets');

        $collection->addTask($this->taskConcat([
            'bower_components/jquery/dist/jquery.min.js',
            'bower_components/webix/codebase/webix.js',
        ])->to("$dir/libs.js"));

        if ($options["minify"]) {
            $collection->completion($this->taskMinify("public/external-assets/libs.js")
                ->to("public/external-assets/libs.js"));
        }

        $collection->addTask(
            $this->taskConcat([
                'bower_components/webix/codebase/webix.css'
            ])->to("$dir/libs.css")
        );

        if ($options["minify"]) {
            $collection->completion($this->taskMinify("public/external-assets/libs.css")
                ->to("public/external-assets/libs.css"));
        }

        $collection->run();
    }

    /**
     * Copy scripts libraries to public folder and concat them.
     *
     * @option $minify Minify output.
     */
    public function assetsCompileScripts($options = ['minify|m' => false])
    {
        /**
         * @var \Robo\Collection\CollectionBuilder $collection
         */
        $collection = $this->collectionBuilder();

        $dir = $collection->workDir('public/scripts');

        $collection->addTask($this->taskConcat([
            'assets/scripts/app.js'
        ])->to("$dir/app.js"));

        if ($options["minify"]) {
            $collection->completion($this->taskMinify("public/scripts/app.js")
                ->to("public/scripts/app.js"));
        }

        $collection->run();
    }

    /**
     * Compile scss files to public folder.
     *
     * @option $minify Minify output.
     */
    public function assetsCompileScss($options = ['minify|m' => false])
    {
        /**
         * @var \Robo\Collection\CollectionBuilder $collection
         */
        $collection = $this->collectionBuilder();

        $dir = $collection->workDir('public/stylesheets');

        $collection->addTask($this->taskScss(['assets/stylesheets/scss/app.scss' => "$dir/app.css"])
            ->importDir('assets/stylesheets/scss'));

        if ($options["minify"]) {
            $collection->completion($this->taskMinify("public/stylesheets/app.css")
                ->to("public/stylesheets/app.css"));
        }

        $collection->run();
    }

    /**
     * Compile all assets to public folder.
     *
     * @option $minify Minify output.
     */
    public function assetsCompileAll($options = ['minify|m' => false])
    {
        $this->assetsCompileLibraries($options);
        $this->assetsCompileScripts($options);
        $this->assetsCompileScss($options);
    }

    /**
     * Compile all application's assets to public folder.
     *
     * @option $minify Minify output.
     */
    public function assetsCompileApp($options = ['minify|m' => false])
    {
        $this->assetsCompileScripts($options);
        $this->assetsCompileScss($options);
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
            ->addCode(function () {
                $this->assetsCompileAll(['minify' => true]);
            })
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
