function toggleForms() {
    const loginForm = document.getElementById("login-form");
    const registerForm = document.getElementById("register-form");

    if (loginForm.style.display === "none") {
        loginForm.style.display = "block";
        registerForm.style.display = "none";
    } else {
        loginForm.style.display = "none";
        registerForm.style.display = "block";
    }
}


document.addEventListener("DOMContentLoaded", function() {
    fetchUserData();
});

function fetchUserData() {
    fetch('api/user_dashboard.php')
        .then(response => {
            if (!response.ok) {
                throw new Error("Ошибка при загрузке данных");
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                alert(data.error);
                return;
            }
            displayUserInfo(data.user);
            displayUserReviews(data.reviews);
            displayUserPayments(data.payments);
            displayUserLogs(data.logs);
        })
        .catch(error => console.error("Ошибка:", error));
}

function displayUserInfo(user) {
    document.getElementById("username").textContent = user.username;
    document.getElementById("user-email").textContent = user.email;
    document.getElementById("user-phone").textContent = user.phone_number || "Не указан";
}

function displayUserReviews(reviews) {
    const reviewsList = document.querySelector(".reviews-list");
    reviewsList.innerHTML = "";
    reviews.forEach(review => {
        const reviewItem = document.createElement("div");
        reviewItem.classList.add("review-item");
        reviewItem.innerHTML = `<strong>${review.product_name}</strong>: ${review.review_text} (${review.rating} из 5)`;
        reviewsList.appendChild(reviewItem);
    });
}

function displayUserPayments(payments) {
    const paymentsList = document.querySelector(".payments-list");
    paymentsList.innerHTML = "";
    payments.forEach(payment => {
        const paymentItem = document.createElement("div");
        paymentItem.classList.add("payment-item");
        paymentItem.innerHTML = `Дата: ${payment.payment_date}, Сумма: ${payment.amount} ₽`;
        paymentsList.appendChild(paymentItem);
    });
}

function displayUserLogs(logs) {
    const logsList = document.querySelector(".logs-list");
    logsList.innerHTML = "";
    logs.forEach(log => {
        const logItem = document.createElement("div");
        logItem.classList.add("log-item");
        logItem.innerHTML = `${log.action} - ${log.action_date}`;
        logsList.appendChild(logItem);
    });
}
