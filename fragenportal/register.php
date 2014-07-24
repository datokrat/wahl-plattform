<?php
$serverRoot = "..";
require_once('../php/common.php');
require_once('../php/ui.php');
require_once('../php/session.php');

initSession();

?>

<!doctype html>
<html>
	<head>
		<title>Kandidatenbefragung zur Kommunalwahl &bull; Wählen - nicht meckern!</title>
		<?php uiMeta(); uiStyles(true) ?>
	</head>
	<body>
		<?php uiHeader(true) ?>
		<?php uiNavi('overview', true) ?>
		<?php uiSocial() ?>
		
		<!--div id="top-cnt-separator"> </div-->
		
		<div id="cnt">
			<h1>Registrierung für Kandidaten</h1>
			<section>
				<div id="platform-controls">
				</div>
				<div id="widgets">
					<div class="big widget">
						Herzlich willkommen auf dieser Internetplattform! Wenn Sie ein Kandidat sind, dann sind sie hier richtig. Bitte füllen Sie dieses
						Formular aus, wenn Sie auf dieser Plattform teilnehmen wollen.
						<form action="#" method="POST" data-bind="event: { submit: onSubmit }">
							<input type="text" name="username" placeholder="Nachname, Vorname" data-bind="value: userName" />
							<input type="password" name="pw" placeholder="Passwort" data-bind="value: password" />
							<input type="submit" value="Registrieren" />
						</form>
					</div>
				</div>
			</section>
		</div>
		
		<?php uiFooter() ?>
		<?php uiTemplates() ?>
		<?php uiJsAdditional() ?>
		<script type="text/javascript" src="register.js"></script>
	</body>
</html>