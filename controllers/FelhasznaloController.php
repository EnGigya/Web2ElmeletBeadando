<?php
class FelhasznaloController {
    public function regisztracio() {
        require_once 'views/regisztracio.php';
    }

    public function regisztral() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $csaladi_nev = $_POST['csaladi_nev'];
            $utonev = $_POST['utonev'];
            $bejelentkezes = $_POST['bejelentkezes'];
            $jelszo = sha1($_POST['jelszo']);

            // Kapcsolódás az adatbázishoz
            $conn = new mysqli('localhost', 'web222', '1Defektt.', 'web222');
            if ($conn->connect_error) {
                die("Kapcsolódási hiba: " . $conn->connect_error);
            }

            // Beszúrás
            $sql = "INSERT INTO felhasznalok (csaladi_nev, utonev, bejelentkezes, jelszo, jogosultsag)
                    VALUES ('$csaladi_nev', '$utonev', '$bejelentkezes', '$jelszo', '_1_')";

            if ($conn->query($sql) === TRUE) {
                
            } else {
                echo "Hiba: " . $conn->error;
            }
            $conn->close();
        }
    }
}
?>
