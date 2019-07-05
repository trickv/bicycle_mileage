<?php

$dbname = "bicycle_mileage";
if (isset($_REQUEST['year'])) {
    $dbname = "{$dbname}_" . intval($_REQUEST['year']);
}
$db = new PDO("sqlite:/home/trick/public_html/bicycle_mileage/db/${dbname}.sqlite3");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$bicycles = array();

$statement = $db->prepare("SELECT * FROM lk_bicycle ORDER BY position");
$statement->execute();
foreach ($statement->fetchAll() as $row) {
    $bicycles[$row['bicycle_id']] = $row['name'];
}

function clientFailure($message) {
    if (!headers_sent()) {
        header("HTTP/1.1 400 Epic Fail");
        header("Content-type: text/plain");
    }
    die("{$message}\n");
}

