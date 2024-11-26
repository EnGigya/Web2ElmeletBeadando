<?php
	//error_reporting(0);
	require 'nb1.php';
	require 'WSDLDocument/WSDLDocument.php';
	$wsdl = new WSDLDocument('Nb1', "http://127.0.0.1/web2/feladat/szerver/szerver.php", "http://127.0.0.1/web2/feladat/szerver/");
	$wsdl->formatOutput = true;
	$wsdlfile = $wsdl->saveXML();
	echo $wsdlfile;
	file_put_contents ("nb1.wsdl" , $wsdlfile);
?>
