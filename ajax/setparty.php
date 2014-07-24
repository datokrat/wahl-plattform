<?php
$serverRoot = '..';
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/login.php");

initSession();

$out = new OutputData();

if(isLoggedIn()) {
	$userName = getLoginName();
	$party = isset($_POST['party']) ? $_POST['party'] : '';
	
	if(strlen($party) <= 16) {
	
		initDatabase();
		$q = "UPDATE `wahl_members` SET `party`='{$db->real_escape_string($party)}' WHERE `name`='{$db->real_escape_string($userName)}'";
		$db->query($q);
		if($db->errno) {
			$out->msgCodes[] = 'dberror';
			$out->success = false;
		}
		closeDatabase();
	}
	else {
		$out->success = false;
		$out->msgCodes[] = 'c:Die Partei darf maximal 16 Zeichen lang sein.';
	}
}
else {
	$out->msgCodes[] = 'notsignedin';
	$out->success = false;
}

$out->printThis();

?>