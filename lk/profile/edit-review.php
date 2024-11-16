<?php
include '../includes/db.php';

session_start();
$user_id = $_SESSION['user_id'];
$review_id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $comments = $_POST['comments'];
    $rating = $_POST['rating'];

    $stmt = $pdo->prepare("UPDATE review SET comments = ?, rating = ? WHERE id = ? AND user_id = ?");
    $stmt->execute([$comments, $rating, $review_id, $user_id]);
    header("Location: reviews.php");
    exit;
}

$stmt = $pdo->prepare("SELECT comments, rating FROM review WHERE id = ? AND user_id = ?");
$stmt->execute([$review_id, $user_id]);
$review = $stmt->fetch();

if (!$review) {
    die("Отзыв не найден или вы не имеете доступа.");
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать отзыв</title>
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
    <h2>Редактировать отзыв</h2>
    <form action="" method="POST">
        <label>Отзыв:</label>
        <textarea name="comments" required style="width: 300px; height: 150px; resize: none;"><?php echo htmlspecialchars($review['comments']); ?></textarea>
        <label>Рейтинг:</label>
        <input type="number" name="rating" min="1" max="5" value="<?php echo $review['rating']; ?>" required>
        <button type="submit">Сохранить изменения</button>
    </form>
    <?php include '../includes/footer.php'; ?>
    
</body>
</html>
