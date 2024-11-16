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

// Извлечение всех товаров из базы данных
try {
    $stmt = $pdo->prepare("SELECT product_id, name, price FROM products"); // Предполагается, что у вас есть таблица products
    $stmt->execute();
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ошибка базы данных: " . $e->getMessage();
    exit();
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css"> <!-- Подключение CSS -->
    <title>Каталог товаров</title>
</head>
<body>
    <h1>Каталог товаров</h1>
    <table>
        <tr>
            <th>Название</th>
            <th>Цена</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?php echo htmlspecialchars($product['name']); ?></td>
            <td><?php echo htmlspecialchars($product['price']); ?> руб.</td>
            <td>
                <form action="add_to_cart.php" method="post">
                    <input type="hidden" name="id" value="<?php echo $product['id']; ?>">
                    <input type="hidden" name="name" value="<?php echo $product['name']; ?>">
                    <input type="hidden" name="price" value="<?php echo $product['price']; ?>">
                    <input type="submit" value="Добавить в корзину">
                </form>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
    <a href="cart.php">Перейти в корзину</a>
</body>
</html>
