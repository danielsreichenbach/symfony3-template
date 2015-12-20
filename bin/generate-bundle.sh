#!/bin/bash

NAMESPACE="Acme"

if [ -z "$*" ]; then
    echo -e "\nUsage: $0 BundleName\n";
    exit;
fi

bin/console generate:bundle --namespace=${NAMESPACE}/Bundle/$1 --bundle-name=${NAMESPACE}$1 --dir=src --shared --format=annotation --no-interaction
rm -rf src/${NAMESPACE}/Bundle/$1/Tests src/${NAMESPACE}/Bundle/$1/Resources/views/Default/ src/${NAMESPACE}/Bundle/$1/Controller/

mkdir -p src/${NAMESPACE}/Bundle/$1/Resources/translations/
touch src/${NAMESPACE}/Bundle/$1/Resources/views/.gitkeep
touch src/${NAMESPACE}/Bundle/$1/Resources/translations/.gitkeep
