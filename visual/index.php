<?php

require_once "../common.php";
require_once 'smarty3/Smarty.class.php';

$statement = $db->query("SELECT bicycle_id, datetime, odometer FROM odometer_log ORDER BY datetime ASC");

$odometerLog = array();
$currentPerOdometer = array();
$milesPerPoint = array();
$milesPerDay = array();
$milesPerDaySinceLast = array();
foreach ($statement->fetchAll() as $row) {
    $currentPerOdometer[$row['bicycle_id']] = intval($row['odometer']);
    $lastDate = $date;
    $date = strtotime($row['datetime']);
    $dateString = date('r', $date);
    $lastCurrentOdometer = $currentOdometer;
    $currentOdometer = array_sum($currentPerOdometer);
    $milesPerPoint[] = array($dateString, $currentOdometer);
    $milesPerDay[] = array($dateString, $currentOdometer / date('z', $date));
    if (!empty($lastDate)) {
        $milesPerDaySinceLast[] = array($dateString, round(($currentOdometer - $lastCurrentOdometer) / (($date - $lastDate) / 86400), 2));
    }
}

$template = new Smarty();
$template->compile_dir = '/tmp/';
$template->compile_id = md5(dirname(__FILE__));
$template->template_dir = realpath(dirname(__FILE__));
$template->assign('milesPerPoint', json_encode($milesPerPoint));
$template->assign('milesPerDay', json_encode($milesPerDay));
$template->assign('milesPerDaySinceLast', json_encode($milesPerDaySinceLast));
$template->display('template.tpl');
