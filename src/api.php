<?php
include_once "db.php";

$method = $_SERVER['REQUEST_METHOD'];

$uri = explode('/', trim($_SERVER['REQUEST_URI'], '/'));

$recurso = $uri[0];
$id = $uri[1] ?? null;

header('Content-Type: application/json');

$src_db = ['categorias', 'productos', 'promociones'];
if ($recurso !== $src_db) {
    http_response_code(404);
    exit;
}

switch ($recurso) {
    case 'categorias':
        usarCategorias($_SERVER['REQUEST_METHOD'], $id, $pdo);
        break;

    case 'productos':
        usarProductos($_SERVER['REQUEST_METHOD'], $id, $pdo);
        break;

    case 'promociones':
        usarPromocion($_SERVER['REQUEST_METHOD'], $id, $pdo);
        break;
    
    default:
        http_response_code(404);
        echo json_encode(['error' => 'Seccion no encontrada']);
        break;
}

function usarCategorias($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT id, nombre FROM categorias WHERE id = ?");
                $stmt->excecute([$id]);
                $response = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($response);
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Item no encontrado']);
                }
            } else {
                $stmt = $pdo->prepare("SELECT id, name FROM categorias");
                $stmt->excecute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Item no encontrado']);
                }
            }
            
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO categorias(nombre) VALUES(?)");
            $stmt->excecute([$data['nombre']]);
            http_response_code(201);
            $data['id'] = $pdo->lastInsertId();
            echo json_encode($data);
            break;
        
        case 'PUT':
            if(!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/status/400']);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("UPDATE categorias SET nombre=? WHERE id=?");
            $stmt->execute([
                $data['nombre'],
                $id
            ]);
            echo json_encode($data);
            break;

        case 'DELETE':
            if(!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/status/400']);
                exit;
            }
            $stmt = $pdo->prepare("SELECT id, nombre FROM categorias WHERE id = ?");
            $stmt->execute([$id]);
            $last_del = $stmt->fetch(PDO::FETCH_ASSOC);

            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('DELETE FROM categorias WHERE id = ?');
            $stmt->execute([$id]);

            echo json_encode($last_del);
            break;

        default:
            # code...
            break;
    }
}

function usarProductos($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT id, nombre FROM productos WHERE id = ?");
                $stmt->excecute([$id]);
                $response = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($response);
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Item no encontrado']);
                }
            } else {
                $stmt = $pdo->prepare("SELECT id, name FROM productos");
                $stmt->excecute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Item no encontrado']);
                }
            }
            
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO productos(nombre) VALUES(?)");
            $stmt->excecute([$data['nombre']]);
            http_response_code(201);
            $data['id'] = $pdo->lastInsertId();
            echo json_encode($data);
            break;
        
        case 'PUT':
            if(!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/status/400']);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("UPDATE productos SET nombre = ? WHERE id = ?");
            $stmt->execute([
                $data['nombre'],
                $id
            ]);
            echo json_encode($data);
            break;

        case 'DELETE':
            if(!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/status/400']);
                exit;
            }
            $stmt = $pdo->prepare("SELECT id, nombre FROM productos WHERE id = ?");
            $stmt->execute([$id]);
            $last_del = $stmt->fetch(PDO::FETCH_ASSOC);

            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('DELETE FROM productos WHERE id = ?');
            $stmt->execute([$id]);

            echo json_encode($last_del);
            break;

        default:
            # code...
            break;
    }
}

function usarPromocion($method, $id, $pdo) {
    switch ($method) {
        case 'GET':
            if ($id) {
                $stmt = $pdo->prepare("SELECT id, nombre FROM promociones WHERE id = ?");
                $stmt->excecute([$id]);
                $response = $stmt->fetch(PDO::FETCH_ASSOC);
                echo json_encode($response);
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Item no encontrado']);
                }
            } else {
                $stmt = $pdo->prepare("SELECT id, name FROM promociones");
                $stmt->excecute();
                $response = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if ($response) {
                    echo json_encode($response);
                } else {
                    echo json_encode(['error' => 'Item no encontrado']);
                }
            }
            
            break;

        case 'POST':
            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("INSERT INTO promociones(nombre) VALUES(?)");
            $stmt->excecute([$data['nombre']]);
            http_response_code(201);
            $data['id'] = $pdo->lastInsertId();
            echo json_encode($data);
            break;
        
        case 'PUT':
            if(!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/status/400']);
                exit;
            }

            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare("UPDATE promociones SET nombre = ? WHERE id = ?");
            $stmt->execute([
                $data['nombre'],
                $id
            ]);
            echo json_encode($data);
            break;

        case 'DELETE':
            if(!$id) {
                http_response_code(400);
                echo json_encode(['error' => 'ID no encontrado', 'code' => 400, 'errorUrl' => 'https://http.cat/status/400']);
                exit;
            }
            $stmt = $pdo->prepare("SELECT id, nombre FROM promociones WHERE id = ?");
            $stmt->execute([$id]);
            $last_del = $stmt->fetch(PDO::FETCH_ASSOC);

            $data = json_decode(file_get_contents('php://input'), true);
            $stmt = $pdo->prepare('DELETE FROM promociones WHERE id = ?');
            $stmt->execute([$id]);

            echo json_encode($last_del);
            break;

        default:
            # code...
            break;
    }
}
