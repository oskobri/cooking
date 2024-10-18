<?php
namespace Deployer;

require 'recipe/laravel.php';

// Config

set('repository', 'git@github.com:oskobri/cooking.git');

add('shared_files', [
    'database/database.sqlite',
]);
add('shared_dirs', []);
add('writable_dirs', []);

// Hosts

host('papille')
    ->set('remote_user', 'deployer')
    ->set('deploy_path', '/var/www/api.papille.app');

// Hooks

after('deploy:failed', 'deploy:unlock');
