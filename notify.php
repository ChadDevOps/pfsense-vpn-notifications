<?php
$args = getopt("",array("message::","subject::"));

require_once("/etc/inc/notices.inc");
//notify_all_remote("OPEN-VPN Connected");
send_smtp_message($args["message"], $args["subject"]);

?>
