<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Авторизация</title>
    <script src="https://www.google.com/recaptcha/enterprise.js?render=6LckA4gqAAAAAJ4WGaSOptDeDFYbp7xYPwXzf8xd"></script>
	<script>
	    function onSubmit(e) {
	        e.preventDefault();

	        grecaptcha.enterprise.ready(async () => {
	            try {
	                // Генерация токена с помощью публичного ключа
	                const token = await grecaptcha.enterprise.execute('6LckA4gqAAAAAJ4WGaSOptDeDFYbp7xYPwXzf8xd', { action: 'LOGIN' });

	                if (!token) {
	                    alert("Не удалось получить токен reCAPTCHA. Попробуйте снова.");
	                    return;
	                }

	                // Присваиваем токен скрытому полю
	                document.getElementById('recaptcha_token').value = token;

	                // Отправляем форму
	                document.getElementById('loginForm').submit();
	            } catch (err) {
	                console.error("Ошибка reCAPTCHA:", err);
	                alert("Ошибка при проверке reCAPTCHA. Попробуйте позже.");
	            }
	        });
	    }
	</script>

</head>
<?php
require 'login-processing.php';
?>
<body>
    <h1>Авторизация</h1>
    <form id="loginForm" method="POST" action="login.php" onsubmit="onSubmit(event)">
	    <label for="identifier">Email или Телефон:</label>
	    <input type="text" id="identifier" name="identifier" required>
	    <br>

	    <label for="password">Пароль:</label>
	    <input type="password" id="password" name="password" required>
	    <br>

	    <!-- Скрытое поле для передачи токена reCAPTCHA -->
	    <input type="hidden" id="recaptcha_token" name="recaptcha_token">

	    <button type="submit">Войти</button>
	</form>

</body>
</html>
