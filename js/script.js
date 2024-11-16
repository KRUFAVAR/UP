document.addEventListener('DOMContentLoaded', () => {
    const descriptionTab = document.getElementById("dp");
    const additionalInfoTab = document.getElementById("otz");
    const descriptionContent = document.getElementById("mje-content");
    const additionalContent = document.getElementById("dop-content");
    // По умолчанию показываем блок описания и скрываем дополнительную информацию
    additionalContent.style.display = "none";

    // Обработчик для переключения на "Описание"
    descriptionTab.addEventListener("click", function() {
        descriptionContent.style.display = "none";
        additionalContent.style.display = "block";
    });

    // Обработчик для переключения на "Дополнительная информация"
    additionalInfoTab.addEventListener("click", function() {
        descriptionContent.style.display = "block";
        additionalContent.style.display = "none";
    });
    fetchProducts(); // Загружаем продукты, чтобы отобразить только те, что В продаже
    fetchShops(); // Подгружаем магазины из базы данных

    const searchInput = document.getElementById('search-input');
    searchInput.addEventListener('input', filterProducts);

    const shopSelect = document.getElementById('shop-select');
    shopSelect.addEventListener('change', filterProducts);

    const sortSelect = document.getElementById('sort-select');
    sortSelect.addEventListener('change', sortProducts);

    // Обработчик для радиокнопок
    const statusRadios = document.querySelectorAll('input[name="status"]');
    statusRadios.forEach(radio => {
        radio.addEventListener('change', filterProducts);
    });

    // Ползунок для фильтрации по цене
    const priceRange = document.getElementById('price-range');
    const priceValue = document.getElementById('price-value');

    // Обновляем отображение значения ползунка
    priceRange.addEventListener('input', () => {
        priceValue.textContent = `${priceRange.value} руб.`; // Показываем текущее значение
        filterProducts(); // Перезапускаем фильтрацию при изменении значения
    });
    
  
});

let allProducts = []; // Храним все продукты
let allShops = []; // Храним все магазины

async function fetchProducts() {
    try {
        const response = await fetch('api/products.php'); // PHP файл для получения данных о продуктах
        allProducts = await response.json();

        // Отображаем только товары "В продаже" при первой загрузке
        displayProducts(allProducts.filter(product => product.status === 'В продаже'));
    } catch (error) {
        console.error('Ошибка при получении данных:', error);
    }
}

async function fetchShops() {
    try {
        const response = await fetch('api/shops.php'); // PHP файл для получения данных магазинов
        allShops = await response.json();

        const shopSelect = document.getElementById('shop-select');
        allShops.forEach(shop => {
            const option = document.createElement('option');
            option.value = shop.id; // Используем shop.id
            option.textContent = shop.name;
            shopSelect.appendChild(option);
        });
    } catch (error) {
        console.error('Ошибка при получении магазинов:', error);
    }
}
function displayProducts(products) {
    const productsContainer = document.getElementById('products-container');
    productsContainer.innerHTML = ''; // Очищаем контейнер перед отображением

    if (products.length === 0) {
        productsContainer.innerHTML = '<p>Товар появится позже.</p>'; // Сообщение о том, что товары отсутствуют
        return;
    }

    products.forEach(product => {
        const productBlock = document.createElement('div');
        productBlock.className = 'product-block';

        const discount = product.discount ? `<div class="discount">${product.discount}%</div>` : '';

        // Инициализируем переменную imageContent заранее и проверяем наличие photo
        let imageContent = product.photo 
            ? `<div class="product-image" style="background-image: url('./uploads/uploads_produkt/${product.photo}');"></div>`
            : `<div class="product-image placeholder" style="background-color: #ccc;"></div>`;

        productBlock.innerHTML = `
            ${imageContent}
            ${discount}
            <div class="product-name">${product.name}</div>
            <div class="product-price">${product.price} руб.</div>
    
        `;

        // Добавляем обработчик клика для открытия модального окна
        productBlock.addEventListener('click', () => openModal(product.product_id));

        productsContainer.appendChild(productBlock);
    });
}



