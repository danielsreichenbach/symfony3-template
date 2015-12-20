#!/bin/bash

NAMESPACE="Acme"

if [ -z "$*" ]; then
    echo -e "\nUsage: $0 ComponentName\n";
    exit;
fi

mkdir -p src/${NAMESPACE}/Compnent/$1/
touch src/${NAMESPACE}/Compnent/$1/.gitkeep
