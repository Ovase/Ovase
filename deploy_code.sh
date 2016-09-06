#!/bin/bash

# Script used to deploy the wiki part or the node part of ovase.no
#
# Usage: 	./deploy_code.sh ovase 			to deploy the main ovase page
# 			./deploy_code.sh wiki 			to deploy the wiki part
# 			./deploy_code.sh ovase wiki 	to deploy both parts
# DEPRECATED

OVASE_DIR=/var/www/html
WIKI_DIR=/var/www/html/wiki
BACKUP_ROOT=~/deploy_backups
BACKUP_DIR="${BACKUP_ROOT}/backup_$(date +%Y%m%d_%H%M%S)"

DEPLOY_WIKI=false
DEPLOY_OVASE=false

if [ "$1" = "wiki" ]; then
	DEPLOY_WIKI=true
fi

if [ "$1" = "ovase" ]; then
	DEPLOY_OVASE=true
fi

if [ "$2" = "wiki" ]; then
	DEPLOY_WIKI=true
fi

if [ "$2" = "ovase" ]; then
	DEPLOY_OVASE=true
fi

echo "- Deploy ovase? $DEPLOY_OVASE , Deploy wiki? $DEPLOY_WIKI -"


# Stop apache and the node-service
echo "========== Stopping web server =========="
sudo service httpd stop

# Sets extended pattern matching options in the bash shell
shopt -s extglob

# Do backups
echo "========== Creating backups into '~/deploy_backups' =========="
mkdir $BACKUP_DIR
if [ "$DEPLOY_WIKI" = true ]; then
	cp -rf $WIKI_DIR $BACKUP_DIR
fi

if [ "$DEPLOY_OVASE" = true ]; then
	pushd .
	cd $OVASE_DIR
	cp -rf !(wiki) $BACKUP_DIR
	popd
fi

# Copy files to ovase_web (the portion of the site which is not the wiki)
if [ "$DEPLOY_OVASE" = true ]; then
	echo "========== Copying ovase files =========="
	cp -rf !(wiki|configuration|documentation|README.md|deploy_code.sh|install_app_service.sh|delete_folders_older_than.sh) $OVASE_DIR
fi

# Copy files to /var/www/html (the wiki-portion of the site)
if [ "$DEPLOY_WIKI" = true ]; then
	echo "========== Copying wiki files =========="
	cd wiki
	cp -rf !(images|cache) $WIKI_DIR
	cd ..
fi

# Disable extended pattern matching
shopt -u extglob

# Start apache and the node-service again
echo "========== Restarting web servers =========="
sudo service httpd start

echo "========== Deployment (attempt) completed! =========="
