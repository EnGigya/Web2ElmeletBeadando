<?php
// Magyar Nemzeti Bank SOAP URL
$soapUrl = "http://www.mnb.hu/arfolyamok.asmx?wsdl";

// SOAP kliens létrehozása
$client = new SoapClient($soapUrl);

// Devizapárok listája
$currencyPairs = [
    'EUR-HUF', 'EUR-USD', 'USD-HUF',
    'CHF-HUF', 'CHF-EUR', 'CHF-USD',
    'AUD-HUF', 'AUD-USD', 'AUD-EUR'
];

// Egy hónappal ezelőtti és mai dátum meghatározása
$endDate = date('Y-m-d');
$startDate = date('Y-m-d', strtotime('-1 month'));

// Egyedi devizaárfolyamok lekérése
function getExchangeRates($client, $currency, $startDate, $endDate) {
    try {
        $result = $client->GetExchangeRates([
            'startDate' => $startDate,
            'endDate' => $endDate,
            'currencyNames' => $currency
        ]);

        $xml = simplexml_load_string($result->GetExchangeRatesResult);
        $rates = [];

        foreach ($xml->Day as $day) {
            $date = (string) $day["date"];
            foreach ($day->Rate as $rate) {
                $rates[$date] = (float) $rate;
            }
        }

        return $rates;
    } catch (Exception $e) {
        echo "Hiba történt: " . $e->getMessage();
        return [];
    }
}

// Ha a felhasználó kiválasztott egy devizapárt
$selectedPair = $_POST['currencyPair'] ?? null;
$rates = [];

if ($selectedPair) {
    // Devizapár szétbontása bázis- és idézett devizára
    [$baseCurrency, $quoteCurrency] = explode('-', $selectedPair);

    if ($quoteCurrency === 'HUF') {
        // Ha az idézett deviza HUF, csak a bázisdevizát kérjük le
        $baseRates = getExchangeRates($client, $baseCurrency, $startDate, $endDate);
        foreach ($baseRates as $date => $baseRate) {
            $rates[] = [
                'date' => $date,
                'rate' => $baseRate
            ];
        }
    } elseif ($baseCurrency === 'HUF') {
        // Ha a bázisdeviza HUF, csak az idézett devizát kérjük le és számoljuk a reciprokt
        $quoteRates = getExchangeRates($client, $quoteCurrency, $startDate, $endDate);
        foreach ($quoteRates as $date => $quoteRate) {
            if ($quoteRate != 0) {
                $rates[] = [
                    'date' => $date,
                    'rate' => 1 / $quoteRate
                ];
            }
        }
    } else {
        // Normál esetben mindkét devizát lekérjük
        $baseRates = getExchangeRates($client, $baseCurrency, $startDate, $endDate);
        $quoteRates = getExchangeRates($client, $quoteCurrency, $startDate, $endDate);

        foreach ($baseRates as $date => $baseRate) {
            if (isset($quoteRates[$date]) && $quoteRates[$date] != 0) {
                $rates[] = [
                    'date' => $date,
                    'rate' => $baseRate / $quoteRates[$date]
                ];
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devizaárfolyamok</title>
</head>
<body>
    <h1>Magyar Nemzeti Bank Devizaárfolyamok</h1>

    <!-- Legördülő menü -->
    <form method="POST">
        <label for="currencyPair">Válasszon egy devizapárt:</label>
        <select name="currencyPair" id="currencyPair">
            <?php foreach ($currencyPairs as $pair): ?>
                <option value="<?= $pair ?>" <?= $selectedPair === $pair ? 'selected' : '' ?>>
                    <?= $pair ?>
                </option>
            <?php endforeach; ?>
        </select>
        <button type="submit">Lekérdezés</button>
    </form>

    <!-- Eredmények megjelenítése -->
    <?php if ($rates): ?>
        <h2>Árfolyamok: <?= htmlspecialchars($selectedPair) ?></h2>
        <table border="1">
            <thead>
                <tr>
                    <th>Dátum</th>
                    <th>Árfolyam</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rates as $rate): ?>
                    <tr>
                        <td><?= htmlspecialchars($rate['date']) ?></td>
                        <td><?= htmlspecialchars(number_format($rate['rate'], 4)) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php elseif ($selectedPair): ?>
        <p>Nincs elérhető adat az adott időszakra és devizapárra.</p>
    <?php endif; ?>
</body>
</html>
