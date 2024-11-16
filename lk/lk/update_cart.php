<?php
session_start();

// Проверяем, обновляем ли количество товара
if (isset($_POST['id']) && isset($_POST['quantity'])) {
    $productId = $_POST['id'];
    $quantity = $_POST['quantity'];

    foreach ($_SESSION['cart'] as &$item) {
        if ($item['id'] == $productId) {
            $item['quantity'] = $quantity; // Обновляем количество
            break;
        }
    }
    header("Location: cart.php");
    exit();
}
?>
