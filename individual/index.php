<?php

require_once "../common.php";
require_once 'smarty/Smarty.class.php';

$bicycleId = intval($_REQUEST['bicycle_id']);

if (empty($bicycleId)) {
    die("need to specify a valid bicycle_id in the request");
}

$statement = $db->query("SELECT * FROM lk_bicycle WHERE bicycle_id = {$bicycleId}");
$bicycle = $statement->fetch();

$statement = $db->query("SELECT datetime, odometer FROM odometer_log WHERE bicycle_id = {$bicycleId} ORDER BY datetime ASC");

$graphData = array();
foreach ($statement->fetchAll() as $row) {
    $date = strtotime($row['datetime']);
    $graphData[] = array(date('r', $date), intval($row['odometer']));
}
$graphJson = json_encode($graphData);

$template = new Smarty();
$template->compile_dir = '/tmp/';
$template->compile_id = md5(dirname(__FILE__));
$template->template_dir = realpath(dirname(__FILE__));
$template->assign('title', $bicycle['name']);
$template->assign('graphJson', $graphJson);
$template->display('template.tpl');