async function openModal(productId) {
    try {
        const response = await fetch(`api/products.php?id=${productId}`); // Запрашиваем данные о товаре
        const product = await response.json();

        // Заполняем модальное окно данными о товаре
        document.getElementById('modal-product-name').textContent = product.name;
        document.getElementById('modal-product-price').textContent = `${product.price} руб.`;

        const modalImage = document.getElementById('modal-product-image');
        if (product.photo) {
            modalImage.style.backgroundImage = `url('./uploads/uploads_produkt/${product.photo}')`;
        } else {
            modalImage.style.backgroundImage = ''; // Оставляем серый блок
        }

        // Проверяем наличие описания товара
        if (product.op) {
            document.getElementById('modal-product-description').textContent = product.op; // Подставляем описание
        } else {
            document.getElementById('modal-product-description').textContent = 'Описание отсутствует'; // Сообщение об отсутствии описания
        }

        // Добавляем новые поля
        document.getElementById('modal-product-material').textContent = `Материал: ${product.material || 'Не указано'}`;
        document.getElementById('modal-product-weight').textContent = `Вес: ${product.weight || 'Не указан'}`;
        document.getElementById('modal-product-year').textContent = `Год создания: ${product.year_of_creation || 'Не указан'}`;
        document.getElementById('modal-product-sku').textContent = `Артикул: ${product.sku || 'Не указан'}`;
        // Статус
        document.getElementById('modal-product-status').textContent = `Статус: ${product.status || 'Не указан'}`;
        // Скидка
        document.getElementById('modal-product-discount').textContent = `${product.discount ? product.discount + '%' : 'Нет'}`;

        // Получаем названия категории
        await Promise.all([
            fetchCategory(product.category_id),
        ]);

        // Загружаем отзывы для продукта
        const reviewsResponse = await fetch(`api/reviews.php?product_id=${productId}`);
        const reviews = await reviewsResponse.json();

        const reviewsContainer = document.getElementById('modal-reviews-container');
        reviewsContainer.innerHTML = ''; // Очищаем предыдущие отзывы

        if (reviews.length > 0) {
            reviews.forEach(review => {
                const reviewBlock = document.createElement('div');
                reviewBlock.className = 'review-block';
                reviewBlock.innerHTML = `
                    <div class="review-comment">${review.comments}</div>
                    <div class="review-date">${new Date(review.created_at).toLocaleDateString()}</div>
                `;
                reviewsContainer.appendChild(reviewBlock);
            });
        } else {
            reviewsContainer.innerHTML = '<p>Отзывов нет.</p>'; // Сообщение, если отзывов нет
        }

        // Получаем элемент для отображения рейтинга
        const modalRating = document.getElementById('modal-product-rating');
        if (modalRating) {
            modalRating.innerHTML = generateStarRating(product.rating || 0); // Замените 0 на 0, если рейтинга нет
        }

        // Отображаем рейтинг и количество отзывов
        const modalReviewsCount = document.getElementById('modal-reviews-count'); // Убедитесь, что такой элемент существует
        if (modalReviewsCount) {
            modalReviewsCount.textContent = `Количество отзывов: ${product.reviewsCount || 0}`; // Количество отзывов
        }

        // Проверяем, есть ли максимальный рейтинг
        if (product.rating === 5) {
            modalRating.innerHTML += " (Самый высокий рейтинг!)"; // Дополнительное сообщение
        }

        document.getElementById('modal').style.display = 'block'; // Показываем модальное окно
    } catch (error) {
        console.error('Ошибка при загрузке данных о товаре:', error);
    }
}

function generateStarRating(rating) {
    const maxRating = 5; // Максимальное количество звезд
    let starsHTML = '';

    for (let i = 0; i < maxRating; i++) {
        if (i < rating) {
            starsHTML += '★'; // Заполненная звезда
        } else {
            starsHTML += '☆'; // Пустая звезда
        }
    }

    return `${starsHTML}`; // Возвращаем звездный рейтинг и текст
}

