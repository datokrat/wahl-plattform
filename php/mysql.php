<?php
require_once("$serverRoot/php/config.php");

function initDatabase() {
	global $db;
	global $dbUsername, $dbPassword, $dbDatabaseName;
	
	$db = new mysqli("127.0.0.1", $dbUsername, $dbPassword, $dbDatabaseName);
	$db->query("SET NAMES 'utf8'");
}

function closeDatabase() {
	global $db;
	$db->close();
}

?>