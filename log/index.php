<?php

require_once '../common.php';

if (isset($_REQUEST['bicycle_id'])) {
    $bicycleId = intval($_REQUEST['bicycle_id']);
    if (!isset($bicycles[$bicycleId])) {
        clientFailure("Invalid bicycle_id");
    }
    $odometer = floatval($_REQUEST['odometer']);
    if ($odometer <= 0) {
        clientFailure("Invalid odometer: {$odometer}");
    }
    $statement = $db->prepare("INSERT INTO odometer_log (bicycle_id, odometer) VALUES(?, ?)");
    $statement->execute(array($bicycleId, $odometer));
    header("Content-type: text/plain");
    header("Refresh: 2; url=../");
    echo "OK\n";
    exit;
}

require_once 'PHPTAL.php';

$template = new PHPTAL('template.html');
$template->bicycles = $bicycles;
$template->action = $_SERVER['PHP_SELF'];
echo $template->execute();
