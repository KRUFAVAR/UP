<?php
require_once '../bd/db.php';

// Проверяем, если передан параметр id
if (isset($_GET['id'])) {
    $categoryId = intval($_GET['id']);

    // Запрос для получения информации о категории
    $query = "SELECT name FROM category WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $category = $result->fetch_assoc();
        echo json_encode($category);
    } else {
        echo json_encode(['name' => 'Не указано']);
    }
}
?>
