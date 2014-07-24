<?php
$serverRoot = '..';
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/login.php");
require_once("$serverRoot/php/session.php");

initSession();

$PARAMETERS = $_POST;

$out = new OutputData();

if(isset($PARAMETERS['username'], $PARAMETERS['pw'])) {
	$name = $PARAMETERS['username'];
	$pw = $PARAMETERS['pw'];
	
	$res = tryRegister($name, $pw);
	$out->mergeWith($res);
	
	if($out->success)
		setLogin($name, $res->data);
}
else {
	$out->success = false;
	$out->msgCodes[] = 'parameters';
}

$out->printThis();
?>