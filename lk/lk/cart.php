<?php
session_start();

// Проверяем, есть ли товары в корзине
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

$total = 0;

?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css">
    <title>Корзина</title>
</head>
<body>
    <h1>Ваша корзина</h1>
    <?php if (empty($_SESSION['cart'])): ?>
        <p>Ваша корзина пуста.</p>
    <?php else: ?>
        <table>
            <tr>
                <th>Товар</th>
                <th>Количество</th>
                <th>Цена</th>
                <th>Действия</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><?php echo htmlspecialchars($item['name']); ?></td>
                    <td>
                        <form action="update_cart.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="number" name="quantity" value="<?php echo $item['quantity']; ?>" min="1">
                            <input type="submit" value="Обновить">
                        </form>
                    </td>
                    <td><?php echo htmlspecialchars($item['price']); ?> руб.</td>
                    <td>
                        <form action="remove_from_cart.php" method="post">
                            <input type="hidden" name="id" value="<?php echo $item['id']; ?>">
                            <input type="submit" value="Удалить">
                        </form>
                    </td>
                </tr>
                <?php
                $total += $item['price'] * $item['quantity'];
                endforeach; ?>
        </table>
        <p>Итого: <?php echo htmlspecialchars($total); ?> руб.</p>
        <a href="checkout.php">Оформить заказ</a>
    <?php endif; ?>
</body>
</html>
