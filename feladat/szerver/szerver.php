<?php
	require("nb1.php");
	$server = new SoapServer("nb1.wsdl");
	$server->setClass('Nb1');
	$server->handle();
?>