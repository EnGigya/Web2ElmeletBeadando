<?php

$eredmeny = "";
try {
	$dbh = new PDO('mysql:host=localhost;dbname=web2', 'root', '',
				  array(PDO::ATTR_ERRMODE=>PDO::ERRMODE_EXCEPTION));
	$dbh->query('SET NAMES utf8 COLLATE utf8_hungarian_ci');
	switch($_SERVER['REQUEST_METHOD']) {
		case "GET":
				$sql = "SELECT * FROM felhasznalok";     
				$sth = $dbh->query($sql);
				$eredmeny .= "<table style=\"border-collapse: collapse;\"><tr><th></th><th>Családi név</th><th>Utónév</th><th>Login név</th><th>Kódolt jelszó</th></tr>";
				while($row = $sth->fetch(PDO::FETCH_ASSOC)) {
					$eredmeny .= "<tr>";
					foreach($row as $column)
						$eredmeny .= "<td style=\"border: 1px solid black; padding: 3px;\">".$column."</td>";
					$eredmeny .= "</tr>";
				}
				$eredmeny .= "</table>";
			break;
		case "POST":
				$incoming = file_get_contents("php://input");
				parse_str($incoming, $data);
				/*
				echo $incoming;
				print_r($data);
				print_r($_POST);
				*/
				$sql = "insert into felhasznalok values (0, :csn, :un, :bn, :jel)";
				$sth = $dbh->prepare($sql);
				$count = $sth->execute(Array(":csn"=>$data["csn"], ":un"=>$data["un"], ":bn"=>$data["bn"], ":jel"=>$data["jel"]));
				//$count = $sth->execute(Array(":csn"=>$_POST["csn"], ":un"=>$_POST["un"], ":bn"=>$_POST["bn"], ":jel"=>$_POST["jel"]));				
				$newid = $dbh->lastInsertId();
				$eredmeny .= $count." beszúrt sor: ".$newid;
			break;
		case "PUT":
				$data = array();
				$incoming = file_get_contents("php://input");
				parse_str($incoming, $data);
				$modositando = "id=id"; $params = Array(":id"=>$data["id"]);
				if($data['csn'] != "") {$modositando .= ", csaladi_nev = :csn"; $params[":csn"] = $data["csn"];}
				if($data['un'] != "") {$modositando .= ", utonev = :un"; $params[":un"] = $data["un"];}
				if($data['bn'] != "") {$modositando .= ", bejelentkezes = :bn"; $params[":bn"] = $data["bn"];}
				if($data['jel'] != "") {$modositando .= ", jelszo = :jel"; $params[":jel"] = sha1($data["jel"]);}
				$sql = "update felhasznalok set ".$modositando." where id=:id";
				$sth = $dbh->prepare($sql);
				$count = $sth->execute($params);
				$eredmeny .= $count." módositott sor. Azonosítója:".$data["id"];
			break;
		case "DELETE":
				$data = array();
				$incoming = file_get_contents("php://input");
				parse_str($incoming, $data);
				$sql = "delete from felhasznalok where id=:id";
				$sth = $dbh->prepare($sql);
				$count = $sth->execute(Array(":id" => $data["id"]));
				$eredmeny .= $count." sor törölve. Azonosítója:".$data["id"];
			break;
	}
}
catch (PDOException $e) {
	$eredmeny = $e->getMessage();
}
echo $eredmeny;

?>