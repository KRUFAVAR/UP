<?php
session_start();
require '../includes/db.php'; // Подключаем файл с настройками базы данных

// Логика для обработки оплаты
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $paymentMethod = 'Оплата картой'; // Можете добавить форму для выбора метода оплаты

    try {
        // Сохраняем информацию о заказе
        $stmt = $pdo->prepare("INSERT INTO orders (user_id, payment_method) VALUES (:user_id, :payment_method)");
        $stmt->execute([
            'user_id' => $userId,
            'payment_method' => $paymentMethod
        ]);

        // Получаем ID последнего заказа
        $orderId = $pdo->lastInsertId();

        // Обновляем статус товаров в корзине
        $stmt = $pdo->prepare("UPDATE cart SET status = 'оплачено' WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        // Очищаем корзину после успешного заказа
        $stmt = $pdo->prepare("DELETE FROM cart WHERE user_id = :user_id");
        $stmt->execute(['user_id' => $userId]);

        echo "Заказ успешно оформлен! Номер заказа: " . $orderId;
    } catch (PDOException $e) {
        echo "Ошибка оформления заказа: " . $e->getMessage();
    }
} else {
    // Отображение формы для оформления заказа
    echo '
    <h1>Оформление заказа</h1>
    <form method="post">
        <label>Способ оплаты:</label>
        <select name="payment_method">
            <option value="card">Оплата картой</option>
            <option value="cash">Наличные</option>
            <!-- Вы можете добавить больше способов оплаты здесь -->
        </select>
        <input type="submit" value="Оплатить">
    </form>
    ';
}
?>
