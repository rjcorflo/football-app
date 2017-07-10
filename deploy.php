<?php
namespace Deployer;

require 'recipe/common.php';

// Configuration
// Repository
set('repository', 'https://github.com/rjcorflo/pronosticapp.git');
set('git_tty', false); // [Optional] Allocate tty for git on first deployment

// Dirs
set('shared_dirs', [
    'logs',
    'storage'
]);

set('shared_files', [
    '.env',
]);

set('writable_dirs', []);


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

desc('Deploy your project');
task('deploy', [
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:clear_paths',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
    'success'
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');