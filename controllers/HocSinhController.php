<?php

use services\HocSinhService;

header('Content-Type: application/json');


$method = $_SERVER['REQUEST_METHOD'];

$hocSinhService = new HocSinhService();

switch ($method) {
    case 'GET':
        if (isset($_GET['id'])) {
            $id = intval($_GET['id']);
            $hs = $hocSinhService->selectById($id);
            if ($hs !== null) {
                echo json_encode($hs);
            } else {
                http_response_code(404);
                echo json_encode(['message' => 'HocSinh not found']);
            }
        } elseif (isset($_GET['search'])) {
            $key = $_GET['search'];
            $list = $hocSinhService->search($key);
            echo json_encode($list);
        } else {
            $list = $hocSinhService->selectAll();
            echo json_encode($list);
        }
        break;

    case 'POST':
        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['ten'], $data['ngaysinh'], $data['gioitinh'], $data['diachi'], $data['lop'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing required fields']);
            break;
        }

        $lop = new Lop($data['lop'], 'Lập trình di động');

        $hs = new HocSinh(0, $data['ten'], $data['ngaysinh'], $data['gioitinh'], $data['diachi'], $lop);
        $insertId = $hocSinhService->insert($hs);
        echo json_encode(['insert_id' => $insertId]);
        break;

    case 'PUT':
        $data = json_decode(file_get_contents('php://input'), true);
        if (!isset($data['id'], $data['ten'], $data['ngaysinh'], $data['gioitinh'], $data['diachi'], $data['lop'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing required fields']);
            break;
        }
        $lop = new Lop($data['lop'], '');
        $hs = new HocSinh($data['id'], $data['ten'], $data['ngaysinh'], $data['gioitinh'], $data['diachi'], $lop);
        $affectedRows = $hocSinhService->update($hs);
        echo json_encode(['affected_rows' => $affectedRows]);
        break;

    case 'DELETE':
        if (!isset($_GET['id'])) {
            http_response_code(400);
            echo json_encode(['message' => 'Missing HocSinh id']);
            break;
        }
        $id = intval($_GET['id']);
        $hs = $hocSinhService->selectById($id);
        if ($hs === null) {
            http_response_code(404);
            echo json_encode(['message' => 'HocSinh not found']);
            break;
        }
        $affectedRows = $hocSinhService->delete($hs);
        echo json_encode(['affected_rows' => $affectedRows]);
        break;

    default:
        http_response_code(405);
        echo json_encode(['message' => 'Method Not Allowed']);
        break;
}