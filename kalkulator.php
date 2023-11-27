<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kalkulatory Finansowe</title>
    <link rel="stylesheet" href="kalkulator.css">
</head>
<body>
<header>
<h1>Kalkulatory Finansowe</h1>
</header>
<br>
<section id="kalkulator_kredytowy">
    <h2>Kalkulator kredytowy</h2>
<form action="" method="post">
    <label for="kwt_kredytu">Kwota kredytu:</label>
    <input type="number" name="kwt_kredytu" required>

    <label for="opr_kredytu">Oprocentowanie kredytu:</label>
    <input type="number" name="opr_kredytu" step="0.01" required>

    <label for="okr_kredytu">Okres spłaty kredytu (w miesiącach):</label>
    <input type="number" name="okr_kredytu" required>

    <label for="sps_splt_kredytu">Sposób spłaty kredytu:</label>
    <select name="sps_splt_kredytu" required>
        <option value="staly">Stała rata</option>
        <option value="malejacy">Malejąca rata</option>
    </select>
    <button type="submit">Oblicz</button>
</form>
</section>
<br>
<section id="kalkulator_lokat">
<h2>Kalkulator lokat</h2>
<form action="" method="post">
    <label for="kpt_pcztk_kredytu">Kwota początkowa lokaty:</label>
    <input type="number" name="kpt_pcztk_kredytu" required>
    <label for="opr_lokaty">Oprocentowanie lokaty:</label>
    <input type="number" name="opr_lokaty" step="0.01" required>
    <label for="okres_lokaty">Okres lokaty (w miesiącach):</label>
    <input type="number" name="okres_lokaty" required>
    <label for="kapitalizacja_lokaty">Kapitalizacja lokaty w ciągu roku:</label>
    <input type="number" name="kapitalizacja_lokaty" min="1" max="12" step="1" required>
    <button type="submit">Oblicz</button>
</form>
<?php
function kalkulator_kredytowy($kwt_kredytu, $opr_kredytu, $okr_kredytu, $sps_splt_kredytu) {
    if ($sps_splt_kredytu == "staly") {
        $rata_kredytu = ($kwt_kredytu * ($opr_kredytu / 100)) / 12 / (1 - pow(1 + $opr_kredytu / 100 / 12, -$okr_kredytu));
    } elseif ($sps_splt_kredytu == "malejacy") {
        $rata_kredytu = $kwt_kredytu / $okr_kredytu + ($kwt_kredytu * $opr_kredytu / 100) / 12;
    } else {
        return "Niepoprawny sposób spłaty";
    }
    $calkowita_kwt_kredytu = $rata_kredytu * $okr_kredytu;
    return array($rata_kredytu, $calkowita_kwt_kredytu);
}
function kalkulator_lokaty($kpt_pcztk_kredytu, $opr_lokaty, $okres_lokaty, $kapitalizacja_lokaty) {
    $saldo_lokaty = $kpt_pcztk_kredytu * pow(1 + ($opr_lokaty / 100) / $kapitalizacja_lokaty, $kapitalizacja_lokaty * ($okres_lokaty / 12));
    return $saldo_lokaty;
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$kwt_kredytu = $_POST["kwt_kredytu"];
$opr_kredytu = $_POST["opr_kredytu"];
$okr_kredytu = $_POST["okr_kredytu"];
$sps_splt_kredytu = $_POST["sps_splt_kredytu"];
list($rata_kredytu, $calkowita_kwt_kredytu) = kalkulator_kredytowy($kwt_kredytu, $opr_kredytu, $okr_kredytu, $sps_splt_kredytu);
echo "<h2>Wyniki kalkulatora kredytowego:</h2>";
echo "Rata kredytu wynosi: " . number_format($rata_kredytu, 2) . " PLN<br>";
echo "Całkowita kwota do spłaty wynosi: " . number_format($calkowita_kwt_kredytu, 2) . " PLN<br>";
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
$kpt_pcztk_kredytu = $_POST["kpt_pcztk_kredytu"];
$opr_lokaty = $_POST["opr_lokaty"];
$okres_lokaty = $_POST["okres_lokaty"];
$kapitalizacja_lokaty = $_POST["kapitalizacja_lokaty"];
$saldo_lokaty = kalkulator_lokaty($kpt_pcztk_kredytu, $opr_lokaty, $okres_lokaty, $kapitalizacja_lokaty);
echo "Przyszła wartość lokaty wynosi: " . number_format($saldo_lokaty, 2) . " PLN";
}
?>
</section>
<footer>
    <p> Autorzy: Mikołaj Szomszor, Tomasz Freitag, Krzysztof Gdaniec</p>
</footer>
</body>
</html>