<?php

require_once "../common.php";
require_once 'FusionChartsFree/Code/PHPClass/Includes/FusionCharts_Gen.php';

$statement = $db->query("SELECT datetime, odometer FROM odometer_log WHERE bicycle_id = 3 ORDER BY datetime ASC");

$index = 0;
foreach ($statement->fetchAll() as $row) {
    $date = strtotime($row['datetime']);
    $chartData[$index][0] = $date;
    $chartData[$index][1] = $row['odometer'];
    $index++;
}

$chart = new FusionCharts('Line', 1100, 300);
$chart->addChartDataFromArray($chartData);
$chartHtml = $chart->renderChart(null, false);

echo "<html><head><script language='javascript' src='FusionCharts.js'></script></head><body>{$chartHtml}</body></html>";
