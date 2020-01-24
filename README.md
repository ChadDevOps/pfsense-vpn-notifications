# pfsense-vpn-notifications
Receive notifications on pfsense ipsec or openvpn connection/disconnection

### SSH

- SSH to your pfsense firewall. Upload files to /root/
- chmod 755

```
 4 -rwxr-xr-x   1 root  wheel   1999 Jul 17  2019 ipsec.php
 4 -rwxr-xr-x   1 root  wheel    198 Jul 17  2019 notify.php
 4 -rwxr-xr-x   1 root  wheel    308 Jul 17  2019 openvpnconnect.sh
 4 -rwxr-xr-x   1 root  wheel    498 Jul 17  2019 openvpndisconnect.sh
```

### Open VPN
For open VPN:

- Login to GUI
- VPN
- Edit your OpenVPN Server
- Under Advanced Configuration, Custom options, add the following line:

```client-connect /root/openvpnconnect.sh;client-disconnect /root/openvpndisconnect.sh; ```

### ipsec
Create cron to run every minute or so. This will not give exact times for connect/disconnect but within a 60 second window.

- Login to GUI
- Services
- Cron

```*	*	*	*	*	root	/usr/local/bin/php /root/ipsec.php > /dev/null 2>&1```

### Notifications

Setup your SMTP server. The above files utilize pfsense's php functions to send via the send_smtp_message function 

- Login to GUI
- System
- Advanced
- Notifications Tab
