<?php
	// tutti i dati dei tests sono contenuti in tests.json
	// basta aggiungere un nuovo testo per aggiungere un nuovo livello
	
	if (!isset($_GET['parola'])) {
		die("0");
	}
	
	$parola = $_GET['parola'];
	
	if (isset($_COOKIE['level']))
		$level = $_COOKIE['level'];
	else
		die ("0");
		
	$json = json_decode(file_get_contents("tests.json"), true);
	
	if (strtolower($json[$level]["word"]) == strtolower($parola)) {
		$level ++;
		setcookie("level", $level);
		die ("1");	
	}
	else die("0");
?>