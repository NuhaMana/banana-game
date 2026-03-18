<?php
session_start();

// URL for the Banana API
$banana_api_url = "http://marcconrad.com/uob/banana/api.php?out=json"; //shows interperabilty

// fetch JSON from Banana API
$response = file_get_contents($banana_api_url); //shows interperability 

if ($response === false) {
    echo json_encode(['error' => 'Cannot fetch Banana API']);
    exit;
}

// decode JSON
$data = json_decode($response, true); //int

if ($data === null) {
    echo json_encode(['error' => 'Invalid JSON from Banana API']);
    exit;
}

// store puzzle info in session
$_SESSION['banana_solution'] = $data['solution'] ?? null;

// return puzzle image URL and score info as JSON
echo json_encode([
    'question' => $data['question'] ?? '',
    'solution' => $data['solution'] ?? null
]);
?>