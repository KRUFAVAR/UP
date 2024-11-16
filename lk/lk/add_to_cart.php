<?php
session_start();

// Проверяем, добавлен ли товар в корзину
if (isset($_POST['id'])) {
    $productId = $_POST['id'];
    $productName = $_POST['name']; // Название товара
    $productPrice = $_POST['price']; // Цена товара
    $quantity = 1; // Количество по умолчанию

    // Проверяем, есть ли уже товар в корзине
    $found = false;
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] += $quantity; // Увеличиваем количество
            $found = true;
            break;
        }
    }

    // Если товара нет в корзине, добавляем его
    if (!$found) {
        $_SESSION['cart'][] = [
            'id' => $productId,
            'name' => $productName,
            'price' => $productPrice,
            'quantity' => $quantity
        ];
    }

    header("Location: cart.php");
    exit();
}
?>
