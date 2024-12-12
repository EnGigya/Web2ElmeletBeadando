<?php
// Karakterk�dol�s be�ll�t�sa
header('Content-Type: text/html; charset=utf-8');

// MNB SOAP API el�rhet�s�ge
define('MNB_SOAP_URL', 'https://www.mnb.hu/arfolyamok.asmx?wsdl');

/**
 * MNB SOAP kliens inicializ�l�sa
 */
function getSoapClient() {
    return new SoapClient(MNB_SOAP_URL);
}

/**
 * Valuta �rfolyam�nak lek�rdez�se adott id�szakra
 * @param string $currency A keresett valuta (pl. "EUR")
 * @param string $startDate Az id�szak kezdete (pl. "YYYY-MM-DD")
 * @param string $endDate Az id�szak v�ge (pl. "YYYY-MM-DD")
 * @return array Az �rfolyamadatok napi bont�sban
 */
function getExchangeRates($currency, $startDate, $endDate) {
    try {
        $client = getSoapClient();
        $response = $client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currency,
        ]);
        $ratesXml = simplexml_load_string($response->GetExchangeRatesResult);
        $rates = [];
        foreach ($ratesXml->Day as $day) {
            $date = (string)$day['date'];
            $rate = (string)$day->Rate;
            $rates[$date] = $rate;
        }
        return $rates;
    } catch (Exception $e) {
        return ["error" => $e->getMessage()];
    }
}

// A keres� �rlap feldolgoz�sa
$exchangeRates = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $currency = strtoupper(trim($_POST['currency'] ?? ''));
    if ($currency) {
        $startDate = date("Y-m-01", strtotime("-1 month")); // Az elm�lt h�nap els� napja
        $endDate = date("Y-m-t", strtotime("-1 month"));   // Az elm�lt h�nap utols� napja
        $exchangeRates = getExchangeRates($currency, $startDate, $endDate);
    }
}
?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Valuta�rfolyam keres�</title>
</head>
<body>
    <h1>Valuta</h1>
    <form method="post" action="">
        <label for="currency">Keresett valuta (pl. EUR):</label>
        <input type="text" id="currency" name="currency" required>
        <button type="submit">Keres</button>
    </form>

    <?php if (!empty($exchangeRates) && !isset($exchangeRates['error'])): ?>
        
        <table border="1">
            <tr>
                <th>Datum</th>
                <th>HUF / <?php echo htmlspecialchars($currency); ?></th>
            </tr>
            <?php foreach ($exchangeRates as $date => $rate): ?>
                <tr>
                    <td><?php echo htmlspecialchars($date); ?></td>
                    <td><?php echo htmlspecialchars($rate); ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php elseif (isset($exchangeRates['error'])): ?>
        <p>Hiba t�rt�nt: <?php echo htmlspecialchars($exchangeRates['error']); ?></p>
    <?php endif; ?>
</body>
</html>
