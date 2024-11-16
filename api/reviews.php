<?php
require_once '../bd/db.php';

// Проверяем, если передан параметр product_id
if (isset($_GET['product_id'])) {
    $productId = intval($_GET['product_id']); // Приводим к целому числу для безопасности

    // Запрос для получения отзывов по конкретному продукту
    $query = "SELECT comments, rating, created_at FROM review WHERE product_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $result = $stmt->get_result();

    $reviews = [];
    while ($row = $result->fetch_assoc()) {
        $reviews[] = $row;
    }

    // Возвращаем JSON-ответ
    header('Content-Type: application/json');
    echo json_encode($reviews);
} else {
    echo json_encode([]); // Если product_id не передан, возвращаем пустой массив
}
?>
