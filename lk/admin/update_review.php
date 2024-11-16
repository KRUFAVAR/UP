<?php
session_start();

// Подключение к базе данных
$host = 'localhost';
$db = 'uver';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Проверка, если данные отправлены
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $review_id = $_POST['review_id'];
    $comments = $_POST['comments'];
    $rating = $_POST['rating'];

    try {
        // Обновление отзыва
        $stmt = $pdo->prepare("UPDATE Review SET comments = :comments, rating = :rating WHERE id = :review_id");
        $stmt->execute(['comments' => $comments, 'rating' => $rating, 'review_id' => $review_id]);

        // Возвращаем обновленные данные
        echo json_encode(['id' => $review_id, 'comments' => $comments, 'rating' => $rating]);
    } catch (PDOException $e) {
        echo json_encode(['error' => $e->getMessage()]);
    }
}
?>
