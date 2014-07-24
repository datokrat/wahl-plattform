<?php
$serverRoot = "..";
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");

($from = $_GET['from']) or ($from = 0);
($count = $_GET['count']) or ($count = 0);
$count = intval($count); $from = intval($from);

$out = new OutputData();
$out->data = array();

$where = "true";

initDatabase();

$query = "SELECT `id`, `name` FROM `wahl_members` WHERE $where ORDER BY `name` LIMIT {$db->real_escape_string($from)},{$db->real_escape_string($count+1)}";
$res = $db->query($query);
$out->data['query']=$query;

if($db->errno) {
	$out->success = false;
	$out->msgCodes[] = 'dberror';
}
else {
	$fetched = $res->fetch_all(MYSQLI_ASSOC);
	$out->data['result'] = array_slice($fetched, 0, $count);
	$out->data['hasNext'] = count($fetched) > $count;
}

closeDatabase();
$out->data = (object)$out->data;
$out->printThis();
?>