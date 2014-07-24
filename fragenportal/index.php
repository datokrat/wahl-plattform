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
			<h1>Befrage deine Kandidaten.</h1>
			<section>
				<div id="platform-controls">
				</div>
				<div id="widgets">
					<!--div class="big widget">
						<div>
							<h1>Tags</h1>
							<div class="tagcloud">
								<a>bildung</a>
								<a>energie</a>
								<a>kultur</a>
								<a>umwelt</a>
								<a>holi</a>
							</div>
						</div>
					</div-->
					<div class="big widget" data-bind="template: { name: 'browsewidget-template', data: questionsWidget }">
					</div>
					<div class="big widget" data-bind="template: { name: 'newquestionwidget-template', data: newQuestionWidget }">
					</div>
				</div>
			</section>
		</div>
		
		<?php uiFooter() ?>
		<?php uiTemplates() ?>
		<?php uiJsAdditional() ?>
		<script type="text/javascript" src="index.js"></script>
	</body>
</html>