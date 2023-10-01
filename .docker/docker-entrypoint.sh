#!/bin/bash

# env | tee -a /etc/environment 1>/dev/null

bash /replace_env_with_args.sh

exec "$@"
