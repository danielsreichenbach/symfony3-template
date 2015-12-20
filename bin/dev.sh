#!/bin/sh
#

if ! [ -d node_modules ] ; then
    npm --silent install
fi
if ! [ -d vendor ] ; then
    composer install                    --ansi --no-interaction
fi

bin/console doctrine:database:create    --ansi --no-interaction
bin/console doctrine:migrations:migrate --ansi --no-interaction --allow-no-migration
bin/console doctrine:schema:validate    --ansi --no-interaction
bin/console doctrine:fixtures:load      --ansi --no-interaction
bin/console assets:install web          --ansi --no-interaction --symlink
bin/console server:start                --ansi --no-interaction
vendor/bin/phpcs --colors --standard=vendor/escapestudios/symfony2-coding-standard/Symfony2 --ignore=tests/,src/Acme/*/*/spec/ src
gulp
