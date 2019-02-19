#!/usr/bin/env bash

# Essentially destroys all of the docker containers.

# Begin Setup
clear

echo "================================================================="
echo "Killing all Docker Containers"
echo "================================================================="

echo ""

./vessel down

read -e -p "Would you like to kill the Database and Redis Cache? (y/n)" option

if [ $option = "y" ]; then
    docker volume rm betterpatreon_vesselmysql
    docker volume rm betterpatreon_vesselredis
fi

if [ $option = "n" ]; then
    echo ""
    echo "Keeping Database and Redis Cache..."
fi

docker image rm vessel/node
docker image rm vessel/app

echo ""

echo "Containers Killed!"

echo ""

read -e -p "Rebuild Containers? (y/n)" option

if [ $option = "y" ]; then
    ./vessel build

    if [ $? -eq 0 ];then
        echo -e "\nDone!\n"
    else
        echo -e "\nSomething went wrong, Exiting!\n"
        exit 1
    fi
fi

read -e -p "Start Containers? (y/n):" option

if [ $option = "y" ]; then
    ./vessel start

    if [ $? -eq 0 ];then
        echo -e "\nDone!\n"
    else
        echo -e "\nSomething went wrong, Exiting!\n"
        exit 1
    fi
fi