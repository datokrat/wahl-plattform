<?php
$serverRoot = "..";
require_once("$serverRoot/php/mysql.php");
require_once("$serverRoot/php/session.php");
require_once("$serverRoot/php/login.php");
require_once("$serverRoot/php/ui.php");

initSession();

isset($_GET['id']) or isset($_GET['name']) or die('Du musst einen Kandidaten ausw&auml;hlen.');
$id = intval($_GET['id']);

initSession();
initDatabase();

$name = $db->real_escape_string($_GET['name']);

$where = "FALSE";
if(isset($_GET['id']))
	$where = "`id`={$id}";
else if(isset($_GET['name']))
	$where = "`name`='{$name}'";
$query = "SELECT `id`, `name`, `desc`, `imgtype`, `party`, `tags` FROM `wahl_members` WHERE $where";
$res = $db->query($query);


if($res->num_rows == 1) {
	$a = $res->fetch_object();
	$id = $a->id;
	$name = $a->name;
	$desc = $a->desc;
	$party = $a->party;
	$tags = $a->tags;
	$hasPic = $a->imgtype != null;
	$canEdit = $id == getLoginId();
}
else 
	die('Der Kandidat wurde leider nicht gefunden!');

$query = "SELECT `wahl_answers`.`id` AS `id`, `wahl_answers`.`title` AS `title`, `wahl_answers`.`text`AS `text`, `wahl_answers`.`question` AS `question`, `wahl_questions`.`title` AS `question_title`, `wahl_questions`.`text` AS `question_text`, `wahl_answers`.`text` FROM `wahl_answers` JOIN `wahl_questions` ON `wahl_answers`.`question`=`wahl_questions`.`id` WHERE `wahl_answers`.`author`='{$db->real_escape_string($name)}'";
$res = $db->query($query);

if(!$db->errno) {
	$answers = array_map(function($ans) { return (object)$ans; }, $res->fetch_all(MYSQLI_ASSOC));
}
else {
	echo $db->error;
}

closeDatabase();

?>

<!doctype html>
<html>
	<head>
		<title>Kandidatenbefragung zur Kommunalwahl &bull; Wählen - nicht meckern!</title>
		<?php uiMeta(); uiStyles(true); ?>
	</head>
	<body>
		<?php uiHeader(true); uiNavi('candidate', true); uiSocial() ?>
		
		<!--div id="top-cnt-separator"> </div-->
		
		<div id="cnt">
			<h1>
				<?php echo $name ?>
				<span class="description">
					<!-- ko if: hideFormChangeParty --><span data-bind="text: party"></span><!-- /ko -->
					<!-- ko if: !hideFormChangeParty() --><input placeholder="Partei, z.B. 'unabhängig'" type="text" data-bind="value: newParty" /><button data-bind="event: { click: onClickChangeParty }">Ändern</button><!-- /ko -->
					<?php if($canEdit) { ?><a class="clickable" data-bind="event: { click: onClickFormChangeParty }">(Partei ändern)</a><?php } ?>
				</span>
			</h1>
			<section>	
				<div id="widgets">
					<div class="big widget">
						<h1>Bild</h1>
						<?php if($hasPic) { ?>
						<img class="avatar" src="getpic.php?id=<?php echo $id ?>" />
						<?php } ?>
						<?php if($canEdit) { ?><form method="POST" action="picture.php" enctype="multipart/form-data">
							<input type="file" name="picture" maxlength="1000000" />
							<input type="submit" value="Neues Foto hochladen" />
						</form><?php } ?>
						<h1>Kurzbeschreibung <span class="description">
						<?php if($canEdit) { ?>NEU: bis zu 400 Zeichen!
							<a class="clickable" data-bind="event: { click: desc.onClickChange }">ändern</a>
						<?php } ?></span></h1>
						<!-- ko if: !desc.showChangeForm() -->
						<p><span data-bind="text: desc.value"></span> </p>
						<!--b>Tags:</b> <span data-bind="text: tags() ? tags() : '(keine)'"></span-->
						<!-- /ko -->
						<?php if($canEdit) { ?><div data-bind="if: desc.showChangeForm">
							<textarea class="fill" placeholder="Kurzbeschreibung" maxlength="400" data-bind="value: desc.newValue"></textarea>
							<!--p>Tags: <input type="text" class="fill" placeholder="Beispiel: #Umwelt, #Bildung" maxlength="120" data-bind="value: newTags"></textarea></p>
							--><button data-bind="event: { click: desc.change }">Ändern</button>
						</div><?php } ?>
					</div>
					<h1>Antworten</h1>
					<!-- ko foreach: answers -->
					<div class="widget">
						Frage: <a data-bind="text: question_title, attr: { href: 'frage.php?id=' + question }"></a>
						<!--span data-bind="text: question_text"></span-->
						<h1>Antwort: <span data-bind="text: title"></span> <span class="description">
							<?php if ($canEdit) { ?><a class="clickable" data-bind="click: $parent.deleteAnswer.bind($parent, $data)">löschen</a><?php } ?>
						</span></h1>
						<span data-bind="text: text"></span>
					</div>
					<!-- /ko -->
				</div>
			</section>
		</div>
		
		<?php uiFooter(); uiJsAdditional() ?>
		<script type="text/javascript">
			var _desc = <?php echo json_encode($desc) ?>;
			var _party = <?php echo json_encode($party) ?>;
			var _tags = <?php echo json_encode($tags) ?>;
			var _answers = <?php echo json_encode($answers) ?>;
			var root = '/wahl';
		</script>
		<script type="text/javascript" src="../lib/jquery.js"></script>
		<script type="text/javascript" src="knockout-3.0.0.js"></script>
		<script type="text/javascript" src="kandidat.js"></script>
	</body>
</html>