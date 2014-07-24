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
	$desc = isset($_POST['desc']) ? $_POST['desc'] : '';
	$tags = isset($_POST['tags']) ? $_POST['tags'] : '';
	
	if(strlen($desc) <= 400 && strlen($tags) <= 120) {
	
		initDatabase();
		$q = "UPDATE `wahl_members` SET `desc`='{$db->real_escape_string($desc)}', `tags`='{$db->real_escape_string($tags)}' WHERE `name`='{$db->real_escape_string($userName)}'";
		$db->query($q);
		if($db->errno) {
			$out->msgCodes[] = 'dberror';
			$out->success = false;
		}
		closeDatabase();
	}
	else {
		$out->success = false;
		$out->msgCodes[] = 'c:Die Beschreibung darf maximal 400 Zeichen lang sein.';
	}
}
else {
	$out->msgCodes[] = 'notsignedin';
	$out->success = false;
}

$out->printThis();

?>