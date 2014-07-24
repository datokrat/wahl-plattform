<?php
$serverRoot = "..";
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
		<?php uiNavi('candidates', true) ?>
		<?php uiSocial() ?>
		
		<!--div id="top-cnt-separator"> </div-->
		
		<div id="cnt">
			<h1>Wen kannst du wählen?</h1>
			<section>
				<div id="platform-controls">
				</div>
				<div id="widgets">
					<div class="big widget" data-bind="template: { name: 'browsewidget-template', data: candidatesWidget }">
					</div>
				</div>
			</section>
		</div>
		
		<?php uiFooter() ?>
		<?php uiTemplates() ?>
		<?php uiJsAdditional() ?>
		<script type="text/javascript" src="kandidaten.js"></script>
	</body>
</html>