// Функция для получения названия категории
async function fetchCategory(categoryId) {
    try {
        const response = await fetch(`api/category.php?id=${categoryId}`); // Предположим, у вас есть этот API
        const category = await response.json();
        document.getElementById('modal-product-category').textContent = `Категория: ${category.name || 'Не указано'}`;
    } catch (error) {
        console.error('Ошибка при загрузке категории:', error);
    }
}

// Функция для получения названия магазина
async function fetchShop(shopId) {
    try {
        const response = await fetch(`api/shops.php?id=${shopId}`); // Предположим, у вас есть этот API
        const shop = await response.json();
        document.getElementById('modal-product-shop').textContent = `Магазин: ${shop.name || 'Не указан'}`;
    } catch (error) {
        console.error('Ошибка при загрузке магазина:', error);
    }
}


// Закрываем модальное окно
document.getElementById('close-modal').addEventListener('click', () => {
    document.getElementById('modal').style.display = 'none';
});
window.onclick = function(event) {
    const modal = document.getElementById('modal');
    if (event.target === modal) {
        modal.style.display = 'none';
    }
};
function filterProducts() {
    const query = document.getElementById('search-input').value.toLowerCase(); // Получаем текст из поля поиска
    const selectedShop = document.getElementById('shop-select').value; // Получаем выбранный магазин

    // Получаем выбранный статус
    const selectedStatus = document.querySelector('input[name="status"]:checked')?.value || 'В продаже';

    // Получаем значение из ползунка
    const priceRange = document.getElementById('price-range').value;

    // Фильтруем продукты на основе статуса, магазина и цены
    const filteredProducts = allProducts.filter(product => {
        const matchesName = product.name.toLowerCase().includes(query);
        
        // Если магазин выбран, фильтруем по нему, иначе учитываем все магазины
        const matchesShop = selectedShop ? product.shop_id == Number(selectedShop) : true; 
        
        // Фильтрация по статусу
        const matchesStatus = (selectedStatus === 'В продаже' && product.status === 'В продаже') ||
                              (selectedStatus === 'Нет в наличии' && product.status === 'Нет в наличии');
        
        // Фильтрация по цене: если ползунок равен 0, показываем все продукты с ценой >= 0
        const matchesPrice = priceRange == 0 ? product.price >= 0 : product.price <= priceRange;

        return matchesName && matchesShop && matchesStatus && matchesPrice; // Возвращаем только те продукты, которые соответствуют имени, магазину, статусу и цене
    });

    displayProducts(filteredProducts); // Отображаем отфильтрованные продукты
}

function sortProducts() {
    const sortValue = document.getElementById('sort-select').value; // Получаем значение сортировки
    let filteredProducts = [...allProducts]; // Копируем массив всех продуктов для сортировки

    // Фильтрация продуктов на основе выбранного статуса и магазина
    const selectedShop = document.getElementById('shop-select').value; // Получаем выбранный магазин
    const selectedStatus = document.querySelector('input[name="status"]:checked')?.value || 'В продаже';

    filteredProducts = filteredProducts.filter(product => {
        return (selectedStatus === 'В продаже' && product.status === 'В продаже') ||
               (selectedStatus === 'Нет в наличии' && product.status === 'Нет в наличии');
    });

    // Если магазин выбран, фильтруем по нему, иначе учитываем все магазины
    if (selectedShop) {
        filteredProducts = filteredProducts.filter(product => product.shop_id == Number(selectedShop));
    }

    // Сортировка
    if (sortValue === 'asc') {
        filteredProducts.sort((a, b) => a.price - b.price); // Сортировка по возрастанию цены
    } else if (sortValue === 'desc') {
        filteredProducts.sort((a, b) => b.price - a.price); // Сортировка по убыванию цены
    }

    displayProducts(filteredProducts); // Отображаем отсортированные продукты
}
