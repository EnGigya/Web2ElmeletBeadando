<h2>Belépés</h2>
<form action="<?= SITE_ROOT ?>beleptet" method="post">
<fieldset>
        <legend>Bejlentkezés</legend>
        <br>
        <input type="text" name="login" id="login" placeholder="felhasználói név" required pattern="[a-zA-Z][\-\.a-zA-Z0-9_]{3}[\-\.a-zA-Z0-9_]+"><br><br>
        <input type="password" name="password" id="password" placeholder="jelszó" required pattern="[\-\.a-zA-Z0-9_]{4}[\-\.a-zA-Z0-9_]+"><br><br>
        <input type="submit"  value="Küldés">
        <br>&nbsp;
      </fieldset>
<h2><br><?= (isset($viewData['uzenet']) ? $viewData['uzenet'] : "") ?><br></h2>


