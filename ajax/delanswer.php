<?php
$serverRoot = '..';
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/login.php");

initSession();

if(!(isset($_GET['id'])))
	die("ERROR");

$id = intval($_GET['id']);
$author = getLoginName();

initDatabase();

$query = "SELECT `author` FROM `wahl_answers` WHERE `id`=$id AND `author`='{$db->real_escape_string($author)}'";
$res = $db->query($query);

if($db->errno) die($db->error);

if($res->num_rows == 1) {
	$query = "DELETE FROM `wahl_answers` WHERE `id`=$id AND `author`='{$db->real_escape_string($author)}'";
	$db->query($query);
	if($db->errno) die($db->error);
	success();
}
else die('ERROR');

//echo '{' . json_encode($db->insert_id) . '}';

closeDatabase();

function success() {
	echo "{ \"success\": true }";
}

?>