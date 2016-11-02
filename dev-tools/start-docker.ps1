#
# Docker startup script for Windows 10 machines using docker-toolbox
#
# This script must be run with PowerShell.
# 
# Notes:
#  - if the execution is blocked due to windows security policies, run the following command:
#    Set-ExecutionPolicy Unrestricted -Scope CurrentUser
#
#  - port-forwarding rules must be setup in the "default" VM in VirtualBox. See "settings" > "network" > "advanced"
#

docker-machine start default
docker-machine env default | Invoke-Expression
docker-compose -f ../docker-compose.yml up -d
