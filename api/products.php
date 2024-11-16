<?php
header('Content-Type: application/json');
require_once '../bd/db.php'; // Подключите ваш файл базы данных

// Проверяем, если передан параметр id
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // Приводим к целому числу для безопасности

    // Запрос для получения информации о конкретном продукте
    $query = "SELECT p.*, 
                     COUNT(r.id) AS reviewsCount, 
                     AVG(r.rating) AS rating 
              FROM products p 
              LEFT JOIN review r ON p.product_id = r.product_id 
              WHERE p.product_id = ? 
              GROUP BY p.product_id";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $product = $result->fetch_assoc();
        echo json_encode($product);
    } else {
        echo json_encode([]);
    }
} else {
    // Если параметр id не передан, возвращаем все продукты
    $query = "SELECT product_id, name, material, price, weight, year_of_creation, photo, sku, status, category_id, discount, shop_id FROM products"; // Измените на ваши реальные названия столбцов

    $result = $conn->query($query);

    $products = [];
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }

    echo json_encode($products);
}
?>
