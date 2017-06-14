#!/usr/bin/env bash

DEFAULT_CONFIG_DIR='/home/ec2-user/configs'
DEFAULT_OVASE_DIR='/var/www/Ovase'

# TODO: Improve this approach
# Approach: Just copy files

# Pico_edit password config
cp $DEFAULT_CONFIG_DIR/picopages/config_pico_edit.php $DEFAULT_OVASE_DIR/systems/picopages/config/pico_edit/config.php

# Prototype config with API keys
cp $DEFAULT_CONFIG_DIR/proto/config.yml $DEFAULT_OVASE_DIR/systems/proto/app/config/config.yml
