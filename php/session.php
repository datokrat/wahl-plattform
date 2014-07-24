<?php

function initSession() {
	session_start();
}

function renewSession() {
	unset($_SESSION['name']);
}

?>