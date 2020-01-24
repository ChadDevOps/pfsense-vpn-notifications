#!/bin/sh
logger -4 -t openvpn "User '${common_name}' at ${trusted_ip} disconnected. Tunnel IP ${ifconfig_local} closed. Session duration(s):${time_duration}. Server bytes sent/rcvd: ${bytes_sent}/${bytes_received}" 
php /root/notify.php --subject="PFSENSE - OPENVPN ${common_name} disconnected." --message="User '${common_name}' at ${trusted_ip} disconnected. Tunnel IP ${ifconfig_local} closed. Session duration(s):${time_duration}. Server bytes sent/rcvd: ${bytes_sent}/${bytes_received}"
exit 0