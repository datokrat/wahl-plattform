<?php
require_once("$serverRoot/php/common.php");
require_once("$serverRoot/php/ui.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/mail.php");

initSession();

$sendMessage = isset($_POST['send']);
$out = new OutputData();
$sent = false;
if($sendMessage) {
	$email = $_POST['email'];
	$message = $_POST['message'];
	if(strlen($message) <= 1000) {
		if(check_email($email)) {
			sendMail("Neue Nachricht zur Kommunalwahl", $message, $email);
			$sent = true;
		}
		else {
			$out->success = false;
			$out->messages[] = 'Die E-Mail-Adresse ist nicht korrekt!';
		}
	}
	else {
		$out->success = false;
		$out->messages[] = 'Die Nachricht darf maximal 1000 Zeichen lang sein!';
	}
}
?>

<!doctype html>
<html>
	<head>
		<title>Kandidatenbefragung zur Kommunalwahl &bull; Wählen - nicht meckern!</title>
		<?php uiMeta(); uiStyles(true) ?>
	</head>
	<body>
		<?php if($sent) { ?>
		<div class="success">Die Nachricht wurde erfolgreich verschickt!</div>
		<?php } ?>
		<?php foreach($out->messages as $msg) { ?>
		<div class="error"><?php echo $msg ?></div>
		<?php } ?>
		<?php uiHeader(true) ?>
		<?php uiNavi('contact', true) ?>
		<?php uiSocial() ?>
		
		<div id="cnt">
			<h1>Kontakt</h1>
			<section>
				<div id="widgets">
					<div class="big widget">
						<h1>Kontakt</h1>
						<form action="#" method="POST">
							<input type="hidden" name="send" value="1" />
							<input type="text" name="email" placeholder="Ihre E-Mail-Adresse"/>
							<textarea class="fill" name="message" placeholder="Ihre Nachricht"><?php if(isset($message)) echo $message ?></textarea>
							<input type="submit" value="Losschicken" />
						</form>
					</div>
				</div>
			</section>
			<h1>Impressum</h1>
		
		<?php uiFooter() ?>
		<?php uiTemplates() ?>
		<?php uiJsAdditional() ?>
	</body>
</html>