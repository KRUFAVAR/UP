<?php
session_start();
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



// Извлечение списка продуктов
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);



?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Управление товарами</title>
    <style>
    /* Общие настройки */
    body {
    font-family: Arial, sans-serif;
    background-color: #f9f9f9;
    color: #333;
    margin: 0;
    padding: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
}

h1 {
    color: #444;
    margin: 20px;
}

table {
    border-collapse: collapse;
    width: 90%;
    margin-bottom: 20px;
}

table th, table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

table th {
    background-color: #f1f1f1;
    color: #555;
}

table td img {
    max-width: 50px;
    height: auto;
    border-radius: 4px;
}

button {
    padding: 8px 12px;
    margin: 5px;
    border: none;
    border-radius: 4px;
    background-color: #007bff;
    color: white;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

button:hover {
    background-color: #0056b3;
}

.modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.4);
    justify-content: center;
    align-items: center;
    z-index: 10;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
    animation: fadeIn 0.3s ease-out;
}

@keyframes fadeIn {
    from {
        transform: scale(0.9);
        opacity: 0;
    }
    to {
        transform: scale(1);
        opacity: 1;
    }
}

.modal-content h2 {
    margin: 0 0 10px;
    color: #333;
}

.modal-content label {
    display: block;
    margin: 10px 0 5px;
    color: #555;
}

.modal-content input,
.modal-content select,
.modal-content textarea {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 14px;
}

.modal-content button {
    width: 100%;
    background-color: #28a745;
}

.modal-content button:hover {
    background-color: #218838;
}

.close {
    position: absolute;
    top: 10px;
    right: 10px;
    font-size: 20px;
    cursor: pointer;
    color: #aaa;
}

.close:hover {
    color: #333;
}
a{
    text-decoration: none;
    color: white;
}

    </style>
</head>
<body>

<h1>Управление товарами</h1>
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Название</th>
            <th>Цена</th>
            <th>Фото</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
            <tr>
                <td><?= htmlspecialchars($product['product_id']) ?></td>
                <td><?= htmlspecialchars($product['name']) ?></td>
                <td><?= htmlspecialchars($product['price']) ?></td>
                <td><img src="../../uploads/uploads_produkt/<?= htmlspecialchars($product['photo']) ?>" style="width:50px;height:auto;"></td>
                <td>
                    <button onclick="viewProduct(<?= htmlspecialchars($product['product_id']) ?>)">Подробнее</button>
                    <button onclick="openEditModal(<?= htmlspecialchars($product['product_id']) ?>)">Редактировать</button>
                    <button onclick="deleteProduct(<?= htmlspecialchars($product['product_id']) ?>)">Удалить</button>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
<!-- Модальное окно для просмотра -->
<div id="productModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('productModal')">&times;</span>
        <h2>Информация о товаре</h2>
        <div id="productDetails"></div>
    </div>
</div>

<!-- Модальное окно для редактирования -->
<div id="editModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('editModal')">&times;</span>
        <h2>Редактирование товара</h2>
        <form id="editForm" enctype="multipart/form-data">
            <input type="hidden" name="product_id" id="editProductId">
            <label>Название:</label>
            <input type="text" name="name" id="editName" required>
            <label>Цена:</label>
            <input type="number" name="price" id="editPrice" required>
            <label>Материал:</label>
            <input type="text" name="material" id="editMaterial" required>
            <label>Вес:</label>
            <input type="number" name="weight" id="editWeight" required>
            <label>Артикул:</label>
            <input type="text" name="sku" id="editSku" required>
            <label>Статус:</label>
            <select name="status" id="editStatus" required>
                <option value="В продаже">В продаже</option>
                <option value="В наличии">В наличии</option>
                <option value="Нет в наличии">Нет в наличии</option>
            </select>
            <label>Скидка:</label>
            <input type="number" name="discount" id="editDiscount" step="0.01" value="0">
            <label>Описание:</label>
            <textarea name="op" id="editOp"></textarea>
            <label>Фото:</label>
            <input type="file" name="photo" id="editPhoto">
            <button type="button" onclick="saveChanges()">Сохранить изменения</button>
        </form>
    </div>
