<?php
// Подключение к базе данных
require 'api/db.php'; // Убедитесь, что путь к файлу подключения правильный

// Начало сессии
session_start();

// Получение информации о пользователе
$userId = $_SESSION['user_id']; // Предполагается, что идентификатор пользователя хранится в сессии
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$userId]);
$user = $stmt->fetch(PDO::FETCH_OBJ); // Получение объекта пользователя

if (!$user) {
    echo "Пользователь не найден.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Профиль пользователя</title>
    <link rel="stylesheet" href="styles.css"> <!-- Подключение CSS файла для стилей -->
</head>
<body>
    <div class="container">
        <h1>Информация о пользователе</h1>
        <div class="user-info">
            <p><strong>Имя:</strong> <?php echo htmlspecialchars($user->name); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user->email); ?></p>
            <p><strong>Телефон:</strong> <?php echo htmlspecialchars($user->phone); ?></p>
            <div class="profile-photo">
                <h3>Профильное фото:</h3>
                <?php if (!empty($user->photo)): ?>
                    <img src="uploads2/<?php echo htmlspecialchars($user->photo); ?>" alt="Профильное фото" width="150">
                <?php else: ?>
                    <p>Фото отсутствует.</p>
                <?php endif; ?>
            </div>
        </div>

        <h2>Обновить фото</h2>
        <form action="api/upload_photo.php" method="post" enctype="multipart/form-data">
            <input type="file" name="photo" required>
            <button type="submit">Загрузить фото</button>
        </form>

        <h2>Удалить фото</h2>
        <form action="api/delete_photo.php" method="post">
            <button type="submit">Удалить фото</button>
        </form>

        <a href="logout.php">Выйти</a>
    </div>
</body>
</html>
