<?php
// Adatbázis kapcsolat beállítása
$servername = "localhost"; // Állítsd be a megfelelő host nevet
$username = "web222"; // Állítsd be a felhasználónevet
$password = "1Defektt."; // Állítsd be a jelszót
$dbname = "web222"; // Állítsd be az adatbázis nevét

$conn = new mysqli($servername, $username, $password, $dbname);

// Kapcsolati hiba ellenőrzése
if ($conn->connect_error) {
    die("Kapcsolati hiba: " . $conn->connect_error);
}

// CRUD műveletek kezelése
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Új felhasználó hozzáadása
    if (isset($_POST['add'])) {
        $csaladi_nev = $_POST['csaladi_nev'];
        $utonev = $_POST['utonev'];
        $bejelentkezes = $_POST['bejelentkezes'];
        $jelszo = $_POST['jelszo'];
        $jogosultsag = $_POST['jogosultsag'];

        $stmt = $conn->prepare("INSERT INTO felhasznalok (csaladi_nev, utonev, bejelentkezes, jelszo, jogosultsag) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $csaladi_nev, $utonev, $bejelentkezes, $jelszo, $jogosultsag);
        $stmt->execute();
        $stmt->close();
    }

    // Felhasználó módosítása
    if (isset($_POST['update'])) {
        $id = $_POST['id'];
        $csaladi_nev = $_POST['csaladi_nev'];
        $utonev = $_POST['utonev'];
        $bejelentkezes = $_POST['bejelentkezes'];
        $jelszo = $_POST['jelszo'];
        $jogosultsag = $_POST['jogosultsag'];

        $stmt = $conn->prepare("UPDATE felhasznalok SET csaladi_nev=?, utonev=?, bejelentkezes=?, jelszo=?, jogosultsag=? WHERE id=?");
        $stmt->bind_param("sssssi", $csaladi_nev, $utonev, $bejelentkezes, $jelszo, $jogosultsag, $id);
        $stmt->execute();
        $stmt->close();
    }

    // Felhasználó törlése
    if (isset($_POST['delete'])) {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM felhasznalok WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

// Felhasználók lekérdezése
$result = $conn->query("SELECT * FROM felhasznalok");

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD Menü</title>
</head>
<body>
    <h1>Felhasználók kezelése</h1>

    <!-- Új felhasználó hozzáadása -->
    <form method="POST">
        <h2>Új felhasználó hozzáadása</h2>
        <input type="text" name="csaladi_nev" placeholder="Családi név" required>
        <input type="text" name="utonev" placeholder="Utónév" required>
        <input type="text" name="bejelentkezes" placeholder="Bejelentkezés" required>
        <input type="text" name="jelszo" placeholder="Jelszó" required>
        <input type="text" name="jogosultsag" placeholder="Jogosultság" required>
        <button type="submit" name="add">Hozzáadás</button>
    </form>

    <!-- Felhasználók táblázatban megjelenítése -->
    <h2>Felhasználók</h2>
    <p>A táblázat mezőiben írja át a módosítíni kívánt adatot</p>
    <table border="1">
        <thead>
            <tr>
                <th>ID</th>
                <th>Családi név</th>
                <th>Utónév</th>
                <th>Bejelentkezés</th>
               
                <th>Jogosultság</th>
                <th>Műveletek</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <form method="POST">
                        <td><input type="hidden" name="id" value="<?= $row['id'] ?>"><?= $row['id'] ?></td>
                        <td><input type="text" name="csaladi_nev" value="<?= $row['csaladi_nev'] ?>"></td>
                        <td><input type="text" name="utonev" value="<?= $row['utonev'] ?>"></td>
                        <td><input type="text" name="bejelentkezes" value="<?= $row['bejelentkezes'] ?>"></td>
                      
                        <td><input type="text" name="jogosultsag" value="<?= $row['jogosultsag'] ?>"></td>
                        <td>
                            <button type="submit" name="update">Módosítás</button>
                           
                            <button type="submit" name="delete" onclick="return confirm('Biztosan törlöd?')">Törlés</button>
                        </td>
                   </form>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$conn->close();
?>
