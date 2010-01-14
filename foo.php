<?php

require_once "../common.php";
require_once "gchart/util.php";
require_once "gchart/gChart2.php";

$statement = $db->prepare("SELECT * FROM odometer_log ORDER BY bicycle_id, datetime");
$statement->execute();

$miles = array();
foreach ($statement->fetchAll() as $row) {
    if (!isset($miles[$row['bicycle_id']]))
        $miles[$row['bicycle_id']] = array();
    #$miles[$row['bicycle_id']][$row['datetime']] = $row['odometer'];
    $miles[$row['bicycle_id']][] = intval($row['odometer']);
}

$url = "http://chart.apis.google.com/chart?chxt=x,y&chs=500x500&cht=ls&chd=t:%s&chds=1,700&chxr=1,0,700,25&%s";
$flatMiles = array();
foreach ($miles as $bicycleId => $odometerLog) {
    $flatMiles[$bicycleId] = implode(',', $odometerLog);
}
$dataString = implode('|', $flatMiles);
for ($i = 0; $i < count($flatMiles); $i++) {
    $chmList[] = "o,0000FF,{$i},-1,6,0";
}
$chm= "chm=" . implode('|', $chmList);
$url = sprintf($url, $dataString, $chm);

echo "<html><body><img src='{$url}'><br><pre>{$url}\n\n";

print_r($miles);