</div>
<button onclick="openAddModal()">Добавить товар</button>
<button><a href="index.php">Назад</a></button>
<!-- Модальное окно для добавления товара -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('addModal')">&times;</span>
        <h2>Добавление товара</h2>
        <form id="addForm" enctype="multipart/form-data">
            <label>Название:</label>
            <input type="text" name="name" id="addName" required>
            <label>Цена:</label>
            <input type="number" name="price" id="addPrice" required>
            <label>Материал:</label>
            <input type="text" name="material" id="addMaterial" required>
            <label>Вес:</label>
            <input type="number" name="weight" id="addWeight" required>
            <label>Артикул:</label>
            <input type="text" name="sku" id="addSku" required>
            <label>Статус:</label>
            <select name="status" id="addStatus" required>
                <option value="В продаже">В продаже</option>
                <option value="В наличии">В наличии</option>
                <option value="Нет в наличии">Нет в наличии</option>
            </select>
            <label>Скидка:</label>
            <input type="number" name="discount" id="addDiscount" step="0.01" value="0">
            <label>Описание:</label>
            <textarea name="op" id="addOp"></textarea>
            <label>Фото:</label>
            <input type="file" name="photo" id="addPhoto" required>
            <button type="button" onclick="addProduct()">Добавить товар</button>
        </form>
    </div>
</div>


<script>
    function viewProduct(productId) {
        fetch(`get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('productDetails').innerHTML = `
                    <p><b>Название:</b> ${data.name}</p>
                    <p><b>Цена:</b> ${data.price}</p>
                    <p><b>Материал:</b> ${data.material}</p>
                    <p><b>Вес:</b> ${data.weight}</p>
                    <p><b>Артикул:</b> ${data.sku}</p>
                    <p><b>Статус:</b> ${data.status}</p>
                    <p><b>Скидка:</b> ${data.discount}%</p>
                    <p><b>Описание:</b> ${data.op}</p>
                    <p><b>Год создания:</b> ${data.year_of_creation}</p>
                    <img src="../../uploads/uploads_produkt/${data.photo}" style="width:100px;height:auto;">
                `;
                document.getElementById('productModal').style.display = 'flex';
            });
    }

    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
    }
    function addProduct() {
    const formData = new FormData(document.getElementById('addForm'));
    fetch('add_product.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Товар успешно добавлен.");
            location.reload(); // Перезагружаем страницу для обновления списка
        } else {
            alert("Ошибка при добавлении товара: " + data.error);
        }
    })
    .catch(error => {
        console.error("Ошибка:", error);
        alert("Произошла ошибка при добавлении товара.");
    });
}function openAddModal() {
    document.getElementById('addModal').style.display = 'flex';
}
    function openEditModal(productId) {
        fetch(`get_product.php?id=${productId}`)
            .then(response => response.json())
            .then(data => {
                document.getElementById('editProductId').value = data.product_id;
                document.getElementById('editName').value = data.name;
                document.getElementById('editPrice').value = data.price;
                document.getElementById('editMaterial').value = data.material;
                document.getElementById('editWeight').value = data.weight;
                document.getElementById('editSku').value = data.sku;
                document.getElementById('editStatus').value = data.status;
                document.getElementById('editDiscount').value = data.discount;
                document.getElementById('editOp').value = data.op;
                document.getElementById('editModal').style.display = 'flex';
            });
    }

    function saveChanges() {
    const form = document.getElementById('editForm');
    const formData = new FormData(form);

    // Убедимся, что данные отправляются
    fetch('update_product.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert("Данные успешно обновлены.");
            closeModal('editModal'); // Закрываем модальное окно
            location.reload(); // Перезагружаем таблицу
        } else {
            alert("Ошибка при сохранении изменений: " + data.error);
        }
    })
    .catch(error => {
        console.error("Ошибка:", error);
        alert("Произошла ошибка при сохранении изменений.");
    });
}


    function deleteProduct(productId) {
    if (confirm("Вы уверены, что хотите удалить этот товар?")) {
        fetch('delete_product.php', {
            method: 'POST', // Метод должен быть POST
            headers: {
                'Content-Type': 'application/json' // Устанавливаем тип контента
            },
            body: JSON.stringify({ id: productId }) // Отправляем ID в JSON-формате
        })
        .then(response => {
            if (!response.ok) throw new Error("Ошибка сети");
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert("Товар успешно удален.");
                location.reload(); // Перезагружаем страницу после удаления
            } else {
                alert("Ошибка: " + data.error);
            }
        })
        .catch(error => {
            console.error("Ошибка:", error);
            alert("Произошла ошибка при удалении товара.");
        });
    }
}


</script>

</body>
</html>
