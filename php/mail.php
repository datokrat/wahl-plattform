<?php 
require_once("$serverRoot/php/config.php");

function check_email($email) {
    if(!ereg("^[^@]{1,64}@[^@]{1,255}$", $email)) {
        return false;
    }
    $email_array = explode("@", $email);
    $local_array = explode(".", $email_array[0]);
    for ($i = 0; $i < sizeof($local_array); $i++) {
        if(!ereg("^(([A-Za-z0-9!#$%&'*+/=?^_`{|}~-][A-Za-z0-9!#$%&'*+/=?^_`{|}~\.-]{0,63})|(\"[^(\\|\")]{0,62}\"))$", $local_array[$i])) {
            return false;
        }
    }
    if(!ereg("^\[?[0-9\.]+\]?$", $email_array[1])) {
        $domain_array = explode(".", $email_array[1]);
        if(sizeof($domain_array) < 2) {
            return false;
        }
        for($i = 0; $i < sizeof($domain_array); $i++) {
            if(!ereg("^(([A-Za-z0-9][A-Za-z0-9-]{0,61}[A-Za-z0-9])|([A-Za-z0-9]+))$", $domain_array[$i])) {
                return false;
            }
        }
    }
    return true;
}  

function sendMail($subject, $message, $from) {
	global $contactMailAddress;
	if(check_email($from))
		mail($contactMailAddress, $subject, $message, "From: $from");
}

?>