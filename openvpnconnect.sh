#!/bin/sh
logger -4 -t openvpn "User '${common_name}' at ${trusted_ip} autheticated. Tunnel IP ${ifconfig_local} opened." 
php /root/notify.php --subject="PFSENSE - OPENVPN ${common_name} connected." --message="User '${common_name}' at ${trusted_ip} autheticated. Tunnel IP ${ifconfig_local} opened."
exit 0
