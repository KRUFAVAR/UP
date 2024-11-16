<?php
require_once '../bd/db.php';

// Проверяем, если передан параметр id
if (isset($_GET['id'])) {
    $shopId = intval($_GET['id']); // Приводим к целому числу для безопасности

    // Запрос для получения информации о конкретном магазине
    $query = "SELECT name FROM shop WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $shopId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $shop = $result->fetch_assoc();
        echo json_encode($shop);
    } else {
        echo json_encode(['name' => 'Не указано']); // Если магазин не найден
    }
} else {
    // Выполнение запроса для получения всех магазинов
    $sql = "SELECT id, name FROM shop";
    $result = $conn->query($sql);

    $shops = [];
    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $shops[] = $row;
        }
    }

    // Возвращаем JSON-ответ
    header('Content-Type: application/json');
    echo json_encode($shops);
}
