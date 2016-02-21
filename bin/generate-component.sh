#!/bin/bash

NAMESPACE="Acme"

if [ -z "$*" ]; then
    echo -e "\nUsage: $0 ComponentName\n";
    exit;
fi

mkdir -p src/${NAMESPACE}/Component/$1/
touch src/${NAMESPACE}/Component/$1/.gitkeep
