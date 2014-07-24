<?php

function uiMeta() {
	echo <<<EOT
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8" />
		<meta name="viewport" content="width=device-width" />
EOT;
}

function uiStyles() {
	global $serverRoot;
	echo <<<EOT
		<link rel="stylesheet" href="$serverRoot/style.css" />
EOT;
	if(func_num_args() >= 1 && func_get_arg(0))
		echo <<<EOT
		<link rel="stylesheet" href="$serverRoot/fragenportal/additional-style.css" />
EOT;
}

function uiHeader() {
	global $serverRoot;
	$portal = func_num_args() >= 1 && func_get_arg(0);

	if($portal) echo '<noscript><div class="error">Du musst JavaScript aktivieren, um die Befragungsplattform wirklich nutzen zu können!</div></noscript>';

	echo <<<EOT
		<div id="top-logo">
			<img src="$serverRoot/wahl.png" style="width: 100%" />
EOT;

	if($portal) echo "<span>Fragenportal</span>";
	echo "</div>";
}

function uiNavi($active) {
	global $serverRoot;
	$user = isset($_SESSION['name']) ? $_SESSION['name'] : 'Mein Konto';
	$portal = func_num_args() >= 1 && func_get_arg(1);
	$activeStr = 'class="active"';
	echo '<nav><ul id="nav">';
	
	if(!$portal) {
		
	}
	else {
		echo "<li><a href=\"$serverRoot\"><b><<</b> <i>zurück</i></a></li><li ";
		if($active == 'overview') echo $activeStr;
			echo "><a href=\"$serverRoot/fragenportal\">Übersicht</a></li><li ";
		if($active == 'question')
			echo "$activeStr><a href=\"$serverRoot/fragenportal\">Frage</a></li><li ";
		if($active == 'candidates') echo $activeStr;
			echo "><a href=\"$serverRoot/fragenportal/kandidaten.php\">Kandidaten</a></li>";
		if($active == 'candidate')
			echo "<li $activeStr><a>Kandidat</a></li>";
		echo "<li ";
		if($active == 'account') echo $activeStr;
			echo "><a href=\"$serverRoot/login.php\">$user</a></li><li ";
		if($active == 'contact') echo $activeStr;
			echo "><a href=\"$serverRoot/kontakt.php\">Kontakt</a></li>";
	}
	echo '</ul></nav>';
}

function uiSocial() {
	/*echo 
<<<EOT
		<div id="social">
			<div class="social-button">f</div>
			<div class="social-button">t</div>
			<div class="social-button">YouTube</div>
		</div>
EOT;*/
}

function uiFooter() {
	global $serverRoot;
	echo
<<<EOT
		<div id="foo">
			<a href="$serverRoot/kontakt.php">Impressum</a>
		</div>
EOT;
}

function uiJsAdditional() {
	global $serverRoot;
	echo
<<<EOT
		<!--script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.min.js"></script-->
		<script type="text/javascript" src="$serverRoot/lib/jquery.js"></script>
		<script type="text/javascript" src="$serverRoot/fragenportal/knockout-3.0.0.js"></script>
		<script type="text/javascript" src="$serverRoot/fragenportal/commonwidgets.js"></script>
EOT;
}

function uiTemplates() {
	global $serverRoot;
	echo
<<<EOT
	<script type="text/html" id="browsewidget-template">
						<h1 data-bind="text: title"></h1>
						<div class="collapsible" data-bind="if: showFilters, attr: { 'data-collapsed': filtersCollapsed }">
							<a class="header button" data-bind="event: { 'click': toggleFilters }">
								Filter
							</a>
							<div class="area" data-bind="template: { name: filterTemplate }">
							</div>
						</div>
						<ul class="primitive-list" data-bind="foreach: visibleQuestions">
							<li>
								<a class="clickable" data-bind="text: \$parent.getCaption(\$data), attr: { href: \$parent.itemReference(\$data) }, event: { clickk: \$parent.onClickResult.bind(\$parent, \$data) }">
								</a>
							</li>
						</ul>
						<p data-bind="if: !questionsLoaded()">
							<span>Laden...</span>
						</p>
						<div>
							<!-- ko if: hasPrevPage --><a data-bind="click: prevPage"> << </a><!-- /ko -->
							Seite <span data-bind="text: page"></span>
							<!-- ko if: hasNextPage --><a data-bind="click: nextPage"> >> </a><!-- /ko -->
						</div>
	</script>
	<script type="text/html" id="none-filter-template">
	</script>
	<script type="text/html" id="questions-filter-template">
		<fieldset>
			<span class="option">
				<b><input type="checkbox" data-bind="checked: filterFeaturedOnly, attr: { id: id + '-featured-filter' }" />
				<label data-bind="attr: { for: id + '-featured-filter' }">Nur Schülerrat-Fragen</label></b>
			</span>
		</fieldset>
		<fieldset>
			<span class="option"><input type="checkbox" data-bind="checked: filterAnswered, attr: { id: id + '-answered-filter' }" />
			<label data-bind="attr: { for: id + '-answered-filter' }">beantwortet</label></span> /
			<span class="option"><input type="checkbox" data-bind="checked: filterUnanswered, attr: { id: id + '-unanswered-filter' }" />
			<label data-bind="attr: { for: id + '-unanswered-filter' }">unbeantwortet</label></span>
		</fieldset>
	</script>
	<script type="text/html" id="newquestionwidget-template">
		<h1 data-bind="text: title"></h1>
		<!--form method="POST" action="../ajax/addquestion.php"-->
			<p><input data-bind="value: qTitle" type="text" placeholder="Frage" style="width: 100%" /></p>
			<p><textarea class="fill" data-bind="value: qText" placeholder="Details - alles, was du zu deiner Frage noch so sagen willst" ></textarea></p>
			<p><label for="author">von &nbsp;</label><input data-bind="value: qPseudonyme" type="text" placeholder="Dein Pseudonym"/></p>
			<p><button data-bind="event: { click: qAdd }" >Fragen</button></p>
		<!--/form-->
	</script>
EOT;
}

?>