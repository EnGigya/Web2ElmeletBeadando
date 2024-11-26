<?php
$url = "http://localhost/web2/restful/szerver.php";
$result = "";
if(isset($_POST['id']))
{
  // Felesleges szóközök eldobása
  $_POST['id'] = trim($_POST['id']);
  $_POST['csn'] = trim($_POST['csn']);
  $_POST['un'] = trim($_POST['un']);
  $_POST['bn'] = trim($_POST['bn']);
  $_POST['jel'] = trim($_POST['jel']);
  
  // Ha nincs id és megadtak minden adatot (családi név, utónév, bejelentkezési név, jelszó), akkor beszúrás
  if($_POST['id'] == "" && $_POST['csn'] != "" && $_POST['un'] != "" && $_POST['bn'] != "" && $_POST['jel'] != "")
  {
      $data = Array("csn" => $_POST["csn"], "un" => $_POST["un"], "bn" => $_POST["bn"], "jel" => sha1($_POST["jel"]));
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_POST, 1);
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      curl_close($ch);
  }
  
  // Ha nincs id de nem adtak meg minden adatot
  elseif($_POST['id'] == "")
  {
    $result = "Hiba: Hiányos adatok!";
  }
  
  // Ha van id, amely >= 1, és megadták legalább az egyik adatot (családi név, utónév, bejelentkezési név, jelszó), akkor módosítás
  elseif($_POST['id'] >= 1 && ($_POST['csn'] != "" || $_POST['un'] != "" || $_POST['bn'] != "" || $_POST['jel'] != ""))
  {
      $data = Array("id" => $_POST["id"], "csn" => $_POST["csn"], "un" => $_POST["un"], "bn" => $_POST["bn"], "jel" => $_POST["jel"]);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      curl_close($ch);
  }
  
  // Ha van id, amely >=1, de nem adtak meg legalább az egyik adatot
  elseif($_POST['id'] >= 1)
  {
      $data = Array("id" => $_POST["id"]);
      $ch = curl_init($url);
      curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
      curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
      $result = curl_exec($ch);
      curl_close($ch);
  }
  
  // Ha van id, de rossz az id, akkor a hiba kiírása
  else
  {
    echo "Hiba: Rossz azonosító (Id): ".$_POST['id']."<br>";
  }
}

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$tabla = curl_exec($ch);
curl_close($ch);

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>REST GYAKORLAT</title>
</head>
<body>
    <?= $result ?>
    <h1>Felhasználók:</h1>
    <?= $tabla ?>
    <br>
    <h2>Módosítás / Beszúrás</h2>
    <form method="post">
    Id: <input type="text" name="id"><br><br>
    Családi név: <input type="text" name="csn" maxlength="45"> Utónév: <input type="text" name="un" maxlength="45"><br><br>
    Bejelentkezési név: <input type="text" name="bn" maxlength="12"> Jelszó: <input type="text" name="jel"><br><br>
    <input type="submit" value = "Küldés">
    </form>
</body>
</html>
