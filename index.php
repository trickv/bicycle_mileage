<?php

$goal = 3000;

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
    $bicycleOdometers[$bicycleId] = array(
        'name' => $bicycleName,
        'odometer' => $row['max_odometer'],
        'last_update' => $row['max_datetime'],
        'href' => 'individual/?bicycle_id=' . $bicycleId,
        );
    $totalMileage += $row[0];
}

$template->total_mileage = $totalMileage;
$template->bicycles = $bicycleOdometers;
$template->goal = $goal;
$template->reach_goal_miles_per_day = round($goal / 365, 2);
$template->done_per_day = round($totalMileage / date('z'), 2);
$template->day_number = intval(date('z'));
$template->to_go_per_day = round(($goal - $totalMileage) / (365 - date('z')), 2);
$template->to_go = $goal - $totalMileage;

ob_start(null, 1000000);
Debug::showDebug();
$template->debug = ob_get_clean();

echo $template->execute();
