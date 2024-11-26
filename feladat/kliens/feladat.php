<!DOCTYPE HTML>
<html>
  <head>
  <meta charset="utf-8">
  <title>NB1</title>
  </head>

  <?php 
  $client = new SoapClient('http://127.0.0.1/web2/feladat/szerver/nb1.wsdl');
  $klub = $client->getklub();
  if(isset($_POST['klubok']) && trim($_POST['klubok']) != "")
    $labdarugo = $client->getlabdarugo($_POST['klubok']);
  ?>
    
  <body>
    <h1>NB1</h1>
    <form name="klubokselect" method="POST">
      <select name="klubok" onchange="javascript:klubokselect.submit();">
        <option value="">Válasszon ...</option>
        <?php
          foreach($klub->klub as $klubok)
          {
            echo '<option value="'.$klubok['id'].'">'.$klubok['csapatnev'].'</option>';
          }
        ?>
      </select>
        <?php
          if(isset($labdarugo))
          {
            echo "<fieldset>";
            echo '<legend>'.$labdarugo->id.' '.$labdarugo->csapatnev.' játékosai:</legend>';
            foreach($labdarugo->labdarugo as $labdarugok)
            {
              
              echo $labdarugok['vezeteknev'].'  '.$labdarugok['utonev']."<br>";
             
            }
            echo "</fieldset>";
          }
        ?>
    </form>
  </body>                                                          
</html>