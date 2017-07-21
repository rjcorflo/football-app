<?php
namespace Deployer;

require 'recipe/symfony3.php';

// Configuration
// Repository
set('repository', 'https://github.com/rjcorflo/pronosticapp.git');
set('git_tty', false); // [Optional] Allocate tty for git on first deployment

// Environment vars
set('env_vars', 'APP_ENV={{env}}');
set('shared_files', []);

// Hosts
host('solus-dev')
    ->hostname('solus')
    ->stage('development')
    ->roles('app')
    ->set('deploy_path', '~/applications/pronosticapp/development')
    ->set('branch', 'dev-doctrine')
    ->configFile('~/.ssh/config');


// Tasks
desc('Restart PHP-FPM service');
task('php-fpm:restart', function () {
    // The user must have rights for restart service
    // /etc/sudoers: username ALL=NOPASSWD:/bin/systemctl restart php-fpm.service
    run('sudo systemctl restart php-fpm.service');
});
//after('deploy:symlink', 'php-fpm:restart');

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');