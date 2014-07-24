<?php
$serverRoot = '..';
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/config.php");
require_once("$serverRoot/php/mysql.php");

$out = new OutputData();

if(!(isset($_POST['title']) && isset($_POST['text']) && isset($_POST['author']))) {
	$out->success = false;
	$out->msgCodes[] = 'params';
}
else {
	$author = $_POST['author'];
	$title = $_POST['title'];
	$text = $_POST['text'];
	
	if(strlen($author) <= 20 && strlen($title) <= 120 && strlen($text) <= 400) {
		initDatabase();
		
		$query = "INSERT INTO `wahl_questions` (`author`, `title`, `text`) VALUES ('{$db->real_escape_string($author)}', '{$db->real_escape_string($title)}', '{$db->real_escape_string($text)}')";
		$res = $db->query($query);
		
		if($db->errno) {
			$out->success = false;
			$out->msgCodes[] = 'dberror';
		}
		
		$out->data = $db->insert_id;
		
		closeDatabase();
		mail($contactMailAddress, "cw:Neue Frage eingetroffen", "Bitte nachschauen", "From: $senderMailAddress");
		$out->success = false;
		$out->msgCodes[] = 'c:Deine Frage wird jetzt geprüft und sollte ungefähr morgen erscheinen!';
	}
	else {
		$out->success = false;
		$out->msgCodes[] = 'c:Der Titel darf nicht länger als 120 Zeichen, der Text nicht länger als 400 und das Pseudonym nicht länger als 20 Zeichen sein!';
	}

	$out->printThis();
}

?>