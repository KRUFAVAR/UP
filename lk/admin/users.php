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
// Удаление пользователя
if (isset($_GET['delete'])) {
    $userIdToDelete = (int)$_GET['delete'];

    // Удаляем все отзывы, связанные с пользователем
    $deleteReviewsStmt = $pdo->prepare("DELETE FROM Review WHERE user_id = :user_id");
    $deleteReviewsStmt->execute(['user_id' => $userIdToDelete]);

    // Теперь удаляем пользователя
    $deleteUserStmt = $pdo->prepare("DELETE FROM Users WHERE user_id = :user_id");
    $deleteUserStmt->execute(['user_id' => $userIdToDelete]);

    header("Location: users.php"); // Перенаправление обратно на страницу пользователей
    exit();
}


// Получение списка пользователей (исключая администраторов)
$stmt = $pdo->query("SELECT user_id, username, email, created_at, online_status, last_login FROM Users WHERE role_id != 1");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление пользователями</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        /* Общие стили */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f8fa;
    color: #333;
    margin: 0;
    padding: 20px;
    display: flex;
    flex-direction: column;
    align-items: center;
    min-height: 100vh;
}

h1 {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #444;
}

/* Стили таблицы */
#user-table {
    width: 90%;
    border-collapse: collapse;
    margin: 20px 0;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

#user-table thead {
    background-color: #e8f4ff;
}

#user-table th, #user-table td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

#user-table th {
    color: #0056b3;
    font-weight: bold;
    text-transform: uppercase;
    font-size: 0.9rem;
}

#user-table tr:hover {
    background-color: #f1faff;
}

#user-table .online-status[data-status="1"] {
    color: #28a745;
    font-weight: bold;
}

#user-table .online-status[data-status="0"] {
    color: #dc3545;
    font-weight: bold;
}

/* Ссылки */
a {
    text-decoration: none;
    color: #007bff;
    padding: 5px 10px;
    border-radius: 4px;
    transition: background-color 0.3s, color 0.3s;
}

a:hover {
    background-color: #e8f4ff;
    color: #0056b3;
}

a:active {
    background-color: #cce0ff;
}

/* Кнопка назад */
a[href="index.php"] {
    margin-top: 20px;
    display: inline-block;
    background-color: #007bff;
    color: #fff;
    font-size: 1rem;
    padding: 10px 20px;
    border-radius: 5px;
}

a[href="index.php"]:hover {
    background-color: #0056b3;
}

/* Адаптивность */
@media (max-width: 768px) {
    #user-table {
        font-size: 0.9rem;
    }

    #user-table th, #user-table td {
        padding: 10px;
    }

    a[href="index.php"] {
        font-size: 0.9rem;
        padding: 8px 15px;
    }
}

    </style>
</head>
<body>
    <h1>Управление пользователями</h1>
    <table id="user-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Имя пользователя</th>
                <th>Email</th>
                <th>Дата регистрации</th>
                <th>Статус</th>
                <th>Последний вход</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr data-user-id="<?php echo htmlspecialchars($user['user_id']); ?>">
                    <td><?php echo htmlspecialchars($user['user_id']); ?></td>
                    <td><?php echo htmlspecialchars($user['username']); ?></td>
                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                    <td><?php echo htmlspecialchars($user['created_at']); ?></td>
                    <td class="online-status" data-status="<?php echo htmlspecialchars($user['online_status']); ?>">
                        <?php echo ($user['online_status'] == 1) ? 'Онлайн' : 'Не в сети'; ?>
                    </td>
                    <td><?php echo htmlspecialchars($user['last_login']); ?></td>
                    <td>
                        <a href="?delete=<?php echo htmlspecialchars($user['user_id']); ?>" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <a href="index.php">Назад</a>

    <script>
        function updateUsers() {
            $.ajax({
                url: 'get_users.php',
                type: 'GET',
                success: function(response) {
                    var users = JSON.parse(response);
                    $('#user-table tbody').empty(); // Очищаем текущую таблицу

                    users.forEach(function(user) {
                        var statusText = user.online_status == 1 ? 'Онлайн' : 'Не в сети';
                        var newRow = `<tr data-user-id="${user.user_id}">
                            <td>${user.user_id}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.created_at}</td>
                            <td class="online-status" data-status="${user.online_status}">${statusText}</td>
                            <td>${user.last_login}</td>
                            <td>
                                <a href="?delete=${user.user_id}" onclick="return confirm('Вы уверены, что хотите удалить этого пользователя?');">Удалить</a>
                            </td>
                        </tr>`;
                        $('#user-table tbody').append(newRow); // Добавляем новую строку
                    });
                }
            });
        }

        // Периодическое обновление данных
        setInterval(updateUsers, 5000); // Обновление каждые 5 секунд
    </script>
</body>
</html>
