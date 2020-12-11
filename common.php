<?php

$dbname = "bicycle_mileage";
if (isset($_REQUEST['year'])) {
    $dbname = "{$dbname}_" . intval($_REQUEST['year']);
}
$db = new PDO("sqlite:/home/trick/public_html/bicycle_mileage/db/${dbname}.sqlite3");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$bicycles = array();

$statement = $db->prepare("SELECT lk_bicycle.bicycle_id AS bicycle_id, lk_bicycle.name AS bicycle_name, lk_unit.unit_id AS unit_id, lk_unit.name AS unit_name FROM lk_bicycle INNER JOIN lk_unit ON (lk_unit.unit_id = lk_bicycle.unit_id) ORDER BY position;");
$statement->execute();
foreach ($statement->fetchAll() as $row) {
    $bicycles[$row['bicycle_id']] = array(
        'name' => $row['bicycle_name'],
        'unit_id' => $row['unit_id'],
        'unit' => $row['unit_name'],
        );
}

function clientFailure($message) {
    if (!headers_sent()) {
        header("HTTP/1.1 400 Epic Fail");
        header("Content-type: text/plain");
    }
    die("{$message}\n");
}

