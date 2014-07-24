<?php
$serverRoot = "..";
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");

($from = $_GET['from']) or ($from = 0);
($count = $_GET['count']) or ($count = 0);
$featured = isset($_GET['feat']) ? $_GET['feat'] : 0;
$answered = isset($_GET['answered']) ? $_GET['answered'] : 0;
$featured = intval($featured); $count = intval($count); $from = intval($from); $answered = intval($answered);

$out = new OutputData();
$out->data = array();

$where = "`unlocked`=TRUE";
if($featured == 1)
	$where .= " AND (`featured`=1)";
elseif($featured == -1)
	$where .= " AND (`featured`=0)";

if($answered == 1)
	$where .= " AND ((SELECT COUNT(*) FROM `wahl_answers` WHERE `question`=`wahl_questions`.`id`)>0)";
elseif($answered == -1)
	$where .= " AND NOT ((SELECT COUNT(*) FROM `wahl_answers` WHERE `question`=`wahl_questions`.`id`)>0)";

initDatabase();

$query = "SELECT `id`, `author`, `title`, `text` FROM `wahl_questions` WHERE $where LIMIT {$db->real_escape_string($from)},{$db->real_escape_string($count+1)}";
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