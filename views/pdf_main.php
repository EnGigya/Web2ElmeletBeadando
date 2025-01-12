<?php
require_once('tcpdf/tcpdf.php'); // TCPDF könyvtár betöltése

// Adatbázis kapcsolat
$servername = "localhost";
$username = "web222";
$password = "1Defektt.";
$dbname = "web222";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lekérdezések és űrlap feldolgozás
$klubok = $conn->query("SELECT id, csapatnev FROM klub");
$labdarugok = [];
$poszt = [];
$selectedKlub = $_POST['klub'] ?? null;
$selectedLabdarugo = $_POST['labdarugo'] ?? null;

if ($selectedKlub) {
    $labdarugok = $conn->query("SELECT id, CONCAT(vezeteknev, ' ', utonev) AS nev FROM labdarugo WHERE klubid = $selectedKlub");
}

if ($selectedLabdarugo) {
    $poszt = $conn->query("SELECT poszt.nev AS poszt FROM labdarugo JOIN poszt ON labdarugo.posztid = poszt.id WHERE labdarugo.id = $selectedLabdarugo");
    $posztData = $poszt->fetch_assoc();
}

// PDF generálás külön kérésként
if (isset($_POST['generate_pdf'])) {
    // Buffer kiürítése a biztonság kedvéért
    ob_end_clean();

    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('helvetica', '', 12);

    $klubNev = $conn->query("SELECT csapatnev FROM klub WHERE id = $selectedKlub")->fetch_assoc()['csapatnev'];
    $jatekNev = $conn->query("SELECT CONCAT(vezeteknev, ' ', utonev) AS nev FROM labdarugo WHERE id = $selectedLabdarugo")->fetch_assoc()['nev'];

    $pdf->Write(0, "Klub: $klubNev\n", '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, "Labdarúgó: $jatekNev\n", '', 0, 'L', true, 0, false, false, 0);
    $pdf->Write(0, "Poszt: {$posztData['poszt']}\n", '', 0, 'L', true, 0, false, false, 0);

    // PDF letöltési fejlécek beállítása
    header('Content-Type: application/pdf');
    header('Content-Disposition: attachment; filename="adatok.pdf"');
    $pdf->Output('adatok.pdf', 'D');
    exit;
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <title>Labdarúgó Lekérdezés</title>
</head>
<body>
<form method="post">
    <label for="klub">Válassz klubot:</label>
    <select name="klub" id="klub" onchange="this.form.submit()">
        <option value="">-- Válassz --</option>
        <?php while ($row = $klubok->fetch_assoc()): ?>
            <option value="<?= $row['id'] ?>" <?= isset($selectedKlub) && $selectedKlub == $row['id'] ? 'selected' : '' ?>><?= $row['csapatnev'] ?></option>
        <?php endwhile; ?>
    </select>

    <?php if (!empty($labdarugok) && $selectedKlub): ?>
        <label for="labdarugo">Válassz labdarúgót:</label>
        <select name="labdarugo" id="labdarugo" onchange="this.form.submit()">
            <option value="">-- Válassz --</option>
            <?php while ($row = $labdarugok->fetch_assoc()): ?>
                <option value="<?= $row['id'] ?>" <?= isset($selectedLabdarugo) && $selectedLabdarugo == $row['id'] ? 'selected' : '' ?>><?= $row['nev'] ?></option>
            <?php endwhile; ?>
        </select>
    <?php endif; ?>

    <?php if (!empty($poszt) && $selectedLabdarugo): ?>
        <label>Poszt:</label>
        <span><?= $posztData['poszt'] ?></span><br>
        <button type="submit" name="generate_pdf">PDF Generálása</button>
    <?php endif; ?>
</form>
</body>
</html>
