<?php
// Adatbázis kapcsolat beállítása
$servername = "localhost";
$username = "web222";
$password = "1Defektt.";
$dbname = "web222";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Kapcsolódási hiba: " . $conn->connect_error);
}

// HTTP metódus kezelése
$method = $_SERVER['REQUEST_METHOD'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;

switch ($method) {
    case 'GET':
        if ($id) {
            getUser($conn, $id);
        } else {
            getAllUsers($conn);
        }
        break;
    case 'POST':
        createUser($conn);
        break;
    case 'PUT':
        updateUser($conn, $id);
        break;
    case 'DELETE':
        deleteUser($conn, $id);
        break;
    default:
        echo json_encode(["message" => "Nem támogatott HTTP metódus"]);
}

$conn->close();

// Felhasználók listázása
function getAllUsers($conn) {
    $sql = "SELECT id, csaladi_nev, utonev, bejelentkezes, jogosultsag FROM felhasznalok";
    $result = $conn->query($sql);

    $users = [];
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
    echo json_encode($users);
}

// Egyetlen felhasználó lekérdezése
function getUser($conn, $id) {
    $stmt = $conn->prepare("SELECT id, csaladi_nev, utonev, bejelentkezes, jogosultsag FROM felhasznalok WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    echo json_encode($result->fetch_assoc());
    $stmt->close();
}

// Új felhasználó létrehozása
function createUser($conn) {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare("INSERT INTO felhasznalok (csaladi_nev, utonev, bejelentkezes, jelszo, jogosultsag) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $data['csaladi_nev'], $data['utonev'], $data['bejelentkezes'], password_hash($data['jelszo'], PASSWORD_DEFAULT), $data['jogosultsag']);

    if ($stmt->execute()) {
        echo json_encode(["id" => $conn->insert_id, "message" => "Felhasználó létrehozva"]);
    } else {
        echo json_encode(["message" => "Hiba történt a felhasználó létrehozása közben"]);
    }

    $stmt->close();
}

// Felhasználó frissítése
function updateUser($conn, $id) {
    $data = json_decode(file_get_contents("php://input"), true);

    $stmt = $conn->prepare("UPDATE felhasznalok SET csaladi_nev = ?, utonev = ?, bejelentkezes = ?, jogosultsag = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $data['csaladi_nev'], $data['utonev'], $data['bejelentkezes'], $data['jogosultsag'], $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Felhasználó frissítve"]);
    } else {
        echo json_encode(["message" => "Hiba történt a frissítés közben"]);
    }

    $stmt->close();
}

// Felhasználó törlése
function deleteUser($conn, $id) {
    $stmt = $conn->prepare("DELETE FROM felhasznalok WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo json_encode(["message" => "Felhasználó törölve"]);
    } else {
        echo json_encode(["message" => "Hiba történt a törlés közben"]);
    }

    $stmt->close();
}
?>
