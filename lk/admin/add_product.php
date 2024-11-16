<?php
session_start();
$host = 'localhost';
$db = 'uver';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['success' => false, 'error' => $e->getMessage()]));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $price = $_POST['price'] ?? 0;
    $material = $_POST['material'] ?? '';
    $weight = $_POST['weight'] ?? 0;
    $sku = $_POST['sku'] ?? '';
    $status = $_POST['status'] ?? '';
    $discount = $_POST['discount'] ?? 0;
    $op = $_POST['op'] ?? '';

    // Обработка файла
    if (!empty($_FILES['photo']['name'])) {
        $uploadDir = '../../uploads/uploads_produkt/';
        $uploadFile = $uploadDir . basename($_FILES['photo']['name']);
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploadFile)) {
            $photo = basename($_FILES['photo']['name']);
        } else {
            die(json_encode(['success' => false, 'error' => 'Ошибка загрузки файла.']));
        }
    } else {
        die(json_encode(['success' => false, 'error' => 'Файл не загружен.']));
    }

    // Добавление товара
    $stmt = $pdo->prepare("INSERT INTO products (name, price, material, weight, sku, status, discount, op, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $result = $stmt->execute([$name, $price, $material, $weight, $sku, $status, $discount, $op, $photo]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Не удалось добавить товар.']);
    }
}
?>
