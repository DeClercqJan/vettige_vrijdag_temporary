<?php

namespace Deployer;

require 'recipe/symfony4.php';
require 'recipe/cachetool.php';
require 'recipe/sentry.php';
require __DIR__ . '/vendor/tijsverkoyen/deployer-sumo/sumo.php';

// Define some variables
set('client', 'jan');
set('project', 'vettigevrijdag');
set('repository', 'git@git.sumocoders.be:vettige-vrijdag/jan-de-clercq.git');
set('production_url', 'app.wasewind.be');

// Define staging
host('dev02.sumocoders.eu')
    ->user('sites')
    ->stage('staging')
    ->set('deploy_path', '~/apps/{{client}}/{{project}}')
    ->set('branch', 'frontend')
    ->set('bin/php', 'php7.4')
    ->set('cachetool', '/var/run/php_74_fpm_sites.sock')
    ->set('document_root', '~/php74/{{client}}/{{project}}/current/public');


// Define production
//host('$host')
//    ->user('sites')
//    ->stage('production')
//    ->set('deploy_path', '~/apps/{{client}}/{{project}}')
//    ->set('branch', 'master')
//    ->set('bin/php', '$phpBinary')
//    ->set('cachetool', '$socketPath')
//    ->set('document_root', '~/php72/{{client}}/{{project}}');

/*************************
 * No need to edit below *
 *************************/

set('use_relative_symlink', false);

// Shared files/dirs between deploys
add('shared_files', ['.env.local']);
add('shared_dirs', ['/public/uploads/images', '/public/uploads/icons']);

// Writable dirs by web server
add('writable_dirs', []);

// Disallow stats
set('allow_anonymous_stats', false);

// Sentry
set(
    'sentry',
    [
        'organization' => get('sentry_organization'),
        'projects' => [
            get('sentry_project_slug'),
        ],
        'token' => get('sentry_token')
    ]
);

/*****************
 * Task sections *
 *****************/
// Build tasks
task(
    'build:assets:npm',
    function () {
        run('npm run build');
    }
)
    ->desc('Run the build script which will build our needed assets.')
    ->local();

// Upload tasks
task(
    'upload:assets',
    function () {
        upload(__DIR__ . '/public/build', '{{release_path}}/public');
    }
)
    ->desc('Uploads the assets')
    ->addBefore('build:assets:npm');
after('deploy:update_code', 'upload:assets');

/**********************
 * Flow configuration *
 **********************/
// Clear the Opcache
after('deploy:symlink', 'cachetool:clear:opcache');
// Unlock the deploy when it failed
after('deploy:failed', 'deploy:unlock');
// Migrate database before symlink new release.
before('deploy:symlink', 'database:migrate');
