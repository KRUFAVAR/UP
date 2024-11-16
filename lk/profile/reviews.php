<?php
include '../includes/db.php';

session_start();
$user_id = $_SESSION['user_id'];

$stmt = $pdo->prepare("SELECT id, comments, rating, created_at FROM review WHERE user_id = ?");
$stmt->execute([$user_id]);
$reviews = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мои отзывы</title>
    <style>

body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4; /* Мягкий светло-серый фон */
        color: #333; /* Темный текст для контраста */
    }

    h2 {
        text-align: center;
        color: #444; /* Мягкий цвет для заголовков */
        margin-top: 20px;
    }

    form {
        max-width: 500px;
        margin: 30px auto;
        padding: 20px;
        background-color: #fff; /* Белый фон формы */
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); /* Легкая тень */
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    label {
        font-size: 14px;
        font-weight: bold;
        color: #555; /* Более мягкий серый для текста */
    }

    textarea, input[type="number"] {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s ease;
        background-color: #f9f9f9; /* Светлый фон для ввода */
    }

    textarea:focus, 
    input[type="number"]:focus {
        border-color: #aaa; /* Нейтральный серый оттенок при фокусе */
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #8c8c3b; /* Теплый акцентный цвет */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #6f6f2c; /* Более тёмный оттенок при наведении */
    }

    button:active {
        background-color: #565622; /* Темный оттенок при клике */
    }

    /* Дополнительные стили */
    form input,
    form textarea,
    form button {
        width: 100%; /* Элементы растягиваются на ширину формы */
    }

    form {
        box-sizing: border-box;
    }

    </style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Мои отзывы</h2>
    <?php foreach ($reviews as $review): ?>
        <div class="review">
            <p>Отзыв: <?php echo htmlspecialchars($review['comments']); ?></p>
            <p>Рейтинг: <?php echo $review['rating']; ?></p>
            <p>Дата создания: <?php echo $review['created_at']; ?></p>
            <a href="edit-review.php?id=<?php echo $review['id']; ?>">Редактировать</a>
            <a href="delete-review.php?id=<?php echo $review['id']; ?>">Удалить</a>
        </div>
    <?php endforeach; ?>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
