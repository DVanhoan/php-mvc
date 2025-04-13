<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');


require_once 'db/Database.php';
require_once 'models/HocSinh.php';
require_once 'models/Lop.php';
require_once 'services/DAOInterface.php';
require_once 'services/HocSinhService.php';
require_once 'services/LopService.php';

$requestUri = $_SERVER['REQUEST_URI'];

$uri = parse_url($requestUri, PHP_URL_PATH);

$segments = explode('/', trim($uri, '/'));

if (isset($segments[0]) && $segments[0] === 'api') {
    $resource = $segments[1] ?? null;

    $id = $segments[2] ?? null;

    switch ($resource) {
        case 'hocsinh':
            if ($id) {
                $_GET['id'] = $id;
            }

            require_once 'controllers/HocSinhController.php';
            break;

        case 'lop':
            if ($id) {
                $_GET['id'] = $id;
            }
            require_once 'controllers/LopController.php';
            break;

        default:
            http_response_code(404);
            echo json_encode(['message' => 'Resource not found']);
            break;
    }
} else {
    http_response_code(404);
    echo json_encode(['message' => 'Invalid API request']);
}