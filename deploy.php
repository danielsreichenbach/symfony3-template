<?php

// All Deployer recipes are based on `recipe/common.php`.
require 'recipe/symfony.php';


/**
 * Define available deployment servers.
 */
localServer('local')
    ->stage('local')
    ->env('deploy_path', __DIR__.'/../website-localhost');

server('stage', 'your.server.com', 22)
    ->user('johndoe')
    ->forwardAgent()
    ->stage('staging')
    ->env('deploy_path', '/var/www/staging.symfony3-template.com');

server('prod', 'your.server.com', 22)
    ->user('johndoe')
    ->forwardAgent()
    ->stage('production')
    ->env('deploy_path', 'production.symfony3-template.com');

/**
 * Deployment settings
 */
set('repository', 'https://github.com/danielsreichenbach/symfony3-template.git');
set('keep_releases', 3);
set('shared_dirs', ['node_modules', 'vendor']);
set('shared_files', ['app/config/parameters.yml']);
set('writable_dirs', ['var/cache', 'var/logs']);
set('assets', ['web/css', 'web/js']);

/**
 * Task group modifications
 */
task('deploy', [
    'deploy:prepare',
    'deploy:release',
    'deploy:update_code',
    'deploy:create_cache_dir',
    'deploy:shared',
    'deploy:writable',
    'deploy:vendors',
    'deploy:assets',
    'deploy:cache:warmup',
    'deploy:symlink',
    'cleanup',
])->desc('Deploy your project');

/**
 * Download and install Node JS packages
 */
task('deploy:npm:install', function () {
    run("cd {{release_path}} && npm install");
})->desc('Installing NPM vendors');

/**
 * Prune NodeJS packages removed from `package.json`
 */
task('deploy:npm:prune', function () {
    run("cd {{release_path}} && npm prune");
})->desc('Pruning unused NPM vendors');

/**
 * Build external and internal assets
 */
task('deploy:gulp:assets', function () {
    run("cd {{release_path}} && node_modules/.bin/gulp --production");
})->desc('Dump assets');

/**
 * Migrate database
 */
task('deploy:database:migrate', function () {
    run('php {{release_path}}/'.trim(get('bin_dir'), '/').'/console doctrine:migrations:migrate --env={{env}} --no-debug --no-interaction --allow-no-migration');
})->desc('Migrate database');

/**
 * Load database fixtures
 */
task('deploy:database:fixtures', function () {
    run('php {{release_path}}/'.trim(get('bin_dir'), '/').'/console doctrine:fixtures:load --env={{env}} --no-debug --no-interaction');
})->desc('Load database fixtures');

/**
 * Task process changes
 */
before('deploy:vendors', 'deploy:npm:install');
after('deploy:npm:install', 'deploy:npm:prune');
after('deploy:npm:install', 'deploy:gulp:assets');
after('deploy:vendors', 'deploy:database:migrate');
