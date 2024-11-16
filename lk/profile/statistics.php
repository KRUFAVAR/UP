<?php
include '../includes/db.php';

session_start();
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT AVG(rating) AS average_rating, COUNT(*) AS total_reviews FROM review WHERE user_id = ?");
$stmt->execute([$user_id]);
$stats = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Статистика отзывов</title>
    <style>
        /* Общие стили */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh; /* Высота на весь экран */
}

/* Контейнер для содержимого */
.container {
    width: 90%;
    max-width: 600px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    text-align: center; /* Центрирование текста */
}

/* Заголовки */
h2 {
    color: #0056b3;
    margin-bottom: 20px;
}

/* Информация */
p {
    font-size: 1.2em;
    margin: 10px 0;
    color: #555;
}

/* Ссылки в header/footer */
header a, footer a {
    text-decoration: none;
    color: #0056b3;
    font-weight: bold;
    margin: 0 10px;
    transition: color 0.3s ease-in-out;
}

header a:hover, footer a:hover {
    color: #003d80;
}

/* Header/Footer */
header, footer {
    background-color: #0056b3;
    color: #fff;
    width: 100%;
    padding: 10px 0;
    text-align: center;
    position: fixed;
    top: 0; /* Header фиксируется наверху */
}

footer {
    bottom: 0; /* Footer фиксируется внизу */
    top: auto;
}

/* Контент должен оставаться между header и footer */
main {
    margin-top: 60px; /* Отступ от header */
    margin-bottom: 40px; /* Отступ от footer */
}

    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Статистика отзывов</h2>
    <p>Средний рейтинг: <?php echo round($stats['average_rating'], 2); ?></p>
    <p>Количество отзывов: <?php echo $stats['total_reviews']; ?></p>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
