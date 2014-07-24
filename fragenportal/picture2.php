<?php
$serverRoot = '..';
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/login.php");
require_once("$serverRoot/php/session.php");

initSession();

$out = new OutputData();

//$hasPic = isset($_FILES['picture']);
$hasPic = isset($_POST['picture']);

if($hasPic && isLoggedIn()) {
	$name = getLoginName();
	//$pic = $_FILES['picture'];
	
	$pic = file_get_contents('data://' . substr($_POST['picture'], 5));
		
	if(true) {
		
		initDatabase();
		$q = "UPDATE `wahl_members` SET `imgdata`='{$db->real_escape_string($pic)}', `imgtype`='image/jpeg' WHERE `name`='{$db->real_escape_string($name)}'";
		$db->query($q);
		if(!$db->errno) {
			$out->success = false;
			$out->msgCodes[] = 'Danke, das Bild sollte nun erscheinen!';
		}
		else {
			$out->success = false;
			$out->msgCodes[] = 'Entschuldigung, das hat nicht funktioniert!';
		}
		closeDatabase();
	}
	else {
		$out->success = false;
		$out->msgCodes[] = 'Bitte laden Sie ein JPG-, JPEG-, PNG- oder GIF-Bild hoch!';
	}
}
elseif(!isLoggedIn()) {
	$out->success = false;
	$out->msgCodes[] = 'Sie müssen eingeloggt sein.';
}
else {
	$out->success = false;
	$out->msgCodes[] = 'Entschuldigung, das hat nicht funktioniert!';
}
?>