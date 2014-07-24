<?php
$serverRoot = "..";
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/login.php");
require_once("$serverRoot/php/ui.php");

isset($_GET['id']) or die('Du musst eine Frage ausw&auml;hlen.');
$id = intval($_GET['id']);

initSession();
initDatabase();

$query = "SELECT `id`, `author`, `title`, `text` FROM `wahl_questions` WHERE `id`=$id";
$res = $db->query($query);

$q = $res->fetch_object();

$query = "SELECT `id`, `author`, `question`, `title`, `text` FROM `wahl_answers` WHERE `question`={$q->id}";
$res = $db->query($query);

$a = $res->fetch_all(MYSQLI_ASSOC);

closeDatabase();

$tmp = array_map(function($ans) {
	return "{id: {$ans['id']}, author: " . json_encode(($ans['author']), JSON_UNESCAPED_UNICODE) . ", title: " . json_encode(($ans['title']), JSON_UNESCAPED_UNICODE) . ", text: " . json_encode($ans['text'], JSON_UNESCAPED_UNICODE) . "}";
}, $a);

$atext = "[" . implode(',', $tmp) . "]";

?>

<!doctype html>
<html>
	<head>
		<title>Kandidatenbefragung zur Kommunalwahl &bull; Wählen - nicht meckern!</title>
		<?php uiMeta(); uiStyles(true); ?>
	</head>
	<body>
		<?php uiHeader(true); uiNavi('question', true); uiSocial() ?>
		
		<!--div id="top-cnt-separator"> </div-->
		
		<div id="cnt">
			<h1>
				<?php echo $q->title ?>
				<span class="description">von <?php echo $q->author ?></span>
			</h1>
			<section>	
				<div id="widgets">
					<div class="question widget">
						<?php echo $q->text ?>
						<div class="widget-controls" data-bind="if: isLoggedIn">
							<p data-bind="if: isLoggedIn">
								<!-- ko with: newAnswerForm -->
								<!-- ko if: show --><a class="button" data-bind="event: { click: submit }">Senden</a><!-- /ko -->
								<a class="button" data-bind="text: show() ? 'ausblenden' : 'Neue Antwort', event: { click: toggle }">Antwort schreiben</a>
								<!-- /ko -->
							</p>
							<!-- ko with: newAnswerForm -->
							<div style="display:inline-block" data-bind="if: show">
								<p><input type="text" style="width:100%" placeholder="Überschrift" data-bind="value: title"/></p>
								<p><textarea style="width:100%" placeholder="Text" data-bind="value: text"></textarea></p>
							</div>
							<!-- /ko -->
						</div>
					</div>
					<h1>Antworten <span class="description">chronologisch sortiert</span></h1>
					<!-- ko foreach: a -->
					<div class="answer widget">
						<h1>
							<span data-bind="text: title"></span>
							<span class="description">von <a data-bind="text: author, attr: { 'href': 'kandidat.php?name=' + author}"></a>
							<span data-bind='if: author == <?php echo json_encode(getLoginName(), JSON_UNESCAPED_UNICODE) ?>'><a data-bind="event: { click: $parent.deleteAnswer.bind($parent, $data) }" class="clickable">löschen</a></span></span>
						</h1>
						<section data-bind="text: text"></section>
					</div>
					<!-- /ko -->
				</div>
			</section>
		</div>
		
		<?php uiFooter(); uiJsAdditional() ?>
		<script tyype="text/javascript">
			var _q = {id: <?php echo json_encode($q->id) ?>, author: <?php echo json_encode(utf8_encode($q->author)) ?>, title: <?php echo json_encode($q->title) ?>, text: <?php echo json_encode($q->text, JSON_UNESCAPED_UNICODE) ?>};
			var _a = <?php echo $atext ?>;
			var _isLoggedIn = <?php echo isLoggedIn() ? 'true' : 'false' ?>;
			var _userName = <?php echo json_encode(utf8_encode(getLoginName())) ?>;
			var root = '/wahl';
		</script>
		<script type="text/javascript" src="frage.js"></script>
	</body>
</html>