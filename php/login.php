<?php
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/passwordhash.php");

function isLoggedIn() {
	return isset($_SESSION['name']);
}

function tryLogin($name, $pw) {
	global $db;
	$out = new OutputData();
	initDatabase();
	$q = "SELECT `id`, `name`, `pwhash` FROM `wahl_members` WHERE `name`='{$db->real_escape_string($name)}'";
	$res = $db->query($q);
	
	if(!$db->errno) {
		if($res->num_rows == 1) {
			$obj = $res->fetch_object();
			if(validate_password($pw, $obj->pwhash)) {
				setLogin($name, $obj->id);
			}
		}
		else {
			$out->success = false;
			$out->msgCodes[] = 'signindata';
		}
	}
	else {
		$out->success = false;
		$out->msgCodes[] = 'dberror';
		$out->msgCodes[] = 'd:MySQL: ' . $db->error;
	}
	closeDatabase();
	
	return $out;
}

function tryRegister($name, $pw) {
	global $db;
	
	$out = new OutputData();
	
	initDatabase();
	$pwhash = create_hash($pw);
	$q = "INSERT INTO `wahl_members` (`name`, `pwhash`) VALUES ('{$db->real_escape_string($name)}', '{$db->real_escape_string($pwhash)}')";
	$res = $db->query($q);
	
	if(!$db->errno) {
		$insertId = $db->insert_id;
		$out->data = $insertId;
	}
	else {
		$out->success = false;
		$out->msgCodes[] = 'dberror';
		$out->msgCodes[] = 'd:MySQL: ' . $db->error;
		$out->msgCodes[] = 'd:MySQL: ' . $q;
	}
	
	closeDatabase();
	return $out;
}

function tryLogout() {
	renewSession();
	return true;
}

function setLogin($name, $id) {
	renewSession();
	$_SESSION['name'] = $name;
	$_SESSION['id'] = $id;
}

function getLoginName() {
	if(isLoggedIn())
		return $_SESSION['name'];
	else
		return 'anonymous';
}

function getLoginId() {
	if(isLoggedIn())
		return $_SESSION['id'];
	else
		return '0';
}

?>