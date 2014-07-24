<?php
$serverRoot = '..';
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");

$userId = intval($_GET['id']);

initDatabase();
$q = "SELECT `imgdata`, `imgtype` FROM `wahl_members` WHERE `id`='$userId'";
$res = $db->query($q);
if(!$db->errno && $res->num_rows == 1) {
	$obj = $res->fetch_object();
	
	header("Content-type: {$obj->imgtype}");
	echo $obj->imgdata;
}
closeDatabase();
?>