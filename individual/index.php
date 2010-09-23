<?php

require_once "../common.php";
require_once 'FusionChartsFree/Code/PHPClass/Includes/FusionCharts_Gen.php';
require_once 'smarty/Smarty.class.php';

$bicycleId = intval($_REQUEST['bicycle_id']);

if (empty($bicycleId)) {
    die("need to specify a valid bicycle_id in the request");
}

$statement = $db->query("SELECT * FROM lk_bicycle WHERE bicycle_id = {$bicycleId}");
$bicycle = $statement->fetch();

if (empty($bicycle)) {
    throw new Exception("empty bicycle object");
}

$title = "{$bicycle['name']} (id:{$bicycle['bicycle_id']})";

$statement = $db->query("SELECT datetime, odometer FROM odometer_log WHERE bicycle_id = {$bicycleId} ORDER BY datetime ASC");

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

$template = new Smarty();
$template->compile_dir = '/tmp/';
$template->template_dir = realpath(dirname(__FILE__));
$template->assign('title', $title);
$template->assign('chartHtml', $chartHtml);
$template->display('template.tpl');
