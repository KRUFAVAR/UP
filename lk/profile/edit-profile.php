<?php
include '../includes/db.php';

session_start();
$user_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];

    if (!empty($_FILES['profile_picture']['name'])) {
        $profile_picture = $_FILES['profile_picture']['name'];
        move_uploaded_file($_FILES['profile_picture']['tmp_name'], "../../uploads/uploads_profil/$profile_picture");
    } else {
        $profile_picture = $_POST['current_picture'];
    }

    $stmt = $pdo->prepare("UPDATE Users SET username = ?, email = ?, profile_picture = ? WHERE user_id = ?");
    $stmt->execute([$username, $email, $profile_picture, $user_id]);
    header("Location: profile.php");
    exit;
}

$stmt = $pdo->prepare("SELECT username, email, profile_picture FROM Users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Редактировать профиль</title>
<style>
        body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f4f4f4; /* Светло-серый фон */
        color: #333; /* Тёмный текст для хорошей читаемости */
    }

    h2 {
        text-align: center;
        color: #444; /* Мягкий оттенок для заголовков */
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
        color: #555; /* Более мягкий цвет текста */
    }

    input[type="text"],
    input[type="email"],
    input[type="file"] {
        padding: 10px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        outline: none;
        transition: border-color 0.3s ease;
        background-color: #f9f9f9; /* Светлый фон для полей */
    }

    input[type="text"]:focus,
    input[type="email"]:focus,
    input[type="file"]:focus {
        border-color: #aaa; /* Нейтральный серый оттенок при фокусе */
    }

    button {
        padding: 10px 20px;
        font-size: 16px;
        font-weight: bold;
        color: #fff;
        background-color: #8c8c3b; /* Теплый темно-желтовато-зеленый оттенок */
        border: none;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #6f6f2c; /* Более тёмный теплый оттенок при наведении */
    }

    button:active {
        background-color: #565622; /* Ещё более тёмный оттенок при клике */
    }

    input[type="hidden"] {
        display: none; /* Скрытие поля с текущим изображением */
    }

    /* Дополнительные стили для удобства */
    form input, form button {
        width: 100%; /* Растягивает элементы на ширину формы */
    }

    form {
        box-sizing: border-box;
    }
</style>
</head>
<body>
    <?php include '../includes/header.php'; ?>
    <h2>Редактировать профиль</h2>
    <form action="" method="POST" enctype="multipart/form-data">
        <label>Имя:</label>
        <input type="text" name="username" value="<?php echo htmlspecialchars($user['username']); ?>" required>
        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
        <label>Фото:</label>
        <input type="file" name="profile_picture">
        <input type="hidden" name="current_picture" value="<?php echo $user['profile_picture']; ?>">
        <button type="submit">Сохранить изменения</button>
    </form>
    <?php include '../includes/footer.php'; ?>
</body>
</html>
