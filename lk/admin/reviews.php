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

// Обработка AJAX-запроса для обновления отзыва
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    
    if ($action === 'update_review') {
        // Обновление отзыва
        $review_id = $_POST['review_id'];
        $comments = $_POST['comments'];
        $rating = $_POST['rating'];
        
        try {
            $stmt = $pdo->prepare("UPDATE Review SET comments = :comments, rating = :rating WHERE id = :review_id");
            $stmt->execute(['comments' => $comments, 'rating' => $rating, 'review_id' => $review_id]);
            echo json_encode(['success' => true, 'id' => $review_id, 'comments' => $comments, 'rating' => $rating]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit();
    } elseif ($action === 'delete_review') {
        // Удаление отзыва
        $review_id = $_POST['review_id'];
        
        try {
            $stmt = $pdo->prepare("DELETE FROM Review WHERE id = :review_id");
            $stmt->execute(['review_id' => $review_id]);
            echo json_encode(['success' => true, 'id' => $review_id]);
        } catch (PDOException $e) {
            echo json_encode(['success' => false, 'error' => $e->getMessage()]);
        }
        exit();
    }
}

// Получение списка отзывов
$stmt = $pdo->query("SELECT Review.id, Review.comments, Review.rating, Review.created_at, Users.username, Products.name AS product_name 
                     FROM Review 
                     JOIN Users ON Review.user_id = Users.user_id 
                     JOIN Products ON Review.product_id = Products.product_id");
$reviews = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <title>Управление отзывами</title>
    <style>
        /* Общие стили */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: #f9f9f9;
    color: #333;
}

h1 {
    text-align: center;
    margin: 20px 0;
    font-size: 24px;
    color: #444;
}

/* Стили таблицы */
#review-table {
    width: 90%;
    margin: 20px auto;
    border-collapse: collapse;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    background-color: #fff;
}

#review-table th, 
#review-table td {
    padding: 12px 15px;
    text-align: left;
    border: 1px solid #ddd;
}

#review-table th {
    background-color: #f3f3f3;
    color: #666;
    font-weight: bold;
}

#review-table tbody tr:nth-child(even) {
    background-color: #f9f9f9;
}

#review-table tbody tr:hover {
    background-color: #f1f1f1;
}

/* Кнопки */
button {
    padding: 8px 12px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 14px;
    transition: background-color 0.3s;
    background-color:#2196F3:
}

button.edit-button {
    background-color: #4CAF50;
    color: #fff;
}

button.edit-button:hover {
    background-color: #45a049;
}

button.delete-button {
    background-color: #f44336;
    color: #fff;
}

button.delete-button:hover {
    background-color: #e53935;
}

/* Ссылки */
a {
    color: #2196F3;
    text-decoration: none;
}

a:hover {
    text-decoration: underline;
}

/* Модальное окно */
#edit-modal {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    z-index: 1000;
    width: 400px;
    background-color: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    border-radius: 8px;
    padding: 20px;
    display: none;
}

#edit-review-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

#edit-review-form label {
    font-size: 14px;
    color: #444;
}

#edit-review-form input[type="text"],
#edit-review-form input[type="number"] {
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
    width: 100%;
}

#edit-review-form button {
    width: 100%;
}

#edit-review-form #cancel-edit {
    background-color: #777;
    color: #fff;
}

#edit-review-form #cancel-edit:hover {
    background-color: #666;
}

/* Фон для модального окна */
body::before {
    content: "";
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    z-index: 999;
    display: none;
}

#edit-modal:target::before {
    display: block;
}

/* Кнопка "Назад" */
a[href="index.php"] {
    display: inline-block;
    margin: 20px auto;
    text-align: center;
    font-size: 16px;
    padding: 10px 15px;
    background-color: #2196F3;
    color: #fff;
    border-radius: 4px;
    width: fit-content;
}

a[href="index.php"]:hover {
    background-color: #1976D2;
}

    </style>
