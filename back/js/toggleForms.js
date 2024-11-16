document.addEventListener('DOMContentLoaded', () => {
    const openModalButton = document.getElementById('openReviewsModal');
    const reviewsModal = document.getElementById('reviewsModal');
    const closeModalButton = document.querySelector('.close');

    // Открытие модального окна
    openModalButton.onclick = function() {
        reviewsModal.style.display = "block";
    }

    // Закрытие модального окна
    closeModalButton.onclick = function() {
        reviewsModal.style.display = "none";
    }

    // Закрытие модального окна при клике вне его
    window.onclick = function(event) {
        if (event.target === reviewsModal) {
            reviewsModal.style.display = "none";
        }
    }

    // Обработка изменения и удаления отзывов
    document.querySelectorAll('.editReviewBtn').forEach(button => {
        button.addEventListener('click', (event) => {
            const reviewId = event.target.closest('.review').dataset.reviewId;
            // Логика для изменения отзыва (например, открыть форму для редактирования)
            console.log('Изменить отзыв ID:', reviewId);
        });
    });

    document.querySelectorAll('.deleteReviewBtn').forEach(button => {
        button.addEventListener('click', (event) => {
            const reviewId = event.target.closest('.review').dataset.reviewId;
            // AJAX запрос на удаление отзыва
            console.log('Удалить отзыв ID:', reviewId);
        });
    });
});
