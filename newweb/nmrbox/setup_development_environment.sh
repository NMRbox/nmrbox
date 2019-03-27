#!/bin/bash

SCRIPT_DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

if [[ ! -d "${SCRIPT_DIR}/node_env" ]]
then
  echo "node environment was not yet set up. Setting up now... (This only needs to happen once.)" | tee -a ${SCRIPT_DIR}/installation.log
  pip3 install nodeenv==1.3.3 | tee -a ${SCRIPT_DIR}/installation.log
  python3 -m nodeenv ${SCRIPT_DIR}/node_env | tee -a ${SCRIPT_DIR}/installation.log
fi

if [[ ! -d "${SCRIPT_DIR}/node_modules" ]]
then
  echo "node packages not installed. Setting up now... (This only needs to happen once.)" | tee -a ${SCRIPT_DIR}/installation.log
  source ${SCRIPT_DIR}/node_env/bin/activate
  npm install -g @angular/cli --silent | tee -a ${SCRIPT_DIR}/installation.log
  npm install --silent | tee -a ${SCRIPT_DIR}/installation.log
  deactivate_node
fi

