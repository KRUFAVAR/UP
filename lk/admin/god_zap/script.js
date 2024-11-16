document.addEventListener("DOMContentLoaded", function() {
    const querySelect = document.getElementById("query-select");
    const queryForm = document.getElementById("query-form");

    // Проверяем, существует ли элемент query-select
    if (querySelect) {
        // Показываем параметры при изменении выбора запроса
        querySelect.addEventListener("change", showQueryParams);

        // Автоматически показываем параметры для уже выбранного запроса
        showQueryParams();  // Вызовем эту функцию, чтобы подгрузить поля сразу после загрузки страницы
    }

    // Проверяем, существует ли форма для отправки запроса
    if (queryForm) {
        queryForm.addEventListener("submit", function(event) {
            event.preventDefault();  // Предотвращаем стандартное поведение формы

            const queryType = document.getElementById("query-select").value;
            const params = new URLSearchParams();

            // Собираем параметры в URL
            params.append("queryType", queryType);

            // Добавляем дополнительные параметры в URL в зависимости от типа запроса
            if (queryType === "1" || queryType === "11") {
                params.append("firstName", document.getElementById("firstName")?.value);
                params.append("lastName", document.getElementById("lastName")?.value);
            } else if (queryType === "2") {
                params.append("priceLimit", document.getElementById("priceLimit")?.value);
            }
            else if (queryType === "3") {
                params.append("username", document.getElementById("username")?.value);
            }
            else if (queryType === "4") {
                params.append("username", document.getElementById("username")?.value);
            }
            else if (queryType === "6") {
                params.append("threshold", document.getElementById("threshold")?.value);
            }
            else if (queryType === "7") {
                params.append("year", document.getElementById("year")?.value);
            }
            else if (queryType === "8"){
                params.append("startDate", document.getElementById("startDate")?.value);
                params.append("endDate", document.getElementById("endDate")?.value);
            }
            else if (queryType === "10") {
                params.append("specialization", document.getElementById("specialization")?.value);
            }
            
            // Перенаправляем на страницу с результатами запроса
            window.location.href = `queryResult.php?${params.toString()}`;
        });
    }
});

// Функция для отображения нужных полей в зависимости от выбранного запроса
function showQueryParams() {
    const queryType = document.getElementById("query-select").value;
    const paramsDiv = document.getElementById("query-params");

    // Очистить предыдущие параметры
    paramsDiv.innerHTML = "";

    // Добавляем поля в зависимости от выбранного запроса
    if (queryType === "1" || queryType === "11") {
        paramsDiv.innerHTML += `<label>Имя мастера: <input type="text" id="firstName"></label>`;
        paramsDiv.innerHTML += `<label>Фамилия мастера: <input type="text" id="lastName"></label>`;
    } else if (queryType === "2") {
        paramsDiv.innerHTML += `<label>Заданная сумма: <input type="number" id="priceLimit"></label>`;
    } else if (queryType === "3") {
        paramsDiv.innerHTML += `<label>Логин клиента: <input type="text" id="username"></label>`;
    } 
    else if (queryType === "4") {
        paramsDiv.innerHTML += `<label>Имя мастера: <input type="text" id="firstName"></label>`;
        paramsDiv.innerHTML += `<label>Фамилия мастера: <input type="text" id="lastName"></label>`;
    } 
    else if (queryType === "6") {
        paramsDiv.innerHTML += `<label>Заданная сумма: <input type="number" id="threshold"></label>`;
    } 
    else if (queryType === "7") {
        paramsDiv.innerHTML += `<label>Заданный год: <input type="number" id="year"></label>`;
    } 
    else if (queryType === "8") {
        paramsDiv.innerHTML += `<label>Дата начала: <input type="date" id="startDate"></label>`;
        paramsDiv.innerHTML += `<label>Дата окончания: <input type="date" id="endDate"></label>`;
    }
    else if (queryType === "10") {
        paramsDiv.innerHTML += `<label>Специализация: <input type="text" id="specialization"></label>`;
    }
    // Добавьте обработку других запросов по аналогии
}
