<?php
session_start(); // Запускаем сессию

// Подключение к базе данных
$host = 'localhost'; // Ваш хост
$db = 'uver'; // Имя вашей базы данных
$user = 'root'; // Имя пользователя базы данных
$pass = ''; // Пароль базы данных

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Ошибка подключения: " . $e->getMessage());
}

// Убедитесь, что пользователь авторизован
if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php"); // Перенаправляем на страницу входа, если пользователь не авторизован
    exit();
}

$userId = $_SESSION['user_id']; // Получаем идентификатор пользователя из сессии

try {
    $stmt = $pdo->prepare("SELECT username, email, created_at, profile_picture FROM Users WHERE user_id = :user_id");
    $stmt->execute(['user_id' => $userId]);

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        throw new Exception("Пользователь не найден.");
    }
} catch (PDOException $e) {
    echo "Ошибка базы данных: " . $e->getMessage();
    exit();
} catch (Exception $e) {
    echo "Ошибка: " . $e->getMessage();
    exit();
}

// Путь к изображению профиля
$profilePicturePath = "../../uploads/uploads_profil/" . rawurlencode(htmlspecialchars($user['profile_picture']));

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Личный кабинет</title>
    <style>
/* Общие стили */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f4f4f9;
    color: #333;
    line-height: 1.6;
    display: flex;
    justify-content: center;
    flex-direction: column;
    align-items: center;
    height: 100vh; /* Высота на весь экран */
    text-align: center; /* Центрирование текста */
}

/* Контейнер */
.container {
    width: 90%;
    max-width: 600px;
    background: #fff;
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

/* Заголовки */
h1, h2 {
    color: #0056b3;
    margin-bottom: 20px;
}

/* Информация о пользователе */
.user-info p {
    margin: 10px 0;
}

.user-info strong {
    color: #0056b3;
}

/* Фотография профиля */
.profile-picture {
    width: 150px;
    height: 150px;
    border-radius: 50%;
    border: 3px solid #ddd;
    margin: 20px auto;
    object-fit: cover;
}

/* Ссылки / кнопки */
.links {
    display: flex;
    flex-direction: column; /* Расположение кнопок в столбик */
    gap: 10px; /* Расстояние между кнопками */
    margin-top: 20px;
}

.links a {
    display: inline-block;
    text-decoration: none;
    color: white;
    background-color:#007bff:
    font-weight: bold;
    padding: 10px 20px;
    border-radius: 5px;
    transition: all 0.3s ease-in-out;
    text-align: center;
}

.links a:hover {
    background-color: #003d80;
}

/* Адаптивность */
@media (max-width: 768px) {
    .container {
        padding: 15px;
    }

    .links a {
        width: 100%; /* Кнопки на всю ширину */
    }
}
a{
    text-decoration:none;
    color: black;
    display:flex;
    gap:25px;
}
    </style>
</head>
<body>
    <h1>Личный кабинет</h1>
    <h2>Информация о пользователе</h2>
    <p><strong>Имя пользователя:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
    <p><strong>Дата регистрации:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>

    <?php if (!empty($user['profile_picture'])): ?>
    <img src="../../uploads/uploads_profil/<?php echo rawurlencode(htmlspecialchars($user['profile_picture'])); ?>" alt="Фотография профиля" class="profile-picture">
<?php else: ?>
    <p>Фотография профиля не загружена.</p>
<?php endif; ?>

   <a href="../../index.html">В каталог</a>
    <a href="edit-profile.php">Редактировать профиль</a>
    <a href="logout.php">Выйти</a>
</body>
</html>
