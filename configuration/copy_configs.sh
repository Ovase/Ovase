#!/usr/bin/env bash

DEFAULT_CONFIG_DIR='/home/ec2-user/configs'
DEFAULT_OVASE_DIR='/var/www/Ovase'

# Approach: Just copy files

# Pico_edit password config
cp $DEFAULT_CONFIG_DIR/picopages/pico_edit_password.secret $DEFAULT_OVASE_DIR/systems/picopages/config/pico_edit/pico_edit_password.secret

# Prototype config with API keys
cp $DEFAULT_CONFIG_DIR/proto/secrets.yml $DEFAULT_OVASE_DIR/systems/proto/app/config/secrets.yml

# MediaWiki database credentials and secrets
co $DEFAULT_CONFIG_DIR/wiki/mw_keys.secret $DEFAULT_OVASE_DIR/systems/wiki
co $DEFAULT_CONFIG_DIR/wiki/sql_user.secret $DEFAULT_OVASE_DIR/systems/wiki
