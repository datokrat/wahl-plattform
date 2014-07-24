<?php
$serverRoot = ".";

require_once("./php/session.php");
require_once('./php/login.php');
require_once('./php/ui.php');

initSession();

function hasLoginData() {
	if(!isset($_POST['name']) || !isset($_POST['pw']))
		return false;
	return true;
}

function hasLogoutData() {
	return isset($_POST['logout']);
}

?>

<!doctype html>
<html>
	<head>
		<title></title>
		<?php uiMeta(); uiStyles() ?>
	</head>
	<body>
		<?php uiHeader(true); uiNavi('account', true); uiSocial() ?>
		<div id="cnt">
<?php

if(hasLoginData()) {
	$name = $_POST['name'];
	$pw = $_POST['pw'];
	
	$res = tryLogin($name, $pw);
	
	if($res->success) {
	}
	else {
		echo "<h1>Fehler!</h1>";
	}
}
else if(hasLogoutData()) {
	tryLogout();
	echo "<h1>Erfolgreich abgemeldet.</h1>";
}
else if(!isLoggedIn()) {
	echo "<h1>Anmelden</h1>";
}

if(!isLoggedIn()) {
?>

<form action="login.php" method="POST">
	<input type="text" placeholder="Name" name="name" />
	<input type="password" placeholder="Passwort" name="pw" />
	<input type="submit" value="Anmelden" />
</form>

<?php
}
else {
	echo "<h1>Herzlich willkommen, " . getLoginName() . "!</h1>";
	echo "<a href='fragenportal/kandidat.php?id=" . getLoginId() . "'>Zum Profil</a>";
	echo "<p><form action='login.php' method='POST'><input type='submit' name='logout' value='Abmelden' /></p></form>";
}
?>