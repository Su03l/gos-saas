<?php

namespace Deployer;

require 'recipe/laravel.php';

// Project name
set('application', 'governance-saas');

// Project repository
set('repository', 'https://github.com/Su03l/gos-saas.git');

// [Optional] Allocate tty for git clone. Default value is false.
set('git_tty', true); 

// Shared files/dirs between deploys 
add('shared_files', ['.env']);
add('shared_dirs', ['storage', 'bootstrap/cache']);

// Writable dirs by web server 
add('writable_dirs', [
    'bootstrap/cache',
    'storage',
    'storage/app',
    'storage/app/public',
    'storage/framework',
    'storage/framework/cache',
    'storage/framework/sessions',
    'storage/framework/views',
    'storage/logs',
]);

// Hosts
host('production.governance-saas.com')
    ->set('deploy_path', '/var/www/{{application}}')
    ->set('branch', 'main')
    ->set('remote_user', 'deployer');

// Tasks
task('build', function () {
    run('cd {{release_path}} && npm install && npm run build');
});

desc('Deploy your project');
task('deploy', [
    'deploy:info',
    'deploy:prepare',
    'deploy:lock',
    'deploy:release',
    'deploy:update_code',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:copy_dirs',
    'artisan:storage:link',
    'artisan:migrate',
    'artisan:config:cache',
    'artisan:route:cache',
    'artisan:view:cache',
    'build',
    'deploy:symlink',
    'deploy:unlock',
    'cleanup',
]);

// [Optional] if deploy fails automatically unlock.
after('deploy:failed', 'deploy:unlock');
