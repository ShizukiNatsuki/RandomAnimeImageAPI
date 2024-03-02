<?php

$type = $_GET["type"];
$client = $_GET["client"];
$name = $_GET["name"];
$return = $_GET["return"];

if (!file_exists("./res/{$type}")) {
    http_response_code(400);
    die("Invalid type.");
}

if (!file_exists("./res/{$type}/{$name}")) {
    http_response_code(404);
    die("Resource not found.");
}

if ($client != "pc" && $client != "mobile") {
    http_response_code(400);
    die("Invalid client type.");
}

$json_file = "./res/{$type}/{$name}/{$client}.json";

if (!file_exists($json_file)) {
    http_response_code(404);
    die("JSON file not found.");
}

$json_context = file_get_contents($json_file);
$json = json_decode($json_context, true);

$url = $json[array_rand($json)];

switch ($return) {
    case "json": {
        header('Content-type: application/json');
        die(json_encode(['url' => $url]));
    }
    case "image": {
        header("Location: {$url}");
        die();
    }
    default: {
        http_response_code(400);
        die("Invalid return type.");
    }
}

?>
