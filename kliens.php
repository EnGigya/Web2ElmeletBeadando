<?php
require_once "szerver.php";
$result = "";

// Ellenőrizzük, hogy van-e POST adat
if (isset($_POST['id'])) {
    // Felesleges szóközök eltávolítása
    $_POST['id'] = trim($_POST['id']);
    $_POST['csn'] = trim($_POST['csn']);
    $_POST['un'] = trim($_POST['un']);
    $_POST['bn'] = trim($_POST['bn']);
    $_POST['jel'] = trim($_POST['jel']);

    // Ha nincs id, de minden más adatot megadtak, beszúrás
    if ($_POST['id'] == "" && $_POST['csn'] != "" && $_POST['un'] != "" && $_POST['bn'] != "" && $_POST['jel'] != "") {
        $data = [
            "csn" => $_POST["csn"],
            "un" => $_POST["un"],
            "bn" => $_POST["bn"],
            "jel" => sha1($_POST["jel"])
        ];
        $result = sendRequest($url, "POST", $data);
    }
    // Ha nincs id, de nem adtak meg minden adatot, hibaüzenet
    elseif ($_POST['id'] == "") {
        $result = "Hiba: Hiányos adatok!";
    }
    // Ha van id, és legalább egy adatot megadtak, módosítás
    elseif ($_POST['id'] >= 1 && ($_POST['csn'] != "" || $_POST['un'] != "" || $_POST['bn'] != "" || $_POST['jel'] != "")) {
        $data = [
            "id" => $_POST["id"],
            "csn" => $_POST["csn"],
            "un" => $_POST["un"],
            "bn" => $_POST["bn"],
            "jel" => $_POST["jel"]
        ];
        $result = sendRequest($url, "PUT", $data);
    }
    // Ha van id, de nem adtak meg semmilyen adatot, törlés
    elseif ($_POST['id'] >= 1) {
        $data = ["id" => $_POST["id"]];
        $result = sendRequest($url, "DELETE", $data);
    }
    // Ha az id érvénytelen, hibaüzenet
    else {
        $result = "Hiba: Rossz azonosító (Id): " . $_POST['id'];
    }
}

// A felhasználók lekérdezése
$tabla = fetchData($url);

// Funkció a HTTP kérés küldésére
function sendRequest($url, $method, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

// Funkció a felhasználók adatainak lekérésére
function fetchData($url)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    return $response;
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="utf-8">
    <title>REST GYAKORLAT</title>
</head>
<body>
    <p><?= htmlspecialchars($result) ?></p>
    <h1>Felhasználók:</h1>
    <pre><?= htmlspecialchars($tabla) ?></pre>
    <br>
    <h2>Módosítás / Beszúrás</h2>
    <form method="post">
        Id: <input type="text" name="id"><br><br>
        Családi név: <input type="text" name="csn" maxlength="45"> Utónév: <input type="text" name="un" maxlength="45"><br><br>
        Bejelentkezési név: <input type="text" name="bn" maxlength="12"> Jelszó: <input type="text" name="jel"><br><br>
        <input type="submit" value="Küldés">
    </form>
</body>
</html>
