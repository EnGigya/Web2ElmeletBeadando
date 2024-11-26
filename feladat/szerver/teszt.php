<!DOCTYPE HTML>
<html>
  <head>
  <meta charset="utf-8">
  <title>NB1</title>
  </head>

  <?php
     $options = array(
   
   'keep_alive' => false,
    //'trace' =>true,
    //'connection_timeout' => 5000,
    //'cache_wsdl' => WSDL_CACHE_NONE,
   );
  $client = new SoapClient('http://127.0.0.1/web2/feladat/szerver/nb1.wsdl',$options);
  
  $klubok = $client->getklub();
  echo "<pre>";
  print_r($klubok);
  echo "</pre>";
  
  $labdarugok = $client->getlabdarugo('10');
  echo "<pre>";
  print_r($labdarugok);
  echo "</pre>";
  ?>
    
  <body>
  </body>
</html>