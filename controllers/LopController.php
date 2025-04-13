<?php

use services\LopService;
use services\HocSinhService;

header('Content-Type: application/json');

$method = $_SERVER['REQUEST_METHOD'];
$lopService = new LopService();
$hocsinhService = new HocSinhService();

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $lop = $lopService->selectById($id);
            $hocsinhList = $hocsinhService->selectAllHocSinhByLopId($id);
            if ($lop !== null) {
                foreach ($hocsinhList as $hocsinh) {
                    $lop->themHocSinh($hocsinh);
                }
                echo json_encode($lop);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'Lop not found']);
            }
        } elseif (isset($_GET['search'])) {
            $key = $_GET['search'];
            $list = $lopService->search($key);
            echo json_encode($list);
        } else {
            $list = $lopService->selectAll();
            echo json_encode($list);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['tenlop'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing tenlop field']);
            break;
        }

        $lop = new Lop(0, $data['tenlop']);
        $insertId = $lopService->insert($lop);
        echo json_encode(['insert_id' => $insertId]);
        break;

    case 'PUT':

        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['id'], $data['tenlop'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing required fields']);
            break;
        }
        $lop = new Lop($data['id'], $data['tenlop']);
        $affectedRows = $lopService->update($lop);
        echo json_encode(['affected_rows' => $affectedRows]);
        break;

    case 'DELETE':

        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing Lop id']);
            break;
        }
        $id = intval($_GET['id']);
        $lop = $lopService->selectById($id);
        if ($lop === null) {
            http_response_code(404);
            echo json_encode(['message' => 'Lop not found']);
            break;
        }
        $affectedRows = $lopService->delete($lop);
        echo json_encode(['affected_rows' => $affectedRows]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}