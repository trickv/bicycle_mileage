<?php

$goal = 4000;

require_once "PHPTAL.php";
require_once "common.php";

$template = new PHPTAL('template.html');
$template->now = date('r');

$statement = $db->prepare("SELECT MAX(odometer) AS max_odometer, MAX(datetime) AS max_datetime FROM odometer_log WHERE bicycle_id = ?");

$bicycleOdometers = array();
$totalMileage = 0;

foreach ($bicycles as $bicycleId => $bicycleName) {
    if (!$statement->execute(array($bicycleId)))
        throw new Exception("Failed query: " . print_r($db->errorInfo(), true));
    $row = $statement->fetch();
    $bicycleOdometers[$bicycleId] = array('name' => $bicycleName, 'odometer' => $row['max_odometer'], 'last_update' => $row['max_datetime']);
    $totalMileage += $row[0];
}

$template->total_mileage = $totalMileage;
$template->bicycles = $bicycleOdometers;
$template->goal = $goal;
$template->done_per_week = round($totalMileage / date('W'), 1);
$template->week_number = intval(date('W'));
$template->to_go_per_week = round(($goal - $totalMileage) / (52 - date('W')), 1);
$template->to_go = $goal - $totalMileage;

ob_start(null, 1000000);
Debug::showDebug();
$template->debug = ob_get_clean();

echo $template->execute();
