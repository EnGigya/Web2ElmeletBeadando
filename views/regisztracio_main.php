<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Regisztr�ci�</title>
</head>
<body>
    <h1>Regisztracio</h1>
    <form action="index.php?felhasznalo=regisztral" method="POST">
        <label for="csaladi_nev">Csaladi nev:</label>
        <input type="text" id="csaladi_nev" name="csaladi_nev" required><br><br>

        <label for="utonev">Utonev:</label>
        <input type="text" id="utonev" name="utonev" required><br><br>

        <label for="bejelentkezes">Felhasznalo nev:</label>
        <input type="text" id="bejelentkezes" name="bejelentkezes" required><br><br>

        <label for="jelszo">Jelszo:</label>
        <input type="password" id="jelszo" name="jelszo" required><br><br>

        <label for="jogosultsag">Jogosultság:</label>
        <input type="text" id="jogosultsag" name="jogosultsag" required><br><br>

        
      
        <button type="submit">Regisztracio</button>
    </form>






</body>

</html>
