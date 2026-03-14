<?php
header('Content-Type: application/json');

$api_url = "http://marcconrad.com/uob/banana/api.php?out=json";
$response = file_get_contents($api_url);

if ($response) {
    echo $response;
} else {
    echo json_encode(["error" => "Unable to fetch banana question"]);
}
?>