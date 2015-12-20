#!/bin/sh
#

if ! [ -d node_modules ] ; then
    npm --silent install
fi
if ! [ -d vendor ] ; then
    composer install --ansi --no-interaction
fi

bin/console doctrine:database:create    --env=test --ansi --no-interaction
bin/console doctrine:migrations:migrate --env=test --ansi --no-interaction --allow-no-migration
bin/console doctrine:schema:validate    --env=test --ansi --no-interaction
bin/console doctrine:fixtures:load      --env=test --ansi --no-interaction
bin/console assets:install web          --env=test --ansi --no-interaction --symlink
bin/console server:start                           --ansi --no-interaction
vendor/bin/phpcs --colors --standard=vendor/escapestudios/symfony2-coding-standard/Symfony2 --ignore=tests/,src/Acme/*/*/spec/ src
gulp
bin/console server:stop                            --ansi --no-interaction
bin/console doctrine:database:drop      --env=test --ansi --no-interaction --force
