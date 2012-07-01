<?php

require_once "../common.php";
require_once 'smarty/Smarty.class.php';


$statement = $db->query("SELECT bicycle_id, datetime, odometer FROM odometer_log ORDER BY datetime ASC");

$odometerLog = array();
$currentPerOdometer = array();
$milesPerPoint = array();
foreach ($statement->fetchAll() as $row) {
    $currentPerOdometer[$row['bicycle_id']] = intval($row['odometer']);
    $date = strtotime($row['datetime']);
    $dateString = date('r', $date);
    $currentOdometer = array_sum($currentPerOdometer);
    $milesPerPoint[] = array($dateString, $currentOdometer);
    $milesPerDay[] = array($dateString, $currentOdometer / date('z', $date));
}

$milesPerPointJson = json_encode($milesPerPoint);
$milesPerDayJson = json_encode($milesPerDay);

$template = new Smarty();
$template->compile_dir = '/tmp/';
$template->compile_id = md5(dirname(__FILE__));
$template->template_dir = realpath(dirname(__FILE__));
$template->assign('title', "Total mileage");
$template->assign('milesPerPoint', $milesPerPointJson);
$template->assign('milesPerDay', $milesPerDayJson);
$template->display('template.tpl');