</head>
<body>
    <h1>Управление отзывами</h1>
    
    <!-- Таблица с отзывами -->
    <table id="review-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Пользователь</th>
                <th>Продукт</th>
                <th>Комментарий</th>
                <th>Рейтинг</th>
                <th>Дата создания</th>
                <th>Действия</th>
            </tr>
        </thead>
        <tbody id="review-table-body">
            <?php foreach ($reviews as $review): ?>
                <tr data-review-id="<?php echo htmlspecialchars($review['id']); ?>">
                    <td><?php echo htmlspecialchars($review['id']); ?></td>
                    <td><?php echo htmlspecialchars($review['username']); ?></td>
                    <td><?php echo htmlspecialchars($review['product_name']); ?></td>
                    <td class="review-comment"><?php echo htmlspecialchars($review['comments']); ?></td>
                    <td class="review-rating"><?php echo htmlspecialchars($review['rating']); ?></td>
                    <td><?php echo htmlspecialchars($review['created_at']); ?></td>
                    <td>
                        <button class="edit-button" data-review-id="<?php echo htmlspecialchars($review['id']); ?>">Редактировать</button>
                        <button class="delete-button" data-review-id="<?php echo htmlspecialchars($review['id']); ?>">Удалить</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Модальное окно для редактирования -->
    <div id="edit-modal" style="display: none;">
        <form id="edit-review-form">
            <input type="hidden" name="review_id" id="review_id">
            <label for="comments">Комментарий:</label>
            <input type="text" name="comments" id="comments" required>
            <label for="rating">Рейтинг:</label>
            <input type="number" name="rating" id="rating" min="1" max="5" required>
            <button type="submit">Сохранить</button>
            <button type="button" id="cancel-edit">Отмена</button>
        </form>
    </div>
                <a href="index.php">Назад</a>
    <script>
        $(document).ready(function() {
            // Показать модальное окно для редактирования отзыва
            $('.edit-button').on('click', function() {
                var reviewId = $(this).data('review-id');
                var reviewRow = $('tr[data-review-id="' + reviewId + '"]');

                // Получаем текущие данные из строки и вставляем их в форму
                $('#review_id').val(reviewId);
                $('#comments').val(reviewRow.find('.review-comment').text());
                $('#rating').val(reviewRow.find('.review-rating').text());

                $('#edit-modal').show(); // Показать модальное окно
            });

            // Отправка данных формы редактирования через AJAX
            $('#edit-review-form').on('submit', function(e) {
                e.preventDefault();
                var formData = $(this).serialize() + '&action=update_review';

                $.ajax({
                    type: 'POST',
                    url: '', // Отправка запроса на этот же файл
                    data: formData,
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.success) {
                            var reviewRow = $('tr[data-review-id="' + data.id + '"]');
                            reviewRow.find('.review-comment').text(data.comments);
                            reviewRow.find('.review-rating').text(data.rating);
                            $('#edit-modal').hide(); // Скрыть модальное окно
                        } else {
                            alert('Ошибка обновления данных');
                        }
                    },
                    error: function() {
                        alert('Ошибка при соединении с сервером.');
                    }
                });
            });

            // Удаление отзыва через AJAX
            $('.delete-button').on('click', function() {
                var reviewId = $(this).data('review-id');

                if (confirm('Вы уверены, что хотите удалить этот отзыв?')) {
                    $.ajax({
                        type: 'POST',
                        url: '', // Отправка запроса на этот же файл
                        data: { action: 'delete_review', review_id: reviewId },
                        success: function(response) {
                            var data = JSON.parse(response);
                            if (data.success) {
                                $('tr[data-review-id="' + data.id + '"]').remove();
                            } else {
                                alert('Ошибка удаления отзыва');
                            }
                        },
                        error: function() {
                            alert('Ошибка при соединении с сервером.');
                        }
                    });
                }
            });

            // Закрыть модальное окно без сохранения
            $('#cancel-edit').on('click', function() {
                $('#edit-modal').hide();
            });

            // Закрытие модального окна при нажатии вне его
            $(window).on('click', function(event) {
                if ($(event.target).is('#edit-modal')) {
                    $('#edit-modal').hide();
                }
            });
        });
    </script>
</body>
</html>
