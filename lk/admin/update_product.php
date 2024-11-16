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
    die(json_encode(['success' => false, 'error' => 'Ошибка подключения: ' . $e->getMessage()]));
}

// Проверяем, пришли ли данные
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $material = $_POST['material'];
    $weight = $_POST['weight'];
    $sku = $_POST['sku'];
    $status = $_POST['status'];
    $discount = $_POST['discount'];
    $op = $_POST['op'];

    // Проверяем, было ли загружено новое фото
    $photoPath = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../uploads/uploads_produkt/';
        $photoName = basename($_FILES['photo']['name']);
        $photoPath = $uploadDir . $photoName;

        // Перемещаем загруженный файл
        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath)) {
            echo json_encode(['success' => false, 'error' => 'Ошибка загрузки файла.']);
            exit;
        }

        // Сохраняем только имя файла в базе данных
        $photoPath = $photoName;
    }

    // Формируем SQL-запрос
    try {
        $sql = "UPDATE products SET 
                    name = :name, 
                    price = :price, 
                    material = :material, 
                    weight = :weight, 
                    sku = :sku, 
                    status = :status, 
                    discount = :discount, 
                    op = :op";

        // Если фото загружено, добавляем его в запрос
        if ($photoPath) {
            $sql .= ", photo = :photo";
        }

        $sql .= " WHERE product_id = :product_id";

        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':material', $material);
        $stmt->bindParam(':weight', $weight);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':discount', $discount);
        $stmt->bindParam(':op', $op);
        $stmt->bindParam(':product_id', $product_id);

        if ($photoPath) {
            $stmt->bindParam(':photo', $photoPath);
        }

        $stmt->execute();
        echo json_encode(['success' => true]);
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'error' => $e->getMessage()]);
    }
}
?>
