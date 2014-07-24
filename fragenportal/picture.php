<?php
$serverRoot = '..';
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/login.php");
require_once("$serverRoot/php/session.php");

initSession();

$hasPic = isset($_FILES['picture']);

?>

<!doctype html>
<html>
	<head>
		<meta charset="utf-8" />
	</head>
	<body>
<?php
if($hasPic && isLoggedIn()) {
	$name = getLoginName();
	$pic = $_FILES['picture'];
		
	if($pic['type'] == 'image/jpg' || $pic['type'] == 'image/png' || $pic['type'] == 'image/gif' || $pic['type'] == 'image/jpeg') {
		$tmpName = $pic['tmp_name'];
		$hndFile = fopen($tmpName, 'r');
		$data = fread($hndFile, fileSize($tmpName));
		$type = $pic['type'];
		
		initDatabase();
		$q = "UPDATE `wahl_members` SET `imgdata`='{$db->real_escape_string($data)}', `imgtype`='{$db->real_escape_string($type)}' WHERE `name`='{$db->real_escape_string($name)}'";
		$db->query($q);
		if(!$db->errno) {
			echo 'Danke, das Bild sollte nun erscheinen!';
		}
		else
			echo 'Entschuldigung, das hat nicht funktioniert!';
		closeDatabase();
	}
	else
		echo 'Bitte laden Sie ein JPG-, JPEG-, PNG- oder GIF-Bild hoch!';
	echo " <a href='kandidat.php?id=" . getLoginId() . "'>zurück</a>";
}
elseif(!isLoggedIn()) {
	echo 'Sie müssen eingeloggt sein.';
	echo " <a href='/'>zurück</a>";
}
else {
	echo 'Entschuldigung, das hat nicht funktioniert!';
	echo " <a href='/'>zurück</a>";
}
?>
	</body>
</head>
</html>