#!/usr/bin/env bash

# Does all of the initial setup for the project

# Begin Setup
clear

echo ""

read -e -p "This will completely reset the local install. Are you sure? (y/n): " option

if [ $option = "n" ]; then
    exit
fi

echo ""

echo "================================================================="
echo "Beginning Scaffolding"
echo "================================================================="

echo ""

if [ -d vendor ]; then
    echo "Removing 'vendor' Directory..."
    rm -rf vendor
    echo -e "Done!\n"
fi

if [ -d node_modules ]; then
    echo "Removing 'node_modules' Directory..."
    rm -rf node_modules
    echo -e "Done!\n"
fi

if [ -e .env ]; then
    rm -rf .env.original
    echo "Backing up your '.env' file to '.env.original'..."
    mv .env .env.original
    echo -e "Done!\n"
fi

echo "Creating Fresh '.env' File..."
cp .env.example .env
echo -e "Done!\n"

echo ""

echo "================================================================="
echo "Starting Docker Containers"
echo "================================================================="

./vessel start


echo "================================================================="
echo "Installing JS and CSS Dependencies"
echo "================================================================="

./vessel yarn install

if [ $? -eq 0 ];then
   echo -e "\nDone!\n"
else
   echo -e "\nSomething went wrong, Exiting!\n"
   exit 1
fi

echo ""

echo "================================================================="
echo "Installing Composer Dependencies"
echo "================================================================="

./vessel composer install --optimize-autoloader

if [ $? -eq 0 ];then
   echo -e "\nDone!\n"
else
   echo -e "\nSomething went wrong, Exiting!\n"
   exit 1
fi

echo "================================================================="
echo "Compiling Frontend Assets"
echo "================================================================="

./vessel yarn run dev

if [ $? -eq 0 ];then
   echo -e "\nDone!\n"
else
   echo -e "\nSomething went wrong, Exiting!\n"
   exit 1
fi

echo "================================================================="
echo "Generating Application Key"
echo "================================================================="

echo ""
./vessel artisan key:generate

if [ $? -eq 0 ];then
   echo -e "\nDone!\n"
else
   echo -e "\nSomething went wrong, Exiting!\n"
   exit 1
fi

echo ""

echo "================================================================="
echo "Scaffolding Complete!"
echo "================================================================="

echo ""