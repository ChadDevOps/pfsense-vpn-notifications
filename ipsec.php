<?php
//ini_set('display_errors', 1);
//ini_set('display_startup_errors', 1);
//error_reporting(E_ALL);
require_once("/etc/inc/ipsec.inc");
require_once("/etc/inc/notices.inc");

$arr1 = array();
$arr1 = pfSense_ipsec_list_sa();

$arr2 = array();
if (file_exists('ipsec.json')) {
    $arr2 = json_decode(file_get_contents('ipsec.json'), true);
}

if(!empty($arr2)){
    foreach($arr2 as $key=>$value) {
        unset($arr2_xauth_key);
        unset($arr2_uniqueid_key);
        $arr2_xauth_key = array_search($value["remote-xauth-id"], array_column($arr1, 'remote-xauth-id'));
        $arr2_uniqueid_key = array_search($value["uniqueid"], array_column($arr1, 'uniqueid'));

        if(gettype($arr2_xauth_key) == 'boolean' || gettype($arr2_uniqueid_key) == 'boolean'){
            // send email for disconnect
            $msg = "{$value['remote-xauth-id']}, {$value['remote-host']}, on connection {$value['uniqueid']} has disconnected in last 60 sec.";
            $sub = "PFSENSE - IPSEC - {$value['remote-xauth-id']} disconnected.";
            send_smtp_message($msg, $sub);
        }
    }            
}

sleep(1); 

if(!empty($arr1)){
    // we know there is a connection
    foreach($arr1 as $key=>$value) {
        unset($arr2_xauth_key);
        unset($arr2_uniqueid_key);
        $arr2_xauth_key = array_search($value["remote-xauth-id"], array_column($arr2, 'remote-xauth-id'));
        $arr2_uniqueid_key = array_search($value["uniqueid"], array_column($arr2, 'uniqueid'));

        if(empty($arr2) || ((gettype($arr2_xauth_key) == 'boolean' || gettype($arr2_uniqueid_key) == 'boolean') && !empty($arr2))){
            // send email for new connection!
            $msg = "{$value['remote-xauth-id']}, {$value['remote-host']}, on connection {$value['uniqueid']} has connected in last 60 sec.";
            $sub = "PFSENSE - IPSEC - {$value['remote-xauth-id']} connected.";
            send_smtp_message($msg, $sub);
        }

    }
}


file_put_contents("ipsec.json",json_encode($arr1));