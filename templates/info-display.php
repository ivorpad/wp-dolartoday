<?php

// Block direct requests
if ( !defined('ABSPATH') )
  die('-1');

$dolartoday = dt_get_api_response('https://s3.amazonaws.com/dolartoday/data.json', 'dt_dolar_today_transient');
$bitcoin = dt_get_api_response('https://www.bitstamp.net/api/v2/ticker/btcusd/', 'dt_bitcoin_transient');

$avg_usd = ($dolartoday->USD->transferencia + $dolartoday->USD->efectivo_cucuta) / 2;
$avg_eur = ($dolartoday->EUR->transferencia + $dolartoday->EUR->efectivo_cucuta) / 2;

?>
 <h4> ($) USD </h4>
 <div class="dolartoday-display usd">

 <?php
echo '<b>' . ucfirst(strtolower($dolartoday->_labels->a)) . '</b>: ' . round($dolartoday->USD->transferencia) . ' BsF <br />';
echo '<b>' . ucfirst(strtolower($dolartoday->_labels->a1)) . '</b>: ' . round($dolartoday->USD->efectivo_cucuta) . ' BsF <br />';
echo '<b>' . 'USD Paralelo Promedio</b>: ' . round($avg_usd) . ' BsF<br />';
?>
 </div>
<div class="dolartoday-display eur"> 
<h4> (€) EUR </h4>
<?php
echo '<b>' . "Transferencia</b>:  " . ' ' . round($dolartoday->EUR->transferencia) . ' BsF <br />';
echo '<b>' . "Cucuta (transfer)</b>: " . ' ' . round($dolartoday->EUR->efectivo_cucuta) . ' BsF <br />';
echo '<b>' . 'EUR Paralelo Promedio</b>: ' . round($avg_eur) . ' BsF<br />';
?>
 </div>

<div class="dolartoday-display btc"> 
<h4> (฿) BTC </h4>
<?php
echo '<b>' . "Bitcoin (USD)</b>:  " . ' ' . '$' . $bitcoin->last . ' <br />';
echo '<b>' . "Bitcoin (BsF)</b>: " . ' ' . round($bitcoin->last * $dolartoday->USD->transferencia) . ' BsF <br />';
?>
 </div>


<div class="dolartoday-date">
  <?php
echo "Date: " . $dolartoday->_timestamp->fecha_corta; ?>
</div>

<small class="info">(Source: DolarToday / Bitstamp)</small>
