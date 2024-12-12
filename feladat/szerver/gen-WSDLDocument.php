<?php
	//error_reporting(0);
	require_once 'nb1.php';
	require_once 'WSDLDocument/WSDLDocument.php';
	$wsdl = new WSDLDocument('Nb1', "http://localhost/feladat/szerver/szerver.php", "http://localhost/feladat/szerver/");
	$wsdl->formatOutput = true;
	$wsdlfile = $wsdl->saveXML();
	echo $wsdlfile;
	file_put_contents ("nb1.wsdl" , $wsdlfile);
?>
