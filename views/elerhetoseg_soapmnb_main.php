
<h1 id="mnb">MNB ADATOK</h1>
<?php
// Az MNB SOAP WSDL URL-je
$wsdlUrl = "https://www.mnb.hu/arfolyamok.asmx?WSDL";

try {
    // SOAP kliens létrehozása
    $client = new SoapClient($wsdlUrl);

    // A megfelelő metódus meghívása a jelenlegi árfolyamok lekérésére
    $response = $client->GetCurrentExchangeRates();

    // Az eredmény XML formátumban érkezik, ezért dolgozzuk fel
    $xml = simplexml_load_string($response->GetCurrentExchangeRatesResult);

    if ($xml === FALSE) {
        throw new Exception("Hiba az XML feldolgozása során!");
    }

    // HTML táblázat generálása
    echo "<table border='1' cellspacing='0' cellpadding='5'>";
    echo "<tr><th>Dátum</th><th>Deviza</th><th>Egység</th><th>HUF Árfolyam</th></tr>";

    foreach ($xml->Day->Rate as $rate) {
        $currency = (string)$rate['curr'];
        $unit = (string)$rate['unit'];
        $value = (string)$rate;
        $date = (string)$xml->Day['date'];

        echo "<tr>";
        echo "<td>" . htmlspecialchars($date) . "</td>";
        echo "<td>" . htmlspecialchars($currency) . "</td>";
        echo "<td>" . htmlspecialchars($unit) . "</td>";
        echo "<td>" . htmlspecialchars($value) . "</td>";
        echo "</tr>";
    }

    echo "</table>";
} catch (SoapFault $fault) {
    // SOAP hiba esetén hibajelzés
    echo "SOAP Hiba: " . htmlspecialchars($fault->getMessage());
} catch (Exception $e) {
    // Egyéb hiba esetén hibajelzés
    echo "Hiba: " . htmlspecialchars($e->getMessage());
}
?>
