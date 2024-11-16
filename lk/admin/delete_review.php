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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $reviewId = $_POST['review_id'];

    $stmt = $pdo->prepare("DELETE FROM Review WHERE id = :id");
    $stmt->execute(['id' => $reviewId]);

    // Получение обновленных данных
    $stmt = $pdo->query("SELECT id, comments, rating, created_at FROM Review");
    $reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($reviews as $review) {
        echo '<tr data-review-id="' . htmlspecialchars($review['id']) . '">';
        echo '<td>' . htmlspecialchars($review['id']) . '</td>';
        echo '<td class="review-comment">' . htmlspecialchars($review['comments']) . '</td>';
        echo '<td class="review-rating">' . htmlspecialchars($review['rating']) . '</td>';
        echo '<td>' . htmlspecialchars($review['created_at']) . '</td>';
        echo '<td><button class="edit-button">Редактировать</button> <button class="delete-button">Удалить</button></td>';
        echo '</tr>';
    }
}
?>
