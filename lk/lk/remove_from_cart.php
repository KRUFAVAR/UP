<?php
session_start();

// Проверяем, удаляем ли товар из корзины
if (isset($_POST['id'])) {
    $productId = $_POST['id'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['id'] == $productId) {
            unset($_SESSION['cart'][$key]); // Удаляем товар
            break;
        }
    }
    header("Location: cart.php");
    exit();
}
?>
