<?php
header('Content-Type: application/json; charset=utf-8');

// Проверка метода запроса
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(["success" => false, "error" => "Неверный метод запроса."]);
    exit();
}

// Подключение к базе данных
$host = 'localhost';
$db = 'uver';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo json_encode(["success" => false, "error" => "Ошибка подключения к базе данных: " . $e->getMessage()]);
    exit();
}

// Получение данных из запроса
$data = json_decode(file_get_contents('php://input'), true);
$productId = $data['id'] ?? null;

if ($productId) {
    // Подготовка и выполнение запроса на удаление
    $stmt = $pdo->prepare("DELETE FROM products WHERE product_id = :id");
    $stmt->bindParam(':id', $productId, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => "Не удалось удалить товар."]);
    }
} else {
    echo json_encode(["success" => false, "error" => "Не указан ID товара."]);
}
?>
