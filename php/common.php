<?php

$PARAMETERS = $_GET;

$DEBUG = true;

class OutputData {
	public $success = true;
	public $msgCodes = array();
	public $messages = array();
	public $data = null;
	
	public function updateMessages() {
		$this->msgCodes = array_map("OutputData::outputMsgCode", $this->msgCodes);
		$this->messages = array_map("OutputData::outputMessage", $this->msgCodes);
	} 
	
	public function printThis() {
		$this->updateMessages();
		echo json_encode($this);
	}
	
	public function mergeWith($otherData) {
		$this->success = $this->success && $otherData->success;
		$this->msgCodes = array_merge($otherData->msgCodes, $this->msgCodes);
	}
	
	private static $outputMessages = array(
		'signindata' => 'Die Anmeldedaten sind falsch.',
		'parameters' => 'Es wurden nicht alle Request-Parameter angegeben.',
		'notsignedin' => 'Sie sind nicht angemeldet.',
		'dberror' => 'Die Datenbankabfrage hat nicht funktioniert. Bitte melden Sie das dem Administrator!'
	);
	
	public static function outputMessage($msgCode) {
		global $DEBUG;
		
		if($DEBUG && startsWith($msgCode, 'd:'))
			return $msgCode;
		elseif(startsWith($msgCode, 'c:'))
			return substr($msgCode, 2);
		else
			return OutputData::$outputMessages[$msgCode];
	}
	
	public static function outputMsgCode($msgCode) {
		global $DEBUG;
		
		if($DEBUG && startsWith($msgCode, 'd:'))
			return $msgCode;
		elseif(startsWith($msgCode, 'c:'))
			return $msgCode;
		else
			return $msgCode;
	}
}

function startsWith($str, $begin) {
	return substr($str, 0, strlen($begin)) == $begin;
}

function increaseCounter() {
	global $serverRoot;	
	
  $fp = fopen("$serverRoot/data/counter.txt", "r+");
  $stellen = 10;
  $zahl=fgets($fp,$stellen);
  $zahl++;
  rewind($fp);
  flock($fp,2);
  fputs($fp,$zahl,$stellen);
  flock($fp,3);
  echo $zahl;
  fclose($fp);
}

//increaseCounter();

/*$o = new OutputData();
$o->msgCodes[] = 'parameters';
$o->printThis();*/

?>
