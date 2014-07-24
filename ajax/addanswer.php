<?php
$serverRoot = '..';
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/login.php");

initSession();

if(!(isset($_POST['text']) && isset($_POST['question'])))
	die("All fields must be filled in.");

$title = isset($_POST['title']) ? $_POST['title'] : '';
$text = $_POST['text'];
$question = intval($_POST['question']);
$author = getLoginName();

initDatabase();

$query = "INSERT INTO `wahl_answers` (`author`, `question`, `title`, `text`) VALUES ('{$db->real_escape_string($author)}', '{$question}', '{$db->real_escape_string($title)}', '{$db->real_escape_string($text)}')";
$res = $db->query($query);

if($db->errno) die($db->error);

success();
//echo '{' . json_encode($db->insert_id) . '}';

closeDatabase();

function success() {
	global $db;
	global $question, $title, $text, $author;

	echo json_encode((object) array(
		'id' => $db->insert_id,
		'question' => $question,
		'title' => $title,
		'text' => $text,
		'author' => $author
		));
}

?>