<?php
require_once '../bd/db.php';
session_start();

// Проверяем, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(["error" => "Unauthorized"]);
    exit();
}

$user_id = $_SESSION['user_id'];

// Получение данных пользователя
$sql = "SELECT username, email, phone_number FROM Users WHERE user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user = $stmt->get_result()->fetch_assoc();

// Получение отзывов пользователя
$sql_reviews = "SELECT product_name, review_text, rating FROM review WHERE user_id = ?";
$stmt_reviews = $conn->prepare($sql_reviews);
$stmt_reviews->bind_param("i", $user_id);
$stmt_reviews->execute();
$reviews = $stmt_reviews->get_result()->fetch_all(MYSQLI_ASSOC);

// Получение истории платежей
$sql_payments = "SELECT payment_date, amount FROM Payments WHERE user_id = ?";
$stmt_payments = $conn->prepare($sql_payments);
$stmt_payments->bind_param("i", $user_id);
$stmt_payments->execute();
$payments = $stmt_payments->get_result()->fetch_all(MYSQLI_ASSOC);

// Получение логов активности
$sql_logs = "SELECT action, action_date FROM logs WHERE user_id = ?";
$stmt_logs = $conn->prepare($sql_logs);
$stmt_logs->bind_param("i", $user_id);
$stmt_logs->execute();
$logs = $stmt_logs->get_result()->fetch_all(MYSQLI_ASSOC);

// Возвращаем данные в формате JSON
echo json_encode([
    "user" => $user,
    "reviews" => $reviews,
    "payments" => $payments,
    "logs" => $logs
]);
?>
