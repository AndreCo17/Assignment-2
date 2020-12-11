<?php
require_once "config.inc.php";
require_once 'ASG2-classes.php';
// Tell the browser to expect JSON rather than HTML
header('Content-type: application/json');
// indicate whether other domains can use this API
header("Access-Control-Allow-Origin: *");
try {
    $conn = DatabaseHelper::createConnection(array(
        DBCONNSTRING,
        DBUSER, DBPASS
    ));
    $gateway = new PaintingDB($conn);
    $p = $gateway->getAll();
    if (isCorrectQueryStringInfo("galleryID")) {
        $paintings = $gateway->getAllForGallery($_GET["galleryID"]);
    } else {
        $paintings = $gateway->getAll();
    }
    foreach ($p as $row) {
        $row['ImageFileName'] = $row['ImageFileName'] . '.jpg';
    }
    echo json_encode($paintings);
} catch (Exception $e) {
    die($e->getMessage());
}

function isCorrectQueryStringInfo($param)
{
    if (isset($_GET[$param]) && !empty($_GET[$param]) && $_GET[$param] > 0) {
        return true;
    } else {
        return false;
    }
}